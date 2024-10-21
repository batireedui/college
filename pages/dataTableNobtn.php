<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        let table = $('#datalistnobtn').DataTable({
            sDom: "B<'row'><'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-4'i>><'row'<'#colvis'>p>",
            columnDefs: [{
                "targets": 0,
                "searchable": false
            }],
            oLanguage: {
                "sSearch": "Хайлт хийх:",
                "oPaginate": {
                    "sNext": ">",
                    "sPrevious": "<"
                },
            },
            paging: false, // Хуудаслалтыг хаах
            info: false, // Доорх мэдээллийг нууцлах
            lengthMenu: [
                [-1],
                ["All"]
            ] // Хэрэглэгч бүх өгөгдлийг харах сонголт
        });
        let coln = table.columns().header().length;

        $('div.dataTables_filter input').addClass('form-control');
        $('div.dataTables_length select').addClass('form-control');

    });
</script>