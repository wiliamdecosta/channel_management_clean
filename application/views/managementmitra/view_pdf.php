<!-- Modal -->
<script type='text/javascript'>

    function embedPDF(){
        var myPDF = new PDFObject({
            url: 'application/third_party/upload/pks/PKS_INDUK_1455085184.pdf'
        }).embed();
    }
    my_window = window.open("", '_blank');
    my_window.document.write(embedPDF);
   // window.onload = embedPDF; //Feel free to replace window.onload if needed.
</script>
<div class="modal fade" id="modal_view_pdf" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 98%; height: 92%">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>This is a large modal.</p>
                <div id="embeded">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        embedPDF();
    });
</script>


