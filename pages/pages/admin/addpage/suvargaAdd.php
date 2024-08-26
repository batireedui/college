<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
$action = 'suvargaadd';
$id = "";
$title = "ДЭД СУВАРГА НЭМЭХ";
$tuluv = "";
if (isset($_GET['id']) != null) {
    $title = "ДЭД СУВАРГА ЗАСВАРЛАХ";
    $action = 'suvargaupdate';
    $id = $_GET['id'];
    _selectRow(
        "SELECT name, price, too, uld, imgurl, medeelel, cateid, tuluv FROM products WHERE id =5",
        $name,
        $price,
        $too,
        $uldtuluv,
        $imgurl,
        $medeelel,
        $cateidf,
        $tuluv
    );
} else {
        $name = "";
        $price= "";
        $too= "";
        $imgurl= "";
        $medeelel= "";
        $cateidf= "";
        $tuluv= "";
        $uldtuluv = "";
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title"><?=$title?></p>
                        <form action="/admin/record/new" method="POST">
                            <div class="modal-body">
                                <?php
                                _selectNoParam(
                                    $cstmt,
                                    $ccount,
                                    "SELECT id, name FROM products WHERE cateid =5",
                                    $cateid,
                                    $catename
                                );
                                ?>
                                <label>Суварга сонгох</label>
                                <select class="form-control" name="cateid">
                                    <?php
                                    while (_fetch($cstmt)) {
                                        echo "<option value=". $cateid; echo $cateid == $cateidf ? " selected>" : ">"; echo $catename ."</option>";
                                    }

                                    ?>
                                </select><br>
                                <label for="proname">Дэд суварганы нэр</label>
                                <input class="form-control" name="proname" id="proname" type="text" value="<?=$name?>"/><br>
                                <input style="display: none" name="proIDedit" id="proIDedit" type="text" value="<?=$id?>"/><br>
                                
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="proprice">Суварганы үнэ /₮/</label>
                                        <input class="form-control" name="proprice" id="proprice" type="number" value="<?=$price?>" placeholder="Зөвхөн тоо оруулна"/>
                                    </div>
                                    <div class="col">
                                        <label for="protoo">Суварганы үлдэгдэл</label>
                                        <input class="form-control" name="protoo" id="protoo" type="number" value="<?=$too?>" placeholder="Зөвхөн тоо оруулна"/>
                                    </div>
                                </div>
                                <label for="tit">Суварганы зураг сонгох</label>
                                <div style="flex-direction: row;flex-wrap: unset;display: flex;">
                                    <input id="imgurl" class="form-control" name="imgurl" type="text" value="<?=$imgurl?>" readonly>
                                    <input type="button" id="ckfinder-popup-1" class="btn btn-success" value="Зураг">
                                </div><br>
                                <div class="form-group row">
                                    <div class="form-check form-check-flat" style="margin-left: 50px;">
    									<label class="form-check-label">
    									<input type="checkbox" class="form-control" id="ctuluv" name="ctuluv" <?php echo $tuluv == "1" ? "checked" : "";?>>
    										Идэвхтэй эсэх (Дэлгэцэнд харуулах эсэх)
    									<i class="input-helper"></i></label>
    								</div>
    								<div class="form-check form-check-flat" style="margin-left: 50px;">
    									<label class="form-check-label">
    									<input type="checkbox" class="form-control" id="uldtuluv" name="uldtuluv" <?php echo $uldtuluv == "1" ? "checked" : "";?>>
    										Үлдэгдэл тооцох эсэх
    									<i class="input-helper"></i></label>
    								</div>
								</div>
                                <label for="tit">Суварганы тайлбар</label>
                                <textarea id="editmedeelel" name="medeelel"><?=$medeelel?></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
                                <button type="submit" class="btn btn-primary" name="<?=$action?>">Хадгалах</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php require ROOT . '/pages/admin/footer.php'; ?>

            <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
            <script src="/ckfinder/ckfinder.js"></script>
            <script type="text/javascript">
                let EditEditor;
                ClassicEditor
                    .create(document.querySelector('#editmedeelel'), {
                        ckfinder: {
                            uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
                        },
                        toolbar: ['ckfinder', 'imageUpload', '|',
                            'heading', '|',
                            'fontfamily', 'fontsize', '|',
                            'alignment', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                            'link', '|',
                            'outdent', 'indent', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'code', 'codeBlock', '|',
                            'insertTable', '|',
                            'uploadImage', 'blockQuote', '|',
                            'undo', 'redo'
                        ]
                    })
                    .then(ed => {
                        EditEditor = ed;
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
                let button1 = document.getElementById('ckfinder-popup-1');
                button1.onclick = function() {
                    selectFileWithCKFinder('imgurl');
                };

                function selectFileWithCKFinder(elementId) {
                    CKFinder.popup({
                        chooseFiles: true,
                        width: 800,
                        height: 600,
                        onInit: function(finder) {
                            finder.on('files:choose', function(evt) {
                                let file = evt.data.files.first();
                                let output = document.getElementById(elementId);
                                output.value = file.getUrl();
                            });

                            finder.on('file:choose:resizedImage', function(evt) {
                                var output = document.getElementById(elementId);
                                output.value = evt.data.resizedUrl;
                            });
                        }
                    });
                }
            </script>
            <?php require ROOT . '/pages/admin/end.php'; ?>