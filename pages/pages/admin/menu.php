<?php require 'start.php'; ?>
<?php require 'header.php';
$tuluv = "";?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">ЦЭС, МЭДЭЭЛЭЛ ЗАСВАРЛАХ</p>
                        <?php
                        $myArray = [];
                        _selectNoParam(
                            $menustmt,
                            $menucount,
                            "SELECT id, name, tuluv FROM menu ORDER BY ord ASC",
                            $menuid,
                            $menuname,
                            $menutuluv
                        );
                        while (_fetch($menustmt)) {
                            array_push($myArray, (object)[
                                    'mname' => $menuname,
                                    'mid' => $menuid,
                            ]);
                            echo "<li style='list-style: none'><ul><input type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#menuedit' value='$menuname' onClick='editM(\"" . $menuid . "\", \"" . $menuname. "\", \"" . $menutuluv. "\")' /></ul>";
                            _select(
                                $smenustmt,
                                $smenucount,
                                "SELECT id, name FROM submenu WHERE menuid=?",
                                "i",
                                [$menuid],
                                $smenuid,
                                $smenuname
                            );
                            if ($smenucount > 0) {
                                echo "<ul style='margin-left: 50px;'>";
                                while (_fetch($smenustmt)) {
                                    echo "<li><a href='/admin/addpage/menuSub?subid=$smenuid'>$smenuname</a></li>";
                                }
                                echo "</ul>";
                            }
                            echo "</li>";
                        }
                        ?>
                        <div class="modal fade" id="menuedit" tabindex="-1" role="dialog" aria-labelledby="menueditlabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="menueditlabel">Цэс, мэдээлэл засах</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/admin/record/new" method="POST">
                                        <div class="modal-body">
                                            <label for="tit">Цэсний нэр</label>
                                            <input style="display: none;" name="menuidedit" id="menuidedit" type="text" readonly/><br>
                                            <input class="form-control" name="menutitleedit" id="menutitleedit" type="text" /><br>
                                            <label for="tit">Цэсний байрлал</label>
                                            <select class="form-control" name="menuposition" id="menuposition"><?php
                                                for($i=0; $i<count($myArray); $i++){
                                                    echo "<option value=".$myArray[$i]->mid.">".$myArray[$i]->mname."</option>";
                                                }
                                            ?>
                                            </select>
                                            <div class="form-check form-check-flat">
            									<label class="form-check-label">
            									<input type="checkbox" class="form-control" id="ctuluvedit" name="ctuluv">
            										Идэвхтэй эсэх (Дэлгэцэнд харуулах эсэх)
            									<i class="input-helper"></i></label>
            								</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
                                            <button type="submit" class="btn btn-primary" name="menuedit">Хадгалах</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="menuadd" tabindex="-1" role="dialog" aria-labelledby="menuaddlabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="menuaddlabel">Цэс, мэдээлэл нэмэх</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/admin/record/new" method="POST">
                                        <div class="modal-body">
                                            <label for="tit">Цэсний нэр</label>
                                            <input class="form-control" name="menuname" id="menutitle" type="text" /><br>
                                            <label for="tit">Цэсний байрлал</label>
                                            <select class="form-control" name="menuposition"><?php
                                                for($i=0; $i<count($myArray); $i++){
                                                    echo "<option value=".$myArray[$i]->mid.">".$myArray[$i]->mname."</option>";
                                                }
                                            ?>
                                            </select>
                                            <div class="form-check form-check-flat">
            									<label class="form-check-label">
            									<input type="checkbox" class="form-control" id="ctuluv" name="ctuluv">
            										Идэвхтэй эсэх (Дэлгэцэнд харуулах эсэх)
            									<i class="input-helper"></i></label>
            								</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
                                            <button type="submit" class="btn btn-primary" name="menuadd">Хадгалах</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#menuadd">
                            Үндэсэн цэс нэмэх
                        </button>
                        <a href='/admin/addpage/menuSub'>
                            <button type="button" class="btn btn-primary">
                                Дэд цэс нэмэх
                            </button>
                        </a>
                    </div>


                </div>
            </div>

            <?php require 'footer.php'; ?>
            <script type="text/javascript">
                function editM(id, name, tuluv) {
                    console.log(tuluv);
                    const es = document.querySelector('#ctuluvedit');
                    const att = document.createAttribute("checked");
                    if(tuluv == 1)
                    {
                        es.setAttributeNode(att);
                    }
                    else
                    {
                        document.getElementById("ctuluvedit").removeAttribute("checked");
                    }
                    document.querySelector('#menuidedit').value = id;
                    document.querySelector('#menutitleedit').value = name;
                    document.querySelector('#menutitleedit').value = name;
                }
                /*
                function editM(modalID) {

                    if (modalID) {
                        document.querySelector('#MenuIDedit').value = modalID;
                        $.ajax({
                            url: '/api/menuEdit',
                            type: "POST",
                            data: {
                                'id': modalID
                            },
                            error: function(request, error) {
                                console.log(request);
                                alert(" Can't do because: " + error);
                            },
                            success: function(data) {
                                $('#editTitle').val(data.title);
                                $('#editimgurl').val(data.imgurl);
                                const $selecte = document.querySelector('#editmenuid');
                                document.querySelector('#editmenuid').value = data.menuid;
                                EditEditor.setData(data.body);
                            }
                        });
                    } else {
                        console.log(modalID + " no");
                    }
                };*/
            </script>
            <?php require 'end.php'; ?>