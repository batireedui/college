<?php
$date = date('Y-m-d');
if (isset($_GET['date'])) $date = $_GET['date'];

_selectNoParam(
    $cstmt,
    $ccount,
    "SELECT id, name, inter FROM cag",
    $id,
    $name,
    $inter
);

$cagArr = [];

while (_fetch($cstmt)) {
    $item = new stdClass();
    $item->id = $id;
    $item->name = $name;
    $item->inter = $inter;
    array_push($cagArr, $item);
}

_selectNoParam(
    $stmt,
    $count,
    "SELECT id, name FROM class WHERE tuluv = 1",
    $cid,
    $cname
);

$classArr = [];

while (_fetch($stmt)) {
    $item = new stdClass();
    $item->cid = $cid;
    $item->cname = $cname;
    array_push($classArr, $item);
}

?>

<div>
    <form>
        <div class="row mb-3 p-3">
            <div class="col-md">
                <h3>ИРЦ БҮРТГЭЛ</h3>
            </div>
            <div class="col-md">
                <input type="date" class="form form-control mb-3" name="date" value="<?= $date ?>" autocompleted />
            </div>
            <div class="col-md-2">
                <button class="btn btn-warning w-100" type="submit">ХАРАХ</button>
            </div>
        </div>
    </form>
    <div id="table">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>Анги</th>
                    <?php
                    foreach ($cagArr as $el) {
                        echo "<th style='text-align: center'>$el->name <br> <span style='font-size: 10px'>$el->inter</span></th>";
                    }
                    ?>
                </tr>
            </thead>
            <?php
            $k = 0;
            foreach ($classArr as $cel) : $k++ ?>
                <tr>
                    <td style='text-align: center'><?= $k ?></td>
                    <td><?= $cel->cname ?></td>
                    <?php
                    foreach ($cagArr as $el) :
                        $echo = "";
                        $check = 0;
                        _selectRowNoParam(
                            "SELECT id, niit, v1 FROM att WHERE ognoo = '$date' and classid = '$cel->cid' and cagid='$el->id'",
                            $check,
                            $niit,
                            $v1
                        );
                        if ($check > 0) {
                            $huvi = 0;
                            if ($v1 != 0 && $niit != 0)
                                $huvi = round($v1 / $niit * 100);
                            $echo = "<i class='fa-solid fa-circle-check text-success' data-mdb-toggle='modal' data-mdb-target='#detial' role='button' onclick='detial($check)'></i> $huvi%";
                        }
                    ?>
                        <td style='text-align: center'>
                            <?= $echo ?>
                        </td>
                    <?php
                    endforeach
                    ?>
                </tr>
            <?php
            endforeach
            ?>
        </table>
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
    function detial(id) {
        row_click(id)
        $.ajax({
            url: "../att/detial",
            type: "POST",
            data: {
                mode: 2,
                id: id
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#modal-body").html("Алдаа гарлаа !");
            },
            beforeSend: function() {
                $('#modal-body').html("Түр хүлээнэ үү ...");
            },
            success: function(data) {
                $('#modal-body').html(data);
            },
            async: true
        });
    }
</script>