<?php $id = $_POST['id']; ?>
<div class="row">
    <div class="col-sm-6">
        <input type="text" id="songochoose" class="form-control" placeholder="Хайх утга ..." onkeyup="filtersongochoose('songochoose', 'songolist')" /><br>
        <?php
        _selectNoParam(
            $productsubstmt,
            $productsubcount,
            "SELECT id, name FROM productsub WHERE turul='suvarga'",
            $productsubid,
            $productsubname
        );
        ?>
        <select class="form-control" size="5" id="songolist">
            <?php
            while (_fetch($productsubstmt)) {
                echo "<option value='$productsubid' onDblClick='addsubid(\"$productsubid\")'>$productsubname</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-sm-6">
        <input type="text" id="songosonchoose" class="form-control" placeholder="Хайх утга ..." onkeyup="filtersongochoose('songosonchoose', 'songosonlist')" /><br>
        <?php
        _selectNoParam(
            $sproductsubstmt,
            $sproductsubcount,
            "SELECT productsubid.id, name FROM `productsubid` INNER JOIN productsub ON productsubid.subid = productsub.id WHERE turul='suvarga' and productsubid.pid='$id'",
            $sproductsubid,
            $sproductsubname
        );
        ?>
        <select class="form-control" size="5" id="songosonlist">
            <?php
            while (_fetch($sproductsubstmt)) {
                echo "<option value='$sproductsubid' onDblClick='removesubid(\"$sproductsubid\")'>$sproductsubname</option>";
            }
            ?>
        </select>
    </div>
</div>