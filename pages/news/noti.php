<?php
require ROOT . "/pages/start.php"; ?>
<style>
    #upload_file {
        display: none;
    }
</style>
<?php
require ROOT . "/pages/header.php";
$file = date("YmdHis");
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Мэдээлэл нэмэх</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Эхлэл</a></li>
                <li class="breadcrumb-item active">Мэдээлэл нэмэх</li>
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
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" placeholder="Энд мэдэгдлээ бич">
                            </div>
                            <div class="col-sm-2">
                                <button onclick="save()" class="btn btn-danger w-100 d-inline-block">ИЛГЭЭХ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function save() {
        let body = $('#title').val().trim();

        console.log(body);

        if (body === "") {
            alert("Гарчиг оруулаагүй байна!");
        } else {
            $.ajax({
                url: "/sendnoti",
                type: "POST",
                data: {
                    newsAdd: 1,
                    title: body,
                    body: body
                },
                error: function(xhr, textStatus, errorThrown) {
                    //console.log("Алдаа гарлаа");
                },
                beforeSend: function() {
                    //console.log("Түр хүлээнэ үү");
                },
                success: function(data) {
                    //console.log(data);
                },
                async: true
            });
        }
    }

    const MAX_WIDTH = 500;
    const MAX_HEIGHT = 300;
    const MIME_TYPE = "image/jpg";
    const QUALITY = 1;
</script>
<?php
require ROOT . "/pages/end.php";
?>