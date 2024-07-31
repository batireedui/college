<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
$action = 'categoryadd';
$id = "";
$tuluv = "";
$dtuluv = "";
if (isset($_GET['cateid']) != null) {
    $action = 'categoryupdate';
    $id = $_GET['cateid'];
    _selectRow(
        "SELECT name, medeelel, imgurl, tuluv, dtuluv, daraa FROM category WHERE id =?",
        "i",
        [$_GET['cateid']],
        $title,
        $body,
        $imgurl,
        $tuluv,
        $dtuluv,
        $daraa
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
                        <p class="card-title">Ангилал</p>
                        <form action="/admin/record/new" method="POST">
                            <div class="modal-body">
                                <label for="tit">Ангилалын нэр</label>
                                <input class="form-control" name="cname" id="tit" type="text" value="<?=$title?>"/><br>
                                <input style="display: none" name="cIDedit" id="cIDedit" type="text" value="<?=$id?>"/><br>
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
								</div>
								<div class="row">
								    <div class="col-md-6">
        								<div class="form-check form-check-flat">
        									<label class="form-check-label">
        									<input type="checkbox" class="form-control" name="dtuluv" <?php echo $dtuluv == "1" ? "checked" : "";?>>
        										Дараагийн хугацааг харуулах
        									<i class="input-helper"></i></label>
        								</div>
								    </div>
    								<div class="col-md-6">
    								    <input type="datetime-local" class="form-control" value="<?=$daraa?>" name="meeting-time" min="2022-06-07T00:00" max="2050-06-14T00:00">
    								</div>
								</div>
									<br>
								<?php
								if(@$_GET['cateid'] == '11' || @$_GET['cateid'] == '14')
								{
								    echo "<label for='tit'>Тайлбар зураг сонгох</label>
                                <div style='flex-direction: row;flex-wrap: unset;display: flex;'>
                                    <input id='medeelel' class='form-control' name='medeelel' type='text' value='$body' readonly>
                                    <input type='button' id='bt2' class='btn btn-success' value='Зураг'>
                                </div><br>";
								}
								else
                                    echo "<textarea id='editmedeelel' name='medeelel'>$body</textarea>";
                                ?>
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
                if(document.querySelector('#editmedeelel')){
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
                }
                let button1 = document.getElementById('ckfinder-popup-1');
                let button2 = document.getElementById('bt2');
                button1.onclick = function() {
                    selectFileWithCKFinder('imgurl');
                };
                button2.onclick = function() {
                    selectFileWithCKFinder('medeelel');
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