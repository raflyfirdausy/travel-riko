<div class="">
    <div class="card">
        <div class="card-header">
            <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
        </div>
        <form method="POST" id="form_add" action="/master/pengaturan/proses-simpan" enctype='multipart/form-data'>
            <div class="card-body">
                <div class="form-group">
                    <div class="row">

                        <div class="col-md-2 mt-3">
                            <b>Favicon</b>
                        </div>
                        <div class="col-md-10 mt-3">
                            <?php $favicoLogo = getSetting("FAVICO_WEBSITE"); ?>
                            <img id="favicoWebsite" class="img mb-2" src="<?= setImage(LOKASI_PENGATURAN, $favicoLogo, NO_IMAGE) ?>" height="50px" alt="<?= getSetting("FAVICO_WEBSITE") ?>" />
                            <input accept="image/*" id="favicoInput" value="<?= $favicoLogo ?>" type="file" name="FAVICO_WEBSITE" class="form-control">
                        </div>

                        <div class="col-md-2 mt-3">
                            <b>Logo Website</b>
                        </div>
                        <div class="col-md-10 mt-3">
                            <?php $imageLogo = getSetting("LOGO_WEBSITE"); ?>
                            <img id="logoWebsite" class="img mb-2" src="<?= setImage(LOKASI_PENGATURAN, $imageLogo, NO_IMAGE) ?>" height="100px" alt="<?= getSetting("JUDUL_WEBSITE") ?>" />
                            <input accept="image/*" id="logoInput" value="<?= $imageLogo ?>" type="file" name="LOGO_WEBSITE" class="form-control">
                        </div>

                        <div class="col-md-2 mt-3">
                            <b>Judul Website</b>
                        </div>
                        <div class="col-md-10 mt-3">
                            <input value="<?= getSetting("JUDUL_WEBSITE") ?>" type="text" name="JUDUL_WEBSITE" class="form-control">
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button style="width: 100%;" type="submit" class="btn btn-success proses_btn">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader()
            reader.onload = function(e) {
                $('#logoWebsite').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#logoInput").change(function() {
        readURL(this);
    })

    function readURLFavico(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader()
            reader.onload = function(e) {
                $('#favicoWebsite').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#favicoInput").change(function() {
        readURLFavico(this);
    })

    $(`#form_add`).submit(e => {
        e.preventDefault()
        var form = $(`#form_add`)[0]
        var data = new FormData(form)

        $(".proses_btn").prop('disabled', true)
        $(".proses_btn").text("Sedang menyimpan data...")

        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            text: 'Sedang menyimpan data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?= base_url("master/pengaturan/proses-simpan") ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(result) {
                        $(".proses_btn").prop('disabled', false)
                        $(".proses_btn").text("Simpan")
                        if (result.code == 200) {
                            Swal.fire({
                                title: 'Sukses',
                                text: result.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            })
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                html: result.message,
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            })
                        }

                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $(".proses_btn").prop('disabled', false)
                        $(".proses_btn").text("Simpan")
                        Swal.fire({
                            title: 'Gagal',
                            text: xhr.responseText,
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tutup'
                        })
                    }
                })
            }
        })
    })
</script>