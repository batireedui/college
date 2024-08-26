<?php
_selectNoParam(
    $stmt,
    $count,
    "SELECT att.id, class.name, tlesson.lessonName, cag.name, cag.inter, ognoo, att.lessonid, class.sname, att.tuluv, tlesson.cag FROM att 
        INNER JOIN class ON att.classid = class.id 
            INNER JOIN tlesson ON att.lessonid = tlesson.id 
                INNER JOIN cag ON att.cagid = cag.id 
                    WHERE att.this_on = '" . $this_on . "' and att.tid = '" . $_SESSION['user_id'] . "' ORDER BY ognoo DESC , cag.name DESC LIMIT 10",
    $id,
    $class,
    $lesson,
    $cag,
    $cag_inter,
    $ognoo,
    $lessonid,
    $sname,
    $atttuluv,
    $lcag
);

$zaasanArr = [];
while (_fetch($stmt)) {
    $item = new stdClass;
    $item->id = $id;
    $item->class = $class;
    $item->lesson = $lesson;
    $item->cag = $cag;
    $item->cag_inter = $cag_inter;
    $item->ognoo = $ognoo;
    $item->lessonid = $lessonid;
    $item->sname = $sname;
    $item->atttuluv = $atttuluv;
    $item->lcag = $lcag;
    array_push($zaasanArr, $item);
}

$lessonArr = array();
$lessonNameArr = array();
_selectNoParam(
    $gstmt,
    $gcount,
    "SELECT lessonid, classid, sname FROM `att` INNER JOIN class ON att.classid = class.id WHERE att.this_on = '" . $this_on . "' and tid = '" . $_SESSION['user_id'] . "'  GROUP BY classid, lessonid",
    $glessonid,
    $gclassid,
    $sname
);


$orson = [];
$uldsen = [];
while (_fetch($gstmt)) {
    $gcag = 0;
    _selectRowNoParam(
        "SELECT cag, lessonName FROM `tlesson` WHERE id = '" . $glessonid . "'",
        $gcag,
        $glessonName
    );

    $gtoo = 0;
    _selectRowNoParam(
        "SELECT COUNT(id) from att WHERE att.this_on = '" . $this_on . "' and lessonid = '$glessonid,' and classid = '$gclassid' and tid = " . $_SESSION['user_id'],
        $gtoo
    );
    array_push($orson, $gtoo * 2);
    array_push($uldsen, $gcag - $gtoo * 2);

    array_push($lessonNameArr, $sname . " " . $glessonName);
}

$gra = new stdClass;
$gra->name = "Орсон";
$gra->data = $orson;
array_push($lessonArr, $gra);
$gra = new stdClass;
$gra->name = "Үлдсэн";
$gra->data = $uldsen;
array_push($lessonArr, $gra);
?>

<div>
    <div class="alert alert-info m-3">
       <?=$this_on ?> ХИЧЭЭЛИЙН ЖИЛ
    </div>
    <div class="bg-light d-flex justify-content-between align-items-center m-2">
       СҮҮЛИЙН ХИЧЭЭЛ ОРОЛТУУД (10)
    </div>
    <div id="table">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>Анги</th>
                    <th>Хичээл</th>
                    <th>Цаг</th>
                    <th>Төлөв</th>
                </tr>
            </thead>
            <?php $too = 0;
            foreach ($zaasanArr as $el) :
                $too++ ?>
                <tr class="table_rows" id="trow-<?= $el->id ?>">
                    <td><?= $too ?></td>
                    <td id="f1-<?= $el->id  ?>" data-mdb-toggle="modal" data-mdb-target="#detial" role="button" onclick="detial(<?= $el->id ?>)"><?= $el->sname ?> <?= $el->class ?></td>
                    <td id="f2-<?= $el->id  ?>" data-mdb-toggle="modal" data-mdb-target="#detial" role="button" onclick="detial(<?= $el->id ?>)"><?= $el->lesson ?> (<?= $el->lcag ?> цаг)</td>
                    <td id="f3-<?= $el->id  ?>" data-mdb-toggle="modal" data-mdb-target="#detial" role="button" onclick="detial(<?= $el->id ?>)"><?= str_replace("-", ".",  $el->ognoo) ?>, <?= dayofweek($el->ognoo); ?>, <?= $el->cag ?> (<?= $el->cag_inter ?>)</td>
                    <td style="text-align: center"><?php
                        echo $el->atttuluv == 1 ?
                            "<i class='fa-solid fa-circle-check text-success'></i>" :
                            "<span class='alert alert-danger' role='button'
                            data-mdb-toggle='modal' data-mdb-target='#deleteModal'
                            onclick='deleteAtt(" . $el->id . ")'
                            >Устгах</span>";
                        ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <div style="text-align: end">
            <a href="/report/list" role="button" class="btn btn-primary">ДЭЛГЭРЭНГҮЙ</a>
        </div>
        <div class="p-3 bg-light d-flex justify-content-between align-items-center">
            ЦАГИЙН ГҮЙЦЭТГЭЛ
        </div>
        <div id="chart"></div>
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
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLabel">ИРЦ БҮРТГЭЛ УСТГАХ</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-dbody">
                
            </div>
            <input type="text" style="display: none;" id="deleteId"/>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Болих</button>
                <button type="button" class="btn btn-danger" onclick="attDelete()">Устгах</button>
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
    };

    function deleteAtt(id) {
        row_click(id)
        $('#deleteId').val(id);
        $('#modal-dbody').html($('#f1-' + id).text() + ' ангид ' + $('#f3-' + id).text() + ' орсон ' + $('#f2-' + id).text() + ' хичээлийн ирц бүртгэл утсгах уу?');
    }

    function attDelete() {
        $.ajax({
            url: "../att/ajax",
            type: "POST",
            data: {
                mode: 4,
                attid: $('#deleteId').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#modal-dbody").html("Алдаа гарлаа !");
            },
            beforeSend: function() {
                $('#modal-dbody').html("Түр хүлээнэ үү ...");
            },
            success: function(data) {
                location.reload();
            },
            async: true
        });

    }

    window.onload = (event) => {
        var options = {
            series: <?php echo json_encode($lessonArr) ?>,
            chart: {
                type: 'bar',
                height: <?= (count($lessonNameArr)+1) * 100 ?>,
                stacked: true,
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    dataLabels: {
                        total: {
                            enabled: true,
                            offsetX: 0,
                            style: {
                                fontSize: '13px',
                                fontWeight: 900
                            }
                        }
                    }
                },
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            title: {
                text: '<?= $user_fname ?> <?= $user_lname ?>'
            },
            xaxis: {
                categories: <?php echo json_encode($lessonNameArr) ?>,
                labels: {
                    formatter: function(val) {
                        return val + " цаг"
                    }
                }
            },
            yaxis: {
                title: {
                    text: undefined
                },
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " цаг"
                    }
                }
            },
            fill: {
                opacity: 1
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    };
</script>