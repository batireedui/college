<?php
require ROOT . '/pages/api/header.php';
require ROOT . '/pages/api/css.php';
if(isset($_GET["token"]))
{
    $userinfo = _teacherAuth($_GET["token"]);
    if(!empty($userinfo)){
        $user_id = $userinfo['id'];
    
    _select(
        $stmt,
        $count,
        "SELECT id, sname, name, hugacaa, tuluv, teacherid FROM class WHERE class.tuluv=? ORDER BY sname",
        "i",
        ['1'],
        $id,
        $sname,
        $name,
        $hugacaa,
        $tuluv,
        $teacherid
    );
    ?>
    <div>
        <div id="table">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th>Анги</th>
                        <th>Хичээл заах</th>
                    </tr>
                </thead>
                <?php if ($count > 0) : ?>
                    <?php $too = 0;
                    while (_fetch($stmt)) :
                        $tc_id = "0";
                        _selectRowNoParam(
                            "SELECT id FROM tclass WHERE tid='$user_id' and classid = '$id'",
                            $tc_id
                        );
                        $too++ ?>
                        <tr>
                            <td><?= $too ?></td>
                            <td id="f1-<?= $id ?>"><?= $sname ?> <?= $name ?></td>
                            <td id="f2-<?= $id ?>">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" onclick="change(<?= $id ?>, this)" <?php echo $tc_id > 0 ? "checked" : "" ?> />
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <?php
    require ROOT . "/pages/footer.php"; ?>
    <script>
        function tshow() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl)
            })
            toastList.forEach(toast => toast.show())
        }
    
        function change(id, tuluv) {
            console.log(tuluv.checked);
    
            $.ajax({
                url: "/tclass/ajax",
                type: "POST",
                data: {
                    angi_id: id,
                    tuluv: tuluv.checked
                },
                error: function(xhr, textStatus, errorThrown) {},
                beforeSend: function() {},
                success: function(data) {
                    $('#toastbody').html(data);
                    tshow();
                },
                async: true
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<?php
require ROOT . "/pages/end.php";
}
    else echo "noAuth";
}
else echo "tokenExpired";
?>