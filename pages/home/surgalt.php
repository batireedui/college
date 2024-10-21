<?php
if (checkErh(9, $user_role, $user_id) || checkErh(10, $user_role, $user_id))  {
    $date = date('Y-m-d');
?>

    <div>
        <div class="alert alert-info m-3">
            <?= $this_on ?> ХИЧЭЭЛИЙН ЖИЛ
        </div>
        <div class="row mb-3 p-3">
            <div class="col-md">
                <h3>ЦАГ/ИРЦ БҮРТГЭЛ</h3>
            </div>
            <div class="col-md">
                <select class="form-control" id="turul">
                    <?php if (checkErh(9, $user_role, $user_id)) { ?>
                        <option value="2">Суралцагчдын ирц бүртгэл</option>
                    <?php }
                    if (checkErh(10, $user_role, $user_id)) { ?>
                        <option value="1">Багш, ажилтны цаг бүртгэл</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md">
                <input type="date" class="form form-control mb-3" name="date" id="date_get" value="<?= $date ?>" autocompleted />
            </div>
            <div class="col-md-2">
                <button class="btn btn-warning w-100" type="button" onclick="get_student()" id="show">ХАРАХ</button>
            </div>
        </div>
        <div id="main">

        </div>
    </div>
    <div class="modal fade" id="detial" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detialLabel">ИРЦ БҮРТГЭЛ</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        function get_student() {
            $("#show").attr("disabled", true);
            let url = "/home/student-home";
            if ($('#turul').val() == 1) {
                url = "/home/time-home";
            }
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    date: $('#date_get').val()
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#main").html("<div style='text-align: center;'>Алдаа гарлаа !</div>");
                    $("#show").removeAttr("disabled");
                },
                beforeSend: function() {
                    $('#main').html("<div class='loadText'><div class='loader'></div>Түр хүлээнэ үү ...</div>");
                },
                success: function(data) {
                    $('#main').html(data);
                    $("#show").removeAttr("disabled");
                },
                async: true
            });
        }



        function detial(id) {
            console.log(id);
            row_click(id)
            $.ajax({
                url: "/att/detial",
                type: "POST",
                data: {
                    mode: 2,
                    id: id
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#modal-body").html("<div style='text-align: center;'>Алдаа гарлаа !</div>");
                },
                beforeSend: function() {
                    $('#modal-body').html("<div style='text-align: center;'>Түр хүлээнэ үү ...</div>");
                },
                success: function(data) {
                    $('#modal-body').html(data);
                },
                async: true
            });
        }
    </script>
<?php } else echo "Хандах эрх хүрэлцэхгүй байна"; ?>