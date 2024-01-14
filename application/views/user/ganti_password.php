<section class="section">
    <div class="row">
        <div class="col-md-12">
            <div class="card info-card">
                <div class="card-header">
                    <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
                </div>
                <form method="POST" action="<?= base_url("user/update-password") ?>" id="form_add" enctype='multipart/form-data'>
                    <div class="card-body p-3">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Password Lama <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_lama" id="password_lama">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_baru" id="password_baru">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success ml-1" style="width: 100%;">
                            <i class="fas fa-save"></i> SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $("#form_add").submit(e => {
        e.preventDefault()
        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            html: 'Proses mengubah password anda',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
                let _form = $("#form_add")
                let _url = _form.attr('action')

                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: _url,
                    data: _form.serialize(),
                    success: function(result) {
                        if (result["code"] == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                showCloseButton: true,
                                text: `${result["message"]}`,
                                confirmButtonText: 'Tutup',
                            }).then((result) => {
                                window.location.href = "<?= current_url() ?>";
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                showCloseButton: true,
                                text: `${result["message"]}`,
                                confirmButtonText: 'Tutup',
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Gagal", xhr.responseText, "error")
                    }
                })

            }
        })
    })
</script>