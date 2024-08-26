<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

_selectNoParam(
    $st, 
    $ct,
    "SELECT teacher.id, teacher.fname, teacher.lname, phone, at, user_role FROM `teacher` WHERE tuluv = 1 ORDER BY lname",
    $id, $fname, $lname, $phone, $at, $user_role)
?>
<link rel="stylesheet" type="text/css" href="/css/dataTable.css">
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
    .btn-check {
        position: absolute;
        clip: rect(0, 0, 0, 0);
        pointer-events: none;
    }
</style>
        <div class="p-3 bg-light d-flex justify-content-between align-items-center">
            <h3>Зар илгээх <?php ?></h3>
        </div>
<div class="row">
    <div class="col">
        <div class="row mb-3">
            <div class="">
                <label>Гарчиг</label>
                <input type="text" id="title" class="form form-control"/>
            </div>
            <div class="">
                <label>Мэдээлэл</label>
                <input type="text" id="body" class="form form-control"/>
            </div>
            <div class="">
                <label></label>
                <button class="btn btn-warning w-100" onclick="send()">ИЛГЭЭХ</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md">
                <button class="btn btn-success w-100" onclick="selects()">БҮГДИЙГ СОНГОХ</button>
            </div>
            <div class="col-md">
                <button class="btn btn-danger w-100" onclick="deSelect()">СОНГОЛТ ЦУЦЛАХ</button>
            </div>
        </div>
    </div>
    <div class="col">
        <table class="table table-bordered table-hover"  id="datalist">
            <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>Нэрс</th>
                </tr>
            </thead>
            <?php
            while(_fetch($st)){?>
            <tr role="button">
                <td>
                    <input type="checkbox" class="btn-check" id="<?=$id?>" value="<?=$id?>" autocomplete="off">
                    <label class="btn btn-outline-primary m-1" for="<?=$id?>">
                    </label>
                </td>
                <td>
                    <small><?=$lname?> (<?=$fname?>) </small>
                </td>
            </tr>
            <?php }
            ?>
        </table>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
        $(document).ready(function() {
          $('#datalist tr').click(function(event) {
            if (event.target.type !== 'checkbox') {
              $(':checkbox', this).trigger('click');
            }
          });
        });
        function selects(){  
                var ele=document.getElementsByClassName('btn-check');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='checkbox')  
                        ele[i].checked=true;  
                }  
            }  
            function deSelect(){  
                var ele=document.getElementsByClassName('btn-check');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='checkbox')  
                        ele[i].checked=false;  
                      
                }  
            }
            
            function send(){
                let users = [];
                $( ".btn-check" ).each( function () 
                {
                    if ( $(this).prop( "checked" ) ) 
                    {
                        users.push( $(this).val() );
                    }
                });
                console.log(users);
                let title = $( "#title" ).val();
                let body = $( "#body" ).val();
                if(body == "" || title == "")
                {
                    alert("Мэдээлэл оруулна уу!");
                }
                else{
                    if(users.length > 0){
                        $.ajax({
                            url: "/noti/ajax",
                            type: "POST",
                            data: {
                                mode: 1,
                                title: title,
                                body: body,
                                users: users
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                $("#action").html("Алдаа гарлаа !");
                            },
                            beforeSend: function() {
                                $('#action').html("Түр хүлээнэ үү ...");
                            },
                            success: function(res) {
                                $.ajax({
                                    url: "/api/sendnoti",
                                    type: "POST",
                                    data: {
                                        mode: 3,
                                        title: title,
                                        body: body,
                                        users: users,
                                        noti_teachers: 1
                                    },
                                    error: function(xhr, textStatus, errorThrown) {
                                        console.log("Алдаа гарлаа");
                                    },
                                    beforeSend: function() {
                                        console.log("Түр хүлээнэ үү");
                                    },
                                    success: function(data) {
                                        console.log(data);
                                    },
                                    async: true
                                });
                                $('#action').html(res);
                            },
                            async: true
                        });
                    }
                    else alert("Илгээх хэрэглэгчид сонгоно уу!");
                }
            }
</script>
<?php
require ROOT . "/pages/dataTablefooter.php";
require ROOT . "/pages/end.php";
?>