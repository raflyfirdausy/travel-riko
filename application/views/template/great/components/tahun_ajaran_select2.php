<div class="row">
    <div class="col-sm-10">
        <select name="tahun_ajaran" id="tahunAjaran" class="form-select" aria-label="Tahun ajaran">
            <option value="<?= $TH_AJARAN["th_key"] ?>" selected="selected"><?= $TH_AJARAN["th_value"] ?></option>
        </select>
    </div>
    <div class="col-sm-2 p-0">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddTahunAjaran"><i class="fas fa-plus"></i></button>
    </div>
</div>

<div class="modal fade" id="modalAddTahunAjaran" tabindex="-1">
    <div class="modal-dialog modal-md">
        <form method="POST" action="/api/web/setting/tahun-ajaran" id="form_add_tahun_ajaran" enctype='multipart/form-data'>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah data tahun ajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran" placeholder="Contoh : <?= date("Y") ?>/<?= date("Y", strtotime("+1 year")) ?>">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Keterangan </label>
                        <textarea class="form-control" name="keterangan_tahun_ajaran" id="keterangan_tahun_ajaran" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn_simpan">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(e => {
        initSelect2TahunAjaran()
    })

    $("#form_add_tahun_ajaran").submit(e => {
        e.preventDefault()

        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            html: 'Sedang menyimpan data tahun ajaran...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
                let _form = $("#form_add_tahun_ajaran")
                let _url = _form.attr('action')

                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: _url,
                    data: _form.serialize(),
                    success: function(result) {
                        Swal.close()
                        if (result["code"] == 200) {
                            $('#modalAddTahunAjaran').modal('hide');
                            $('#form_add_tahun_ajaran').trigger("reset");
                            toastr.success(result.message, 'Sukses', {
                                closeButton: true,
                                timeOut: 5000
                            });
                        } else {
                            toastr.error(result.message, 'Gagal', {
                                closeButton: true,
                                timeOut: 5000
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.close()
                        toastr.error(xhr.responseText, 'Gagal', {
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                })

            }
        })
    })

    const initSelect2TahunAjaran = () => {
        let element = $("#tahunAjaran")
        let endpoint = "/api/web/select2/tahun-ajaran"
        let placeholder = "Pilih tahun ajaran"

        generateSelect2ServerSide(element, endpoint, placeholder)
    }
</script>