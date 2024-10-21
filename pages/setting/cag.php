<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
_selectNoParam(
    $st,
    $cc,
    "SELECT id, lon, lat, zai, tai FROM location",
    $c_id,
    $c_lon,
    $c_lat,
    $c_zai,
    $tai
);
_selectNoParam(
    $tst,
    $tcc,
    "SELECT id, c1, c2, c3, c4, eseh FROM att_time",
    $t_id,
    $t_1,
    $t_2,
    $t_3,
    $t_4,
    $eseh
);
?>
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<div class="row">
    <div class="col border border-success rounded p-3 m-3">
        <div class="p-3 bg-light d-flex justify-content-between align-items-center">
            <h3>Цаг бүртгүүлэх байршил</h3>
        </div>
        <form action="/setting/ajax" method="post" class="row">
            <div class="col mb-4">
                <label class="form-label" for="lon" style="margin-left: 0px;">lon</label>
                <input type="text" name="lon" id="lon" class="form-control" required="" placeholder="104.04998">
            </div>
            <div class="col mb-4">
                <label class="form-label" for="lat" style="margin-left: 0px;">lat</label>
                <input type="text" name="lat" id="lat" class="form-control" required="" placeholder="49.02813">
            </div>
            <div class="col mb-4">
                <label class="form-label" for="zai" style="margin-left: 0px;">Хамрах хүрээ</label>
                <input type="text" name="zai" id="zai" class="form-control" required="" placeholder="100">
            </div>
            <div class="col mb-4">
                <label class="form-label" for="tai" style="margin-left: 0px;">Тайлбар</label>
                <input type="text" name="tai" id="tai" class="form-control" required="" placeholder="100">
            </div>
            <div class="mb-4">
                <input type="submit" class="btn btn-success" name="addLocation" value='БҮРТГЭХ' />
            </div>
        </form>
    </div>
    <div class="col border border-success rounded p-3 m-3">
        <div id="table">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th>lon</th>
                        <th>lat</th>
                        <th>Хамрах хүрээ</th>
                        <th>Тайлбар</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $d = 1;
                    while (_fetch($st)) { ?>
                        <tr>
                            <td><?= $d ?></td>
                            <td><?= $c_lon ?></td>
                            <td><?= $c_lat ?></td>
                            <td><?= $c_zai ?></td>
                            <td id="<?= $c_id ?>tai"><?= $tai ?></td>
                            <td>
                                <i class="fas fa-trash m-1 fa-lg text-danger" type="button" onclick="deleteBtn(<?= $c_id ?>)"></i>
                                <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#changeCag" onclick="editBtn(<?= $c_id ?>, '<?= $c_lon ?>', '<?= $c_lat ?>', '<?= $c_zai ?>')"></i>
                            </td>
                        </tr>
                    <?php $d++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col border border-success rounded p-3 m-3">
        <div class="p-3 bg-light d-flex justify-content-between align-items-center">
            <h3>Ажлын цаг</h3>
        </div>
        <form action="/setting/ajax" method="post" class="row">
            <div class="col mb-4">
                <label class="form-label" for="c1" style="margin-left: 0px;">Ирэх</label>
                <input type="time" name="c1" id="c1" class="form-control" required="" placeholder="104.04998">
            </div>
            <div class="col mb-4">
                <label class="form-label" for="c2" style="margin-left: 0px;">Өдөр явах</label>
                <input type="time" name="c2" id="c2" class="form-control" required="" placeholder="49.02813">
            </div>
            <div class="col mb-4">
                <label class="form-label" for="c3" style="margin-left: 0px;">Өдөр ирэх</label>
                <input type="time" name="c3" id="c3" class="form-control" required="" placeholder="100">
            </div>
            <div class="col mb-4">
                <label class="form-label" for="c4" style="margin-left: 0px;">Тарах</label>
                <input type="time" name="c4" id="c4" class="form-control" required="" placeholder="100">
            </div>
            <div class="mb-4">
                <input type="submit" class="btn btn-success" name="addHuvaari" value='БҮРТГЭХ' />
            </div>
        </form>
    </div>
    <div class="col border border-success rounded p-3 m-3">
        <div id="table">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th>Ирэх</th>
                        <th>Өдөр явах</th>
                        <th>Өдөр ирэх</th>
                        <th>Тарах</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $d = 1;
                    while (_fetch($tst)) { ?>
                        <tr>
                            <td><?= $d ?></td>
                            <td><div class='editcell' onblur='updateCag(this, <?=$t_id?>, "c1")' contenteditable=''><?= $t_1 ?></div></td>
                            <td><div class='editcell' onblur='updateCag(this, <?=$t_id?>, "c2")' contenteditable=''><?= $t_2 ?></td>
                            <td><div class='editcell' onblur='updateCag(this, <?=$t_id?>, "c3")' contenteditable=''><?= $t_3 ?></td>
                            <td><div class='editcell' onblur='updateCag(this, <?=$t_id?>, "c4")' contenteditable=''><?= $t_4 ?></td>
                            <td>
                                <input type="radio" name="cagSongo" onchange='esehCag(<?=$t_id?>)' value="<?= $t_id ?>" <?php echo $eseh == 1 ? "checked" : ""?> />
                            </td>
                        </tr>
                    <?php $d++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="changeCag" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeLabel">Цаг бүртгүүлэх байршил засах</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/setting/ajax" method="post">
                    <input type="text" value="0" id="eid" name="eid" readonly="" style="display: none;">
                    <div class="mb-4">
                        <label class="form-label" for="elon" style="margin-left: 0px;">lon</label>
                        <input type="text" name="elon" id="elon" class="form-control" required="" placeholder="104.04998">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="elat" style="margin-left: 0px;">lat</label>
                        <input type="text" name="elat" id="elat" class="form-control" required="" placeholder="49.02813">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="ezai" style="margin-left: 0px;">Хамрах хүрээ</label>
                        <input type="text" name="ezai" id="ezai" class="form-control" required="" placeholder="100">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="etai" style="margin-left: 0px;">Тайлбар</label>
                        <input type="text" name="etai" id="etai" class="form-control" required="" placeholder="Төв байр">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                <button type="submit" name="locationEdit" class="btn btn-primary">Хадгалах</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="changeTime" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeLabel">Цагийн хуваарь засах</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/setting/ajax" method="post">
                    <input type="text" value="0" id="eid" name="eid" readonly="" style="display: none;">
                    <div class="mb-4">
                        <label class="form-label" for="elon" style="margin-left: 0px;">Ирэх цаг</label>
                        <input type="text" name="elon" id="elon" class="form-control" required="" placeholder="104.04998">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="elat" style="margin-left: 0px;">Өдөр явах</label>
                        <input type="text" name="elat" id="elat" class="form-control" required="" placeholder="49.02813">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="ezai" style="margin-left: 0px;">Өдөр ирэх</label>
                        <input type="text" name="ezai" id="ezai" class="form-control" required="" placeholder="100">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="etai" style="margin-left: 0px;">Тарах цаг</label>
                        <input type="text" name="etai" id="etai" class="form-control" required="" placeholder="Төв байр">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                <button type="submit" name="locationEdit" class="btn btn-primary">Хадгалах</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function updateCag(element, id, f) {
        var value = element.innerText;
        console.log(id + value);
        $.ajax({
            url: 'ajax',
            type: 'POST',
            data: {
                turul: "cagEdit",
                id: id,
                f: f,
                val: value
            },
            success: function(data) {
                alert(data);
            }
        })
    }
    function esehCag(id) {
        $.ajax({
            url: 'ajax',
            type: 'POST',
            data: {
                turul: "esehCag",
                id: id
            },
            success: function(data) {
                alert(data);
            }
        })
    }
    function editBtn(id, lon, lat, zai) {
        $('#changeinfo').hide();
        $('#eid').val(id);
        $('#elon').val(lon);
        $('#elat').val(lat);
        $('#ezai').val(zai);
        $('#etai').val($('#'+ id + 'tai').text());
    }

    function tshow() {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        toastList.forEach(toast => toast.show())
    }

    function deleteBtn(id) {
        let result = confirm("Та устгахдаа итгэлтэй байна уу?");
        if (result === true) {
            $.ajax({
                url: "/setting/ajax",
                type: "POST",
                data: {
                    mode: "location_Delete",
                    id: id
                },
                error: function(xhr, textStatus, errorThrown) {},
                beforeSend: function() {},
                success: function(data) {
                    if (data == "Амжилттай") {
                        window.location.reload();
                    } else {
                        $('#toastbody').html(data);
                        tshow();
                    }
                },
                async: true
            });
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<?php
require ROOT . "/pages/end.php";
?>