<?php
require ROOT . "/pages/start.php";

_selectNoParam(
    $st,
    $co,
    "select id, title, image, body, ognoo from news order by ognoo desc",
    $id,
    $title,
    $image,
    $body,
    $ognoo
);
?>
<style>
    #upload_file {
        display: none;
    }
</style>
<?php
require ROOT . "/pages/header.php";
$file = date("YmdHis");
?>

<main id="main" class="main p-3">

    <div class="pagetitle">
        <h3>Мэдээллүүд</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Эхлэл</a></li>
                <li class="breadcrumb-item active">Мэдээлэл</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <div class="row mb-3">
                            <table class="table table-bordered hover">
                                <tr>
                                    <th>№</th>
                                    <th>Зураг</th>
                                    <th>Гарчиг</th>
                                    <th>ID</th>
                                    <th></th>
                                </tr>
                                <?php
                                $dd = 1;
                                while (_fetch($st)) { ?>
                                    <tr>
                                        <td><?= $dd ?></td>
                                        <td><img src="/images/image_news/<?= $image ?>.jpg" style="width: 100px" /></td>
                                        <td><?= $title ?></td>
                                        <td><?= $ognoo ?></td>
                                        <td>
                                            <a href="/news/edit?id=<?= $id ?>" /><span class="badge bg-success" role="button">Засах</span></a>
                                            <span class="badge bg-danger" role="button" onclick="del(<?= $id ?>, '<?= $title ?>', <?= $image ?>)">Устгах</a>
                                        </td>
                                    </tr>
                                <?php $dd++;
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require ROOT . "/pages/footer.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    function del(id, title, image) {
        var r = confirm(title + " мэдээг устгахдаа итгэлтэй байна уу!")
        if (r) {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 5,
                    id: id,
                    image: image
                },
                error: function(xhr, textStatus, errorThrown) {
                    //console.log("Алдаа гарлаа");
                },
                beforeSend: function() {
                    //console.log("Түр хүлээнэ үү");
                },
                success: function(data) {
                    window.location.reload();
                },
                async: true
            });
        }
    }
</script>
<?php
require ROOT . "/pages/end.php";
?>