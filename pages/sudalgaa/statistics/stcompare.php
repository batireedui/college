<?php require ROOT . "/pages/start.php"; ?>
<link rel="stylesheet" type="text/css" href="/css/dataTable.css">

<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css " />
<?php
require ROOT . "/pages/header.php";

_selectNoParam(
    $stmt,
    $count,
    "SELECT DISTINCT s_shalguurs.id, s_shalguurs.name, s_shalguurs.ded, s_shalguurs.hariulttype, s_shalguurs.turul FROM `s_shalguurs` WHERE tuluv=1",
    $shalguur_id,
    $shalguur_name,
    $shalguur_ded,
    $shalguur_hariulttype,
    $shalguur_turul
);

    _selectNoParam(
        $stj,
        $coj,
        "select id, this_on from jil order by this_on desc",
        $j_id,
        $j_name
    )
?>
        <div class="card" style="padding: 20px;">
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-6 col-sm-12">
                    <div class="col-sm-6:eq(0)"></div>
                    <h4 class="fw-bold py-3 mb-4">Сургууль</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-sm-12">
                    <select class="select2 form-control " data-allow-clear="true" id="jil">
                        <?php while (_fetch($stj)) {?>
                        <option value="<?=$j_name?>"><?=$j_name?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <select id="selectShalg" class="select2 form-control " data-allow-clear="true">
                        <?php
                        while (_fetch($stmt)) {
                            echo "<option value='$shalguur_id'>$shalguur_name</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <button class="btn btn-outline-primary" onclick="clickShalg()">Харах</button>
                </div>
            </div>
            <div class="row">
                <div id="val">

                </div>
                <div id="barChart"></div>
            </div>
            <div class="row">
                <div id="itemval">

                </div>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <script src="/assets/vendor/libs/select2/select2.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
                var options = {
                    series: [{
                      name: 'Inflation',
                      data: []
                    }],
                      chart: {
                      height: 250,
                      type: 'bar',
                    },
                    plotOptions: {
                      bar: {
                        borderRadius: 10,
                        dataLabels: {
                          position: 'top', // top, center, bottom
                        },
                      }
                    },
                    dataLabels: {
                      enabled: true,
                      formatter: function (val) {
                        return val;
                      },
                      offsetY: -20,
                      style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                      }
                    },
                    
                    xaxis: {
                      categories: [],
                      axisBorder: {
                        show: false
                      },
                      axisTicks: {
                        show: false
                      },
                      crosshairs: {
                        fill: {
                          type: 'gradient',
                          gradient: {
                            colorFrom: '#D8E3F0',
                            colorTo: '#BED1E6',
                            stops: [0, 100],
                            opacityFrom: 0.4,
                            opacityTo: 0.5,
                          }
                        }
                      },
                      tooltip: {
                        enabled: true,
                      }
                    },
                    yaxis: {
                      axisBorder: {
                        show: false
                      },
                      axisTicks: {
                        show: false,
                      },
                      labels: {
                        show: false,
                        formatter: function (val) {
                          return val;
                        }
                      }
                    
                    },
                    title: {
                      text: '',
                      floating: true,
                      align: 'center',
                      style: {
                        color: '#444'
                      }
                    }
                };

            var chart1 = new ApexCharts(document.querySelector("#barChart"), options);
            chart1.render();

            function clickShalg(){
                let id = document.getElementById("selectShalg").value;
                $("#val").html('<button class="btn btn-primary" type="button" disabled><span class="spinner-border me-1" role="status" aria-hidden="true"></span></button>');
                $("#barChart").html("");
                $.ajax({
                    type: 'POST',
                    url: 'ajax-listval',
                    data: jQuery.param({
                        type: "valget",
                        id: id,
                        jil: document.getElementById("jil").value
                    }),
                    success: async function(data) {
                        data = JSON.parse(data);
                        $("#val").html(data.val);
                        $("#itemval").html("");
                        /*let cdata = [0];
                        let ccate = ["0"];
                        data.schools.map((item) => {
                                cdata.push(item.stoo);
                                ccate.push(item.sname);
                        })
                        chart(cdata, ccate);*/
                        //cdata = await data.sstoo;
                        //ccate = await data.ssname;
                        setData(data.sstoo, data.ssname);
                    }
                });
            }
            function setData(sstoo, ssname){
                console.log(ssname);
                chart1.updateSeries([{
                    name: "Тийм",
                    data: sstoo
                  }])
                chart1.updateOptions({
                    xaxis: {
                      categories: ssname
                   },
                   title: {
                    text: $("#selectShalg option:selected").text()
                  }
                })   
                
            }
            function itemGet(id, val){
                $("#itemval").html('<button class="btn btn-primary" type="button" disabled><span class="spinner-border me-1" role="status" aria-hidden="true"></span></button>');
                $.ajax({
                    type: 'POST',
                    url: 'ajax-listval',
                    data: jQuery.param({
                        type: "itemvalget",
                        id, id,
                        getval: val,
                        jil: document.getElementById("jil").value
                    }),
                    success: function(data) {
                        $("#itemval").html(data);
                        console.log(data);
                    }
                });
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>