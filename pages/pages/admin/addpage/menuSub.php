<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
$action = 'submenuadd';
$id = "";
$tuluv = "";
if (isset($_GET['subid']) != null) {
    $action = 'submenuupdate';
    $id = $_GET['subid'];
    _selectRow(
        "SELECT name, menuid, medeelel, imgurl, tuluv FROM submenu WHERE id =?",
        "i",
        [$_GET['subid']],
        $title,
        $menuidf,
        $body,
        $imgurl,
        $tuluv
    );
} else {
    $title = "";
    $menuidf = "";
    $body = "";
    $imgurl = "";
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">ЦЭС</p>
                        <form action="/admin/record/new" method="POST">
                            <div class="modal-body">
                                <?php
                                _selectNoParam(
                                    $menustmt,
                                    $menucount,
                                    "SELECT id, name FROM menu",
                                    $menuid,
                                    $menuname
                                );
                                ?>
                                <label>Дээд цэс сонгох</label>
                                <select class="form-control" name="menuid">
                                    <?php
                                    while (_fetch($menustmt)) {
                                        echo "<option value=". $menuid; echo $menuid == $menuidf ? " selected>" : ">"; echo $menuname ."</option>";
                                    }

                                    ?>
                                </select><br>
                                <label for="tit">Гарчиг оруулах</label>
                                <input class="form-control" name="menuname" id="tit" type="text" value="<?=$title?>"/><br>
                                <input style="display: none" name="MenuIDedit" id="MenuIDedit" type="text" value="<?=$id?>"/><br>
                                <label for="tit">Зураг сонгох</label>
                                <div style="flex-direction: row;flex-wrap: unset;display: flex;">
                                    <input id="imgurl" class="form-control" name="imgurl" type="text" value="<?=$imgurl?>" readonly>
                                    <input type="button" id="ckfinder-popup-1" class="btn btn-success" value="Зураг">
                                </div><br>
                                <div class="form-check form-check-flat">
									<label class="form-check-label">
									<input type="checkbox" class="form-control" id="ctuluv" name="ctuluv" <?php echo $tuluv == "1" ? "checked" : "";?>>
										Идэвхтэй эсэх (Дэлгэцэнд харуулах эсэх)
									<i class="input-helper"></i></label>
								</div><br>
                                <textarea id="editmedeelel" name="medeelel"><?=$body?></textarea>
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
                        toolbar: {
                            items: ['ckfinder', 'imageUpload', '|',
                            'heading', '|',
                            'code', 'codeBlock', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                            'link', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'insertTable', '|',
                            'uploadImage', 'blockQuote', '|',
                            'undo', 'redo'
                        ],
                        shouldNotGroupWhenFull: true
                        }
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