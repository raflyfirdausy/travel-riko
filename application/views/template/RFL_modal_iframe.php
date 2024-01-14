<div class="modal fade" id="modal_iframe" role="dialog" aria-labelledby="modal_iframe_label">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h4 class="modal-title text-white" id="titleIframe"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="contentIframe" frameborder="0" style="width: 100%;height: 80vh;" allowfullscreen></iframe>
                <img width="100%" class="img img-responsive" id="imgIframe">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#modal_iframe").on("hidden.bs.modal", e => {
        $("#contentIframe").attr('src', "")
    })
</script>