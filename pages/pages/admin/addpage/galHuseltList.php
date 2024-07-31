<?php $id = $_POST['id']; ?>
<div class="row">
    <div class="col-sm-6">
        <input type="text" id="huselchoose" class="form-control" placeholder="Хайх утга ..." onkeyup="filtersongochoose('huselchoose', 'husellist')" /><br>
        <?php
        _selectNoParam(
            $productsubstmt,
            $productsubcount,
            "SELECT id, name FROM productsub WHERE turul='husel'",
            $productsubid,
            $productsubname
        );
        ?>
        <select class="form-control" size="5" id="husellist">
            <?php
            while (_fetch($productsubstmt)) {
                echo "<option value='$productsubid' onDblClick='addsubid(\"$productsubid\")'>$productsubname</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-sm-6">
        <input type="text" id="huseltchoose" class="form-control" placeholder="Хайх утга ..." onkeyup="filtersongochoose('huselt', 'huseltlist')" /><br>
        <?php
        _selectNoParam(
            $sproductsubstmt,
            $sproductsubcount,
            "SELECT productsubid.id, name FROM `productsubid` INNER JOIN productsub ON productsubid.subid = productsub.id WHERE turul='husel' and productsubid.pid='$id'",
            $sproductsubid,
            $sproductsubname
        );
        ?>
        <select class="form-control" size="5" id="huseltlist">
            <?php
            while (_fetch($sproductsubstmt)) {
                echo "<option value='$sproductsubid' onDblClick='removesubid(\"$sproductsubid\")'>$sproductsubname</option>";
            }
            ?>
        </select>
    </div>
</div>