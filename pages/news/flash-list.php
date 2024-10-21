<?php
require ROOT . "/pages/adminpanel/start.php";

_selectNoParam(
    $st,
    $co,
    "select id, title, image, link, ognoo from flashnews order by ognoo desc",
    $id,
    $title,
    $image,
    $link,
    $ognoo
);
?>
<style>
    #upload_file {
        display: none;
    }
</style>
<?php
require ROOT . "/pages/adminpanel/header.php";
$file = date("YmdHis");
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Онцлох мэдээний жагсаалт</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Эхлэл</a></li>
                <li class="breadcrumb-item active">Онцлох мэдээний жагсаалт</li>
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
                                        <td><img src="/images/app_flash/<?= $image ?>.jpg" style="width: 100px" /></td>
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
require ROOT . "/pages/adminpanel/footer.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    var quill = new Quill('#body', {
        modules: {
            toolbar: [
                [{
                    header: [1, 2, false]
                }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block']
            ]
        },
        placeholder: 'Compose an epic...',
        theme: 'snow' // or 'bubble'
    });

    const now = new Date();
    const fname = '<?= $file ?>';

    function del(id, title, image) {
        var r = confirm(title + " мэдээг устгахдаа итгэлтэй байна уу!")
        if (r) {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 6,
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

    function save() {
        let title = $('#title').val().trim();
        let body = quill.root.innerHTML;

        console.log(body);

        if (title === "") {
            alert("Гарчиг оруулаагүй байна!");
        } else {
            $("#info").css("display", "block");
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 2,
                    title: title,
                    body: body,
                    fname: fname
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#infotext").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $("#infotext").html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    $("#infotext").html(data);
                    $.ajax({
                        url: "/sendnoti",
                        type: "POST",
                        data: {
                            newsAdd: 1,
                            title: title,
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
                },
                async: true
            });
        }
    }

    const MAX_WIDTH = 500;
    const MAX_HEIGHT = 300;
    const MIME_TYPE = "image/jpg";
    const QUALITY = 1;

    function calculateSize(img, maxWidth, maxHeight) {
        let width = img.width;
        let height = img.height;

        // calculate the width and height, constraining the proportions
        if (width > height) {
            if (width > maxWidth) {
                height = Math.round((height * maxWidth) / width);
                width = maxWidth;
            }
        } else {
            if (height > maxHeight) {
                width = Math.round((width * maxHeight) / height);
                height = maxHeight;
            }
        }
        return [width, height];
    }

    function imageSave(event) {
        if (event.target.files.length > 0) {
            const file = event.target.files[0]; // get the file
            const blobURL = window.URL.createObjectURL(file);
            const img = new Image();
            img.src = blobURL;
            img.onerror = function() {
                window.URL.revokeObjectURL(this.src);
                console.log("Cannot load image");
            };
            img.onload = function() {
                window.URL.revokeObjectURL(this.src);
                const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
                const canvas = document.createElement("canvas");
                canvas.width = newWidth;
                canvas.height = newHeight;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, newWidth, newHeight);
                canvas.toBlob(
                    (blob) => {

                    },
                    MIME_TYPE,
                    QUALITY
                );
                let pre = document.getElementById("pro");
                let imgc = canvas.toDataURL('image/jpg')
                pre.src = imgc;
                uploadFile(imgc);
                console.log(imgc);
            };
        }
    }

    function uploadFile(file) {
        var formData = new FormData();
        formData.append('file_to_upload', file);
        formData.append('file_name', fname);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.onreadystatechange = function() {
            //console.log(this.responseText);
        };
        ajax.open('POST', '/news_image', true);
        ajax.send(formData);
    }

    function progressHandler(event) {
        var percent = (event.loaded / event.total) * 100;
        document.getElementById("progress_bar").value = Math.round(percent);
        document.getElementById("progress_status").innerHTML = Math.round(percent) + "% ";
    }
</script>
<?php
require ROOT . "/pages/adminpanel/end.php";
?>