<?php require 'start.php'; ?>
<?php require 'header.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">АВРАЛ, ХУВИЙН ХҮСЭЛТҮҮД</p>
                        <?php
                        _selectNoParam(
                            $astmt,
                            $acount,
                            "SELECT id, name, jphname FROM productsub WHERE turul='avral'",
                            $aid,
                            $aname,
                            $ajphname
                        );
                        _selectNoParam(
                            $hstmt,
                            $hcount,
                            "SELECT id, name, jphname FROM productsub WHERE turul='husel'",
                            $hid,
                            $hname,
                            $hjphname
                        );
                        _selectNoParam(
                            $sstmt,
                            $scount,
                            "SELECT id, name, jphname, info FROM productsub WHERE turul='suvarga'",
                            $sid,
                            $sname,
                            $sjphname,
                            $sinfo
                        );
                        ?>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Авралууд</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Хувийн хүсэлтүүд</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="suvarga-tab" data-bs-toggle="tab" data-bs-target="#suvarga" type="button" role="tab" aria-controls="suvarga" aria-selected="false">Дэд суварга</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-sm-5"><input type="text" id="addsubname" class="form-control" placeholder="Нэмэх утгаа бичнэ үү" /></div>
                                    <div class="col-sm-5"><input type="text" id="addsubjpname" class="form-control" placeholder="Нэмэх утгаа японоор бичнэ үү" /></div>
                                    <div class="col-sm-2"><input type="button" class="btn btn-success" style="width: 100%;" onclick="addproductsub('avral')" value="Нэмэх"></div>
                                </div><br>
                                <div class="table-responsive pt-3">
                                    <table class='table table-bordered' style="width: 100%">
                                        <thead>
                                            <th></th>
                                            <th>Нэр</th>
                                            <th>Япон нэр</th>
                                        </thead>
                                        <?php
                                        $too = 1;
                                        while (_fetch($astmt)) {
                                            echo "<tr>
                                                <td>$too</td>
                                                <td><div class='editcell' onblur='updateValue(this, \"$aid\", \"name\")' contenteditable>$aname</div></td>
                                                <td><div class='editcell' onblur='updateValue(this, \"$aid\", \"jphname\")' contenteditable>$ajphname</div></td>
                                            </tr>";
                                            $too++;
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-sm-5"><input type="text" id="addsubhuseltname" class="form-control" placeholder="Нэмэх утгаа бичнэ үү" /></div>
                                    <div class="col-sm-5"><input type="text" id="addsubhuseltjpname" class="form-control" placeholder="Нэмэх утгаа японоор бичнэ үү" /></div>
                                    <div class="col-sm-2"><input type="button" class="btn btn-success" style="width: 100%;" onclick="addproductsub('husel')" value="Нэмэх"></div>
                                </div>
                                <div class="table-responsive pt-3">
                                    <table class='table table-bordered' style="width: 100%">
                                        <thead>
                                            <th></th>
                                            <th>Нэр</th>
                                            <th>Япон нэр</th>
                                        </thead>
                                        <?php
                                        $too = 1;
                                        while (_fetch($hstmt)) {
                                            echo "<tr>
                                                <td>$too</td>
                                                <td><div class='editcell' onblur='updateValue(this, \"$hid\", \"name\")' contenteditable>$hname</div></td>
                                                <td><div class='editcell' onblur='updateValue(this, \"$hid\", \"jphname\")' contenteditable>$hjphname</div></td>
                                            </tr>";
                                            $too++;
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="suvarga" role="tabpanel" aria-labelledby="suvarga-tab">
                                <div class="row">
                                    <div class="col-sm-4"><input type="text" id="addsuvarganame" class="form-control" placeholder="Нэмэх утгаа бичнэ үү" /></div>
                                    <div class="col-sm-4"><input type="text" id="addsuvargainfo" class="form-control" placeholder="Тайлбараа бичнэ үү" /></div>
                                    <div class="col-sm-2"><input type="text" id="addsuvargatjpname" class="form-control" placeholder="Нэмэх утгаа японоор бичнэ үү" /></div>
                                    <div class="col-sm-2"><input type="button" class="btn btn-success" style="width: 100%;" onclick="addproductsub('suvarga')" value="Нэмэх"></div>
                                </div>
                                <div class="table-responsive pt-3">
                                    <table class='table table-bordered' style="width: 100%">
                                        <thead>
                                            <th></th>
                                            <th>Нэр</th>
                                            <th>Тайлбар</th>
                                            <th>Япон нэр</th>
                                        </thead>
                                        <?php
                                        $too = 1;
                                        while (_fetch($sstmt)) {
                                            echo "<tr>
                                                <td>$too</td>
                                                <td><div class='editcell' onblur='updateValue(this, \"$sid\", \"name\")' contenteditable>$sname</div></td>
                                                <td><div class='editcell' onblur='updateValue(this, \"$sid\", \"info\")' contenteditable>$sinfo</div></td>
                                                <td><div class='editcell' onblur='updateValue(this, \"$sid\", \"jphname\")' contenteditable>$sjphname</div></td>
                                            </tr>";
                                            $too++;
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require 'footer.php'; ?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous">
            </script>

            <script type="text/javascript">
                function updateValue(element, id, turul)
                    {
                        var value = element.innerText;
                        $.ajax({
                            url: '/admin/zahialga/updateval',
                            type: 'post',
                            data:{
                                type: "productsubupdate",
                                turul: turul,
                                id: id,
                                value: value
                            },
                            success: function(php_result)
                            {
        
                            }
                    })
                }            
            
                function addproductsub(turul) {
                    console.log("addproductsub");
                    let info="";
                    let name = "";
                    let jpname = "";
                    if (turul === "avral") {
                        name = document.getElementById("addsubname").value;
                        jpname = document.getElementById("addsubjpname").value;
                    } else if (turul === "husel") {
                        name = document.getElementById("addsubhuseltname").value;
                        jpname = document.getElementById("addsubhuseltjpname").value;
                    }
                    else if (turul === "suvarga") {
                        name = document.getElementById("addsuvarganame").value;
                        info = document.getElementById("addsuvargainfo").value;
                        jpname = document.getElementById("addsuvargatjpname").value;
                    }
                    if (name !== "") {
                        $.ajax({
                            url: '/admin/addpage/productSubIdAction',
                            type: 'POST',
                            data: jQuery.param({
                                type: "addproductsub",
                                name: name,
                                info: info,
                                jpname: jpname,
                                turul: turul
                            }),
                            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                            success: function(detialres) {
                                location.reload();
                            },
                            error: function(deterr) {
                                location.reload();
                            }
                        });
                    }
                }
                var tabEl = document.querySelector('button[data-bs-toggle="tab"]')
                tabEl.addEventListener('shown.bs.tab', function(event) {
                    event.target // newly activated tab
                    event.relatedTarget // previous active tab
                });

                function editM(id, name) {
                    console.log("ok" + name);
                    document.querySelector('#menuidedit').value = id;
                    document.querySelector('#menutitleedit').value = name;
                }
            </script>
            <?php require 'end.php'; ?>