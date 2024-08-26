<div class="position-fixed bottom-0 end-0 p-3 " style="z-index: 11">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto" style="color: #fff">Мэдэгдэл!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bg-secaondary" id="toastbody">

        </div>
    </div>
</div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function row_click(id) {
        $(".table_rows").removeClass("active_row");

        $("#trow-" + id).addClass("active_row");
    }

    function updateSedev(element, id) {
        var value = element.innerText;
        console.log(id + value);
        $.ajax({
            url: '/att/ajax-sedev',
            type: 'post',
            data: {
                attid: id,
                sedev: value
            },
            success: function(data) {

            }
        })
    }
</script>
<script src="/js/print.js"></script>