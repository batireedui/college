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
        _selectRowNoParam(
            "SELECT student_id, class.id, class.name, students.fname, students.lname FROM `parent` INNER JOIN students ON parent.student_id = students.id INNER JOIN class ON students.class = class.id WHERE parent.id = $user_id",
            $student_id, $classid, $class, $fname, $lname
        );
        
        _selectNoParam(
            $cstmt,
            $ccount,
            "SELECT YEAR(ognoo), MONTH(ognoo) FROM `att` WHERE classid = $classid  GROUP BY MONTH(ognoo), YEAR(ognoo)",
            $YEAR,
            $MONTH
        );
        ?>
            <div class="container-fluid">
                <div style="text-align: center">
                    <h5>
                        <?=$fname?> овогтой <?=$lname?>
                    </h5>
                    <p>
                        <?=$class?>
                    </p>
                </div>
                <div style="text-align: center; margin-bottom: 15px;">
                    <?php while (_fetch($cstmt)) : ?>
                        <button type="button" class="btn btn-primary" onclick="detial(<?=$student_id?>, <?=$YEAR?>, <?=$MONTH?>)"><?=$YEAR?>-<?=$MONTH?></button>
                    <?php endwhile; ?>
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