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
    <?php
    if (isset($_GET['id'])) {
        $teacherid = $_GET['id'];
        _selectRowNoParam(
            "SELECT id, fname, lname FROM teacher WHERE id='$teacherid'",
            $t_id,
            $t_fname,
            $t_lname
        );
        _selectRowNoParam(
            "SELECT id FROM hural WHERE teacherid='$teacherid'",
            $cid
        );
        if (empty($cid)) {
            $success = _exec(
                "INSERT INTO hural (teacherid) VALUES(?)",
                'i',
                [$teacherid],
                $count
            );
        }
    }
    
    _selectNoParam(
        $st, $co,
        "SELECT id, fname, lname FROM teacher WHERE tuluv = 1 and id NOT IN (SELECT teacherid FROM hural) ORDER BY lname",
            $i_id,
            $i_fname,
            $i_lname
    );
    ?>
</head>

<body>
    <div class="container-md" style="margin-top: 30px;">
        <h5 style="text-align: center; color: #032c94">
            <img src="https://surgalt.uvcollege.edu.mn/images/logo.jpg" height="100" loading="lazy"><br><br>
            Дэлхийн багш нарын 30, Монголын багш нарын 58 дахь өдрийн мэнд хүргэе!
        </h5>
        <?php if (isset($_GET['id'])) { ?>
        <h1 style="text-align: center; margin-top: 30px; color:#025226;text-transform: uppercase;"><?= $t_fname ?> <span style="text-transform: uppercase;"><?= $t_lname ?></span> </h1>
        <h5 style="text-align: center; color:#025226">тус арга хэмжээнд оролцохоор бүртгэгдлээ. Танд баярлалаа!</h5>
        <h3 style="text-align: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="50" fill="#fa7d00" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
            </svg>
        </h3>
        <?php }
        echo "<div style='justify-content: center;align-items: center;display: flex;'><table>";
        $k=1;
        while(_fetch($st)) {
        ?>
        <tr>
            <td><?=$k?></td>
            <td><?=$i_fname?> <span style="text-transform: uppercase;"><?=$i_lname?></span></td>
            <td><a href="?id=<?=$i_id?>"><button class="btn btn-primary">ИРСЭН</button></a></td>
        </tr>
        
        <?php $k++;} ?>
        </table>
        </div>
    </div>
</body>

</html>