<?php
require ROOT . "/pages/start.php"; ?>
<style>
    #upload_file {
        display: none;
    }
</style>
<link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
<link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
<?php
require ROOT . "/pages/header.php";
$id = $_GET["id"];
_selectRowNoParam(
    "select id, title, image, body, ognoo from news where id = $id",
    $id,
    $title,
    $image,
    $body,
    $ognoo
);
?>

<main id="main" class="main p-3">

    <div class="pagetitle">
        <h3>Мэдээлэл нэмэх</h3>
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
                                <label for="inputText" class="col-sm-12 col-form-label">Гарчиг</label>
                                <input type="text" class="form-control" id="title" value='<?= $title ?>'>
                            </div>
                            <div class="col-sm-2">
                                <label for="inputText" class="col-sm-12 col-form-label">Хэзээ</label>
                                <input type="date" class="form-control" id="ognoo" value=<?= $ognoo ?>>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col-sm-12">
                                <div id="body">
                                    <?= $body ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 text-center">
                            <div class="col-sm-12">
                                <img id="pro" src="/images/image_news/<?= $image ?>.jpg" style="width: 300px;height: 200px;object-fit: cover;border: solid;margin: auto" />
                                <br>
                                <progress id="progress_bar" value="0" max="100" style="width:300px;"></progress>
                                <p id="progress_status"></p>
                                <label for="upload_file" class="custom-file-upload btn btn-primary" style="margin-top: 10px;"> Зураг сонгох</label>
                                <input class="margin" type="file" formnovalidate id="upload_file" name="file" accept=".jpg, .png, .jpeg" onchange="imageSave(event)">

                                <p>300х200 харьцаатай зүураг оруулна уу!</p>
                            </div>
                        </div>
                        <div class="row mb-3 text-center" id="info" style="display: none;">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <span id="infotext">sd</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <button onclick="save()" class="btn btn-danger w-100 d-inline-block">Хадгалах</button>
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
<script src="/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="/assets/vendor/quill/quill.min.js"></script>
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
    const fname = '<?= $image ?>';

    function save() {
        let title = $('#title').val().trim();
        let ognoo = $('#ognoo').val();
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
                    mode: 4,
                    title: title,
                    body: body,
                    fname: fname,
                    ognoo: ognoo,
                    id: <?= $id ?>
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#infotext").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $("#infotext").html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    $("#infotext").html(data);
                    window.location.href = 'https://admin.ireedui.site/news/list';
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
require ROOT . "/pages/end.php";
?>