<style>
    #head1 {
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
        border: none;
        text-align: center;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        -webkit-box-shadow: 0 1px 18px 3px #CCE5FF inset;
        box-shadow: 0 1px 18px 3px #CCE5FF inset;
        padding: 15px;
        border: 1px solid transparent;
        color: #004085;
        text-align: left;
        margin: 5px 5px 30px 5px;
    }
</style>
<?php
_selectRowNoParam(
    "SELECT name, money, bnorm FROM `tzereg` INNER JOIN teacher ON tzereg.id = teacher.zereg WHERE teacher.id = '" . $_SESSION['user_id'] . "'",
    $zereg,
    $money,
    $bnorm
);

_selectRowNoParam(
    "SELECT SUM(credit) FROM `btime_user` WHERE user_id = '" . $_SESSION['user_id'] . "' and `year`='$thison' and `month`='$thismonth'",
    $sumcr
)
?>
<div class="row" id="head1">
    <div class="col-sm-4">
        <p></p>
        <p style="float: left">Багшийн нэр:&nbsp;</p>
        <p style="font-weight: bold"><?= substr(trim($user_fname), 0, 2) ?>.<?= $user_lname ?></p>
        <p></p>
        <p style="float: left">Зэрэг:&nbsp;</p>
        <p style="font-weight: bold"><?= $zereg ?></p>
        <p></p>
    </div>
    <div class="col-sm-4">
        <p></p>
        <p style="float: left">Норм:&nbsp;</p>
        <p style="font-weight: bold"><?= $bnorm ?></p>
        <p></p>
        <p style="float: left">Нийт:&nbsp;</p>
        <p id="sumKr" style="font-weight: bold"><?php echo $sumcr - $bnorm ?></p>
        <p></p>
    </div>

    <div class="col-sm-4">
        <p></p>
        <p style="float: left">Кредитийн үнэлгээ:&nbsp;</p>
        <p style="font-weight: bold"> <?= formatMoney($money) ?></p>
        <p></p>
        <p style="float: left">Мөнгөн дүн:&nbsp;</p>
        <p id="sumTug" style="font-weight: bold"><?php $dun = ($sumcr - $bnorm) * $money;
                                                    echo $dun > 0 ? formatMoney($dun) : "-" . formatMoney($dun); ?></p>
        <p></p>
    </div>

</div>