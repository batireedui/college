<?php
_selectNoParam(
    $stmt,
    $count,
    "SELECT att.id, class.name, tlesson.lessonName, cag.name, cag.inter, ognoo, att.lessonid FROM att 
        INNER JOIN class ON att.classid = class.id 
            INNER JOIN tlesson ON att.lessonid = tlesson.id 
                INNER JOIN cag ON att.cagid = cag.id 
                    WHERE att.tid = '" . $_SESSION['user_id'] . "' ORDER BY ognoo DESC , cag.name DESC LIMIT 10",
    $id,
    $class,
    $lesson,
    $cag,
    $cag_inter,
    $ognoo,
    $lessonid
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
    array_push($zaasanArr, $item);
}

$lessonArr = array();
$lessonNameArr = array();
_selectNoParam(
    $gstmt,
    $gcount,
    "SELECT id, lessonName, cag FROM `tlesson` WHERE tuluv < 2 and tid = '" . $_SESSION['user_id'] . "'",
    $gid,
    $glesson,
    $gcag,
);

$orson = [];
$uldsen = [];
foreach ($zaasanArr as $it) {
    $gcag = 0;
    _selectRowNoParam(
        "SELECT cag FROM `tlesson` WHERE tuluv < 2 and id = '" . $it->lessonid . "'",
        $gcag,
    );

    $gtoo = 0;
    _selectRowNoParam(
        "SELECT COUNT(id) from att WHERE id = $it->id",
        $gtoo
    );
    array_push($orson, $gtoo * 2);
    array_push($uldsen, $gcag - $gtoo * 2);

    array_push($lessonNameArr, $glesson);
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
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        ЦАГИЙН ГҮЙЦЭТГЭЛ
    </div>
    <div id="chart"></div>
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        СҮҮЛИЙН ХИЧЭЭЛ ОРОЛТУУД (10)
    </div>
    <div id="table">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>Анги</th>
                    <th>Хичээл</th>
                    <th>Цаг</th>
                    <th>Төлөв</th>
                    <th></th>
                </tr>
            </thead>
            <?php $too = 0;
            foreach ($zaasanArr as $el) :
                $too++ ?>
                <tr>
                    <td><?= $too ?></td>
                    <td id="f1-<?= $id ?>"><?= $el->class ?></td>
                    <td id="f2-<?= $id ?>"><?= $el->lesson ?></td>
                    <td id="f3-<?= $id ?>"><?= str_replace("-", ".",  $el->ognoo) ?>, <?= $el->cag ?> (<?= $el->cag_inter ?>)</td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function get() {
        var options = {
            series: <?php echo json_encode($lessonArr) ?>,
            chart: {
                type: 'bar',
                height: 350,
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
    }
    get();

    function addAngi() {
        $('#addinfo').hide();
        if ($('#add_teacher_id').val() === null || $('#add_angi_name').val() === '') {
            $('#addinfo').html("Мэдээлэл дутуу байна!");
            $('#addinfo').show();
        } else {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 2,
                    teacher_id: $('#add_teacher_id').val(),
                    angi_name: $('#add_angi_name').val(),
                    hugacaa: $('#addhugacaa').val()
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#addbody").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $('#addinfo').html("Түр хүлээнэ үү ...");
                    $('#addinfo').show();
                },
                success: function(data) {
                    get();
                    $('#add').modal('hide');
                },
                async: true
            });
        }
    }

    function setTeacher(id, angi) {
        $('#changeinfo').hide();
        $('#teacherList').val(id);
        $('#angi_id').val(angi);
        $('#angi_name').val($('#f1-' + angi).text());
    }
</script>