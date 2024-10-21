<?php require ROOT . "/pages/start.php"; ?>
<link rel="stylesheet" type="text/css" href="/css/dataTable.css">
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<?php
require ROOT . "/pages/header.php";

    _selectNoParam(
        $stj,
        $coj,
        "select id, this_on from jil order by this_on desc",
        $j_id,
        $j_name
    );
?>
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding: 20px;">
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-6 col-sm-12">
                    <div class="col-sm-6:eq(0)"></div>
                    <?php //echo "SELECT students.id, fname, lname, students.phone, gender, schools.school_name, schools.id, angis.angi, angis.buleg, angis.id, rd FROM students INNER JOIN schools ON students.school_id = schools.id INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 " . $sql; 
                    ?>
                    <h4 class="fw-bold py-3 mb-4">Эрсдлийн түвшин</h4>
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
                        <select id="gtype" class="select2 form-control " data-allow-clear="true">
                            <option value="1">Өндөр эрсдэлтэй</option>
                            <option value="2">Дунд эрсдэлтэй</option>
                            <option value="3">Бага эрсдэлтэй</option>
                            <option value="4">Эрсдэлгүй</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <button class="btn btn-outline-primary" id="getdata">Харах</button>
                    </div>
                </div>
                <div class="row">
                    <div id="barChart"></div>
                </div>
                <?php if (isset($_SESSION['messages'])) : ?>
                <div class="col-lg-6 col-sm-12">
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        <?php foreach ($_SESSION['messages'] as $v) {
                            echo "$v";
                        } ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <?php unset($_SESSION['messages']); endif ?>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Эцэг/эх-ийн нэр</th>
                            <th>Нэр</th>
                            <th>РД</th>
                            <th>Утас</th>
                            <th>Хүйс</th>
                            <th>Сургууль</th>
                            <th>Анги</th>
                            <th>Бүлэг</th>
                            <th>Судалгаа</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <th>#</th>
                            <th>Эцэг/эх-ийн нэр</th>
                            <th>Нэр</th>
                            <th>РД</th>
                            <th>Утас</th>
                            <th>Хүйс</th>
                            <th>Сургууль</th>
                            <th>Анги</th>
                            <th>Бүлэг</th>
                             <th>Судалгаа</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script type="text/javascript">
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
                    text: "Эрсдлийн түвшин"
                  }
                })   
                
            }
            itemGet();
            function itemGet(){
                $.ajax({
                    type: 'POST',
                    url: 'ajax-ersdel',
                    data: jQuery.param({
                        type: "itemvalget",
                        jil: document.getElementById("jil").value
                    }),
                     beforeSend: function() {
                        $('#getdata').html("Түр хүлээнэ үү");
                    },
                    success: async function(data) {
                        data = JSON.parse(data);
                        console.log(data);
                        setData(data.sstoo, data.ssname);
                        $('#getdata').html("ХАРАХ");
                    }
                });
            }
            $(document).ready(function() {
                let tables = $('#datalist').DataTable({
                    displayLength: 50,
                    lengthMenu: [50, 100, 150, 200, 500, 1000],
                    processing: true,
                    serverSide: true,
                    ajax: {
                    url: 'ss-ersdel',
                        type: "GET",
                        data: function(data) {
                            // Read values
                            var gtype = $('#gtype').val();
                            var jil =  document.getElementById("jil").value;
                            data.gtype = gtype;
                            data.jil = jil;
                        }
                    },
                    columns: [{
                            data: 'student_id'
                        },
                        {
                            data: 'fname'
                        },
                        {
                            data: 'lname'
                        },
                        {
                            data: 'rd'
                        },
                        {
                            data: 'phone'
                        },
                        {
                            data: 'gender'
                        },
                        {
                            data: 'school_name'
                        },
                        {
                            data: 'angi'
                        },
                        {
                            data: 'buleg'
                        },
                        {
                            data: null,
                            "bSortable": false,
                            "mRender": function(data) {
                                return '<a href="/sudalgaa/insertsudalgaa?id=' + data.student_id + '&angi=' + data.angi_id + '&type=2"><div class="btn btn-warning">ХАРАХ</div></a>';;
                            }
                        }
                    ],
                    sDom: "B<'row'><'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-4'i>><'row'<'#colvis'>p>",
                    buttons: [{
                            extend: 'copy',
                            className: 'btn btn-outline-primary',
                            text: '<span><i class="bx bx-copy me-2"></i>Copy</span>'
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-outline-primary',
                            text: '<span><i class="bx bx-file me-2"></i>Excel</span>'
                        },
                        {
                            extend: 'pdf',
                            className: 'btn btn-outline-primary',
                            text: '<span><i class="bx bxs-file-pdf me-2"></i>Pdf</span>'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-outline-primary',
                            text: '<span><i class="bx bx-printer me-2"></i>Хэвлэх</span>',
                            exportOptions: {
                                columns: [<?php
                                            for ($i = 0; $i <= $columnNumber - 1; $i++) {
                                                echo $i;
                                                echo $i == $columnNumber - 1 ? "" : ", ";
                                            }
                                            ?>]
                            }
                        },
                    ],
                    columnDefs: [{
                        "targets": 0,
                        "searchable": false
                    }],
                    oLanguage: {
                        "sLengthMenu": "Дэлгэцэнд _MENU_ бичлэгээр",
                        "sSearch": "Хайлт хийх:",
                        "oPaginate": {
                            "sNext": "Дараах",
                            "sPrevious": "Өмнөх"
                        },
                        "sInfo": "Нийт _TOTAL_ бүртгэл (_START_ / _END_)",
                        "sInfoFiltered": " - хайлт хийсэн _MAX_ -н бүртгэл"
                    },

                });
                let coln = tables.columns().header().length;

                $('div.dataTables_filter input').addClass('form-control');
                $('div.dataTables_length select').addClass('form-control');
                
                $('#getdata').click(function() {
                    tables.draw();
                    itemGet();
                });
            });
            
        </script>
        <?php require ROOT . "/pages/end.php"; ?>