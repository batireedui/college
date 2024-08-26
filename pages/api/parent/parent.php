<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <style>
            .alert {
                padding: 0.1rem 0.3rem;}
        </style>
    </head>
    <body>
        <?php
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $user_id = @$_GET["user_id"];
        
        if (!empty($user_id)) {
        _selectNoParam(
            $stmt, $count,
            "SELECT tax_pareant.student_id, class.id, class.name, students.fname, students.lname FROM `parent` INNER JOIN tax_pareant ON parent.id = tax_pareant.parent_id INNER JOIN students ON tax_pareant.student_id = students.id INNER JOIN class ON students.class = class.id WHERE parent.id = $user_id",
            $student_id, $classid, $class, $fname, $lname
        );

        ?>
            <div class="container-fluid">
                <div style="text-align: center; margin: 10px;">
                    <?php while (_fetch($stmt)) : ?>
                    <input type="radio" class="btn-check" name="options-outlined" id="success-outlined<?= $student_id ?>" onchange="sar(<?= $classid ?>, <?= $student_id ?>)" autocomplete="off">
                    <label class="btn btn-outline-success" for="success-outlined<?= $student_id ?>"><?=substr($fname, 0, 2)?>.<?=$lname?><br><span style="font-size: 12px;"><?=$class?></span></label>
                    <?php endwhile; ?>
                </div>
                <div id="sar" style="text-align: center; margin-bottom: 15px;">

                </div>
                <div id="table" style="text-align: center">
                    
                </div>
            </div>
        <?php
        
        }
        ?>
    </body>
</html>
<script>
    function sar(classid, student_id) {
                $.ajax({
                    url: "parent-sar",
                    type: "POST",
                    data: {
                        classid: classid,
                        student_id: student_id
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        $("#sar").html("Алдаа гарлаа !");
                    },
                    beforeSend: function() {
                        $('#sar').html("Түр хүлээнэ үү ...");
                    },
                    success: function(data) {
                        $('#sar').html(data);
                    },
                    async: true
                });
    }
    
    function detial(id, onn, ssar) {
                $.ajax({
                    url: "parent-att",
                    type: "POST",
                    data: {
                        mode: 1,
                        id: id,
                        son: onn,
                        ssar: ssar,
                        lon: onn,
                        lsar: ssar
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        $("#table").html("Алдаа гарлаа !");
                    },
                    beforeSend: function() {
                        $('#table').html("Түр хүлээнэ үү ...");
                    },
                    success: function(data) {
                        $('#table').html(data);
                    },
                    async: true
                });
    }
</script>