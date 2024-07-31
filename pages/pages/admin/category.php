<?php require 'start.php'; ?>
<?php require 'header.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">АНГИЛАЛ, МЭДЭЭЛЭЛ ЗАСВАРЛАХ</p>
                         <div style="text-align: right; margin-top: 20px;">
                            <a href='/admin/addpage/categoryAdd'>
                            <button type="button" class="btn btn-primary">
                                АНГИЛАЛ НЭМЭХ
                            </button>
                            </a>
                        </div>
                        <?php
                        _selectNoParam(
                            $cstmt,
                            $ccount,
                            "SELECT id, name, medeelel, tuluv FROM category",
                            $cid,
                            $cname,
                            $body,
                            $tuluv
                        );?>
                        <div class="table-responsive pt-3">
                        <table class='table table-bordered' style="width: 100%">
                        <thead>
                            <th></th>
                            <th>Нэр</th>
                            <th>Төлөв</th>
                            <th colspan="2">Үйлдэл</th>
                        </thead>
                        <?php
                        $too = 1;
                        while (_fetch($cstmt)) {
                            echo "<tr>
                                    <td>$too</td>
                                    <td>$cname</td>";
                            echo $tuluv == "1" ? 
                                    "<td>
                                        <button type='button' class='btn btn-success btn-sm'>
                                            Идэвхтэй
                                        </button>
                                    </td>" : 
                                    "<td>
                                        <button type='button' class='btn btn-dark btn-sm'>
                                            Идэвхгүй
                                        </button>
                                    </td>";
                            echo "<td><a href='/admin/addpage/categoryAdd?cateid=$cid'>
                                        <button type='button' class='btn btn-outline-info btn-icon-text btn-sm'>Засах
                                            <i class='ti-file btn-icon-append'></i>                          
                                        </button></a></td>
                                </tr>";
                            $too++;
                            }
                        ?>
                        </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php require 'footer.php'; ?>
            <script type="text/javascript">
                function editM(id, name) {
                    console.log("ok"+name);
                    document.querySelector('#menuidedit').value = id;
                    document.querySelector('#menutitleedit').value = name;
                }
                /*
                function editM(modalID) {

                    if (modalID) {
                        document.querySelector('#MenuIDedit').value = modalID;
                        $.ajax({
                            url: '/api/menuEdit',
                            type: "POST",
                            data: {
                                'id': modalID
                            },
                            error: function(request, error) {
                                console.log(request);
                                alert(" Can't do because: " + error);
                            },
                            success: function(data) {
                                $('#editTitle').val(data.title);
                                $('#editimgurl').val(data.imgurl);
                                const $selecte = document.querySelector('#editmenuid');
                                document.querySelector('#editmenuid').value = data.menuid;
                                EditEditor.setData(data.body);
                            }
                        });
                    } else {
                        console.log(modalID + " no");
                    }
                };*/
            </script>
            <?php require 'end.php'; ?>