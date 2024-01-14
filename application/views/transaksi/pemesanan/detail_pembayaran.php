<div class="card">
    <div class="card-header">
        <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h4>Informasi Pemesanan</h4>
            </div>
            <div class="col-md-6">
                <table class="table table-sm nowrap table-bordered">
                    <tr>
                        <td>Nama</td>
                        <td><?= $detail["nama_pemesan"] ?></td>
                    </tr>
                    <tr>
                        <td>No Telp</td>
                        <td><?= $detail["no_hp"] ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Pemesanan</td>
                        <td><?= longdate_indo($detail["tanggal_pemesanan"], TRUE) ?></td>
                    </tr>

                    <tr>
                        <td>Kota Asal & Tujuan</td>
                        <td><?= $detail["nama_kota_asal"] . " - " . $detail["nama_kota_tujuan"] ?></td>
                    </tr>
                    <tr>
                        <td>Waktu Berangkat s.d Sampai</td>
                        <td><?= $detail["waktu_berangkat"] . " s.d " . $detail["waktu_sampai"] ?></td>
                    </tr>
                    <tr>
                        <td>Nama Kendaraan</td>
                        <td><?= $detail["nama_kendaraan"] ?></td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td><?= Rupiah2($detail["harga"]) ?></td>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td><?= $detail["status"] ?></td>
                    </tr>
                    <tr>
                        <td>Lokasi Penjemputan</td>
                        <td><?= $detail["lokasi_penjemputan"] ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm nowrap table-bordered">

                    <tr>
                        <td>Bukti Transfer</td>
                        <td> <img width="100%" src="<?= $detail["transfer_bukti"] ?>" alt="Bukti pembayaran"> </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="form-group">
            <form method="POST" id="form_pembayaran" enctype='multipart/form-data'>
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Rekening Tujuan <span class="text-danger">*</span></label>
                        <select required class="form-control select2" id="uuid_rekening" name="uuid_rekening" style="width: 100%;">
                            <option value="">Pilih Rekening Tujuan</option>
                            <?php foreach ($rekening as $opt) : ?>
                                <option value="<?= $opt["uuid"] ?>"><?= $opt["bank"] ?> a.n <?= $opt["nama"] ?> - No Rek : <?= $opt["no_rek"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-12 mt-2">
                        <label for="">Bukti Transfer <span class="text-danger">*</span></label>
                        <input required accept="image/*" required type="file" name="bukti_transfer" class="form-control">
                        <small class="text-info">Ukuran Maksimal : 5Mb, File diterima : jpg,png,jpeg</small>
                    </div>
                    <div class="col-md-12 mt-2">
                        <input type="hidden" name="id_data" value="<?= $detail["uuid"] ?>">
                        <button class="btn btn-success proses_btn" style="width: 100%;">Simpan</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    let formId = "form_pembayaran"
    $(`#${formId}`).submit(e => {
        e.preventDefault()
        var form = $(`#${formId}`)[0]
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
                    url: "<?= base_url("transaksi/pemesanan/tambah/proses-transfer") ?>",
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
                            }).then((result) => {
                                $(`#${formId}`).trigger("reset");
                                // location.href = "<?= base_url("transaksi/pemesanan/tambah") ?>"
                                location.reload()
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