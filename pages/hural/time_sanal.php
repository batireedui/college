<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $pageTitle ?> </title>
    <link rel="icon" type="image/x-icon" href="<?= $favi ?>" />
    <meta name="description" content='Өвөрхангай ПК' />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
    <style>
            .editcell {
                  background-color: #dddddd;
                  padding: 5px 10px 5px 10px;
                  border-radius: 5px;
                }
                .table>:not(caption)>*>* {
              padding: 0.3rem 0.8rem;
            }
    </style>
    <?php
    if(isset($_GET['t'])) {
    $t = (int)$_GET['t'];

   _selectRowNoParam(
        "SELECT id, name, utga FROM strategy_time WHERE id=$t",
        $id,
        $name, $utga
    );
    ?>
</head>

<body>
    <div class="container-md" style="margin-top: 20px;">
        <h5 style="text-align: center; color: #e00b0b">
            <img src="https://surgalt.uvcollege.edu.mn/images/logo.jpg" height="100" loading="lazy"><br><br>
            Санал, дүгнэлт өгөх
        </h5>
        <h5 style="text-align: center; color: #032c94">
            Өвөрхангай аймаг дахь Политехник коллеж 2024.10.03
        </h5>
        <div style="border: 3px solid #032c94;border-radius: 10px;padding: 10px;text-align: center;font-size: 24px;">
            <div style="font-weight: bold">
                <?=$name?>
            </div>
            <div style="font-size: 20px;">
                <?=$utga?>
            </div>
        </div>
        <span role="button" onclick="startTime()">START </span>
        <span role="button" onclick="stopTime()"> STOP</span>
        <div id="too" style="text-align: center;font-size: 44px;font-weight: bold;color: #1c1166;">
            
        </div>
        <div>
          <p id="demo" style="text-align: center;font-size: 80px;font-weight: bold;color: red;"></p>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    let x;
    var now = 60;
    
    function getToo() {
        $.ajax({
            url: 'too',
            type: 'post',
            data: {
                id: <?=$_GET['t']?>
            },
            success: function(data) {
                document.getElementById("too").innerHTML = data;
            }
        })
    }
    
    function stopTime() {
        getToo();
        clearInterval(x);
        document.getElementById("demo").innerHTML = "";
        
        $.ajax({
            url: 'too',
            type: 'post',
            data: {
                startid: <?=$_GET['t']?>
            },
            success: function(data) {
                
            }
        })
    }
    
    function startTime() {
        startInterval();
    }
    
    function startInterval() {
        x = setInterval(function () {
                now = now - 1;
                var minutes = Math.floor(now / 60);
                var seconds = now % 60;
                if (minutes < 10) minutes = "0" + minutes;
                if (seconds < 10) seconds = "0" + seconds;
        
                document.getElementById("demo").innerHTML = minutes + " : " + seconds;
        
                if (now < 10) document.getElementById("demo").style.color = "red";
                if (now < 0) {
                  clearInterval(x);
                  getToo();
                  document.getElementById("demo").innerHTML = "";
                }
        }, 1000);
    }
</script>
</html>
<?php }
else { ?>
    
    </head>

<body>
    <div class="container-md" style="margin-top: 30px;">
        <a href="https://uvcollege.edu.mn/">БУРУУ ХҮСЭЛТ БАЙНА! БУЦАХ</a>
    </div>
</body>

</html>
    
<?php }
?>