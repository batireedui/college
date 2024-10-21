<?php
_selectNoParam(
    $st,
    $co,
    "SELECT id, body FROM sanal",
    $i_id,
    $i_body
); ?>
<h4 class='text-center'>ИРСЭН САНАЛУУД</h4>
<table class='table table-bordered'>
    <?php
    $k = 1;
    while (_fetch($st)) {
    ?>
        <tr>
            <td><?= $k ?></td>
            <td><?= $i_body ?></td>
        </tr>

    <?php $k++;
    } ?>
</table>