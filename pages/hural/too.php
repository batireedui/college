<?php
if(isset($_POST["id"])){
    _selectRowNoParam(
        "SELECT tiim, ugui FROM strategy_time WHERE id='" . $_POST["id"] . "'",
            $tiim,
            $ugui
    ); 
    $success = _exec(
            "UPDATE strategy_time SET tuluv=0 WHERE id = ?",
            'i',
            [$_POST["id"]],
            $count
        );
    
    ?>
        <div>Тийм: <?=$tiim?></div>
        <div>Үгүй: <?=$ugui?></div>
        <div>Нийт: <?php echo (int)$ugui + (int)$tiim?></div>
<?php }
else if(isset($_POST["startid"])){
    $success = _exec(
            "UPDATE strategy_time SET tuluv=1 WHERE id = ?",
            'i',
            [$_POST["startid"]],
            $count
        );
    }
else if(isset($_POST["sanalClickid"])){
    $tuluv = 1;
    _selectRowNoParam(
        "SELECT tuluv FROM strategy_time WHERE id='" . $_POST["sanalClickid"] . "'",
            $tuluv
    );
    
    if($tuluv == 0){
        $sql = "";
        if($_POST["sanal"] == "1"){
            $sql = "UPDATE strategy_time SET tiim=tiim + 1 WHERE id = ?";
        }
        if($_POST["sanal"] == "2"){
            $sql = "UPDATE strategy_time SET ugui=ugui + 1 WHERE id = ?"; ?>
            
            <div class="m-3 text-center">
                <p>Танд өөрчлөх, сайжруулах ямар санал хүсэлт байна вэ? Таны санал хүсэлт сургуулийнхаа цаашдийн үйл ажиллагаанд үнэтэй хувь нэмрээ оруулах тул доор бичиж илгээнэ үү.</p>
                <textarea row="3" class="form form-control" id="ugui" required="" placeholder="Энд өөрчлөх, сайжруулах санал хүсэлтээ бичнэ үү"></textarea>
                <button class="btn btn-success m-3" onclick="ugui(<?=$_POST["sanalClickid"]?>)">ИЛГЭЭХ</button>
            </div>
            
        <?php
        }
        $success = _exec(
                $sql,
                'i',
                [$_POST["sanalClickid"]],
                $count
            );
            
        echo "<br>Санал хүсэлт өгсөн танд баярлалаа. Таныг зөвхөн ганцхан санал өгөхийг хүсэж байна. <br><div style='font-size: 12px'><button class='btn btn-warning' onclick='window.location.reload();'>Энэ төхөөрөмжийг ашиглан өөр ажилтан санал өгөх энд дарна уу!</button></div>";
    }
    else {
        echo "Санал өгөх хугацаа нээгдээгүй байна!";
    }
}
else if(isset($_POST["uguiid"])){
    $success = _exec(
            "INSERT INTO strategy_time_sanal (time_id, sanal) VALUES (?, ?)",
            'is',
            [$_POST["uguiid"], $_POST["sanal"]],
            $count
        );
    echo "<br>Санал хүсэлт өгсөн танд баярлалаа. Таныг зөвхөн ганцхан санал өгөхийг хүсэж байна. <br><div style='font-size: 12px'><button class='btn btn-warning' onclick='window.location.reload();'>Энэ төхөөрөмжийг ашиглан өөр ажилтан санал өгөх энд дарна уу!</button></div>";
    }
    
?>
