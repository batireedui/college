<?php
require ROOT . "/pages/adminpanel/start.php"; ?>
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
        <h1>Апп-н онцлох мэдээлэл</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Эхлэл</a></li>
                <li class="breadcrumb-item active">Онцлох мэдээлэл</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Апп-д зургаар онцлох мэдээлэл оруулах</h5>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Мэдээллийн гарчиг</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title">
                            </div>
                        </div>
                        <div class="row mb-3 text-center">
                            <div class="col-sm-12">
                                <p>300х200 харьцаатай зүураг оруулна уу!</p>
                                <img id="pro" src="/images/image.jpg" style="width: 300px;height: 200px;object-fit: cover;border: solid;margin: auto" />
                                <br>
                                <progress id="progress_bar" value="0" max="100" style="width:300px;"></progress>
                                <p id="progress_status"></p>
                                <label for="upload_file" class="custom-file-upload btn btn-primary" style="margin-top: 10px;"> Зураг сонгох</label>
                                <input class="margin" type="file" formnovalidate id="upload_file" name="file" accept=".jpg, .png, .jpeg" onchange="imageSave(event)">
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
require ROOT . "/pages/adminpanel/footer.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    const now = new Date();
    const fname = '<?= $file ?>';

    function save() {
        let title = $('#title').val().trim();
        if (title === "") {
            alert("Гарчиг оруулаагүй байна!");
        } else {
            $("#info").css("display", "block");
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 1,
                    title: title,
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
                },
                async: true
            });
        }
    }

    const MAX_WIDTH = 500;
    const MAX_HEIGHT = 300;
    const MIME_TYPE = "image/jpg";
    const QUALITY = 0.8;

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
        ajax.open('POST', '/upload', true);
        ajax.send(formData);
    }

    function progressHandler(event) {
        var percent = (event.loaded / event.total) * 100;
        document.getElementById("progress_bar").value = Math.round(percent);
        document.getElementById("progress_status").innerHTML = Math.round(percent) + "% солигдлоо";
    }
</script>
<?php
require ROOT . "/pages/adminpanel/end.php";
?>