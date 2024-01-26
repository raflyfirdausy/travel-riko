<section class="section">
    <div class="card">
        <div class="card-header">
            <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Pemesan <span class="text-danger">*</span></label>
                        <select required <?= $this->session->userdata(SESSION)["role"] === USER ? "disabled" : "" ?> class="form-control select2" id="uuid_user" name="uuid_user" style="width: 100%;">
                            <option value="">Pilih User</option>
                            <?php foreach ($user as $opt) : ?>
                                <option <?= ($this->session->userdata(SESSION)["role"] === USER && $opt["uuid"] === $this->session->userdata(SESSION)["uuid"]) ? "selected" : "" ?> value="<?= $opt["uuid"] ?>"><?= $opt["nama"] ?> (<?= $opt["username"] ?>)</option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">No Handphone <span class="text-danger">*</span></label>
                        <input onkeyup="validateNumberOnly(this)" required type="tel" id="telp" name="telp" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="">Tanggal Pemesanan <span class="text-danger">*</span></label>
                        <input required type="date" name="tanggal_pemesanan" id="tanggal_pemesanan" class="form-control" min="<?= date("Y-m-d") ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="">Lokasi Penjemputan <span class="text-danger">*</span></label>
                        <textarea required class="form-control" id="lokasi_penjemputan" name="lokasi_penjemputan" rows="3"></textarea>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-primary" onclick="lihatJadwal()" id="btnLihatJadwal">Lihat Jadwal</button>
                    </div>
                </div>
                <div class="row mt-3" id="layoutTable" style="display: none;">
                    <div class="table-responsive">
                        <table id="table_data" class="table table-sm nowrap table-bordered table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Kota Asal</th>
                                    <th>Kota Tujuan</th>
                                    <th>Nama Kendaraan</th>
                                    <th>Waktu Berangkat</th>
                                    <th>Waktu Sampai</th>
                                    <th>Sisa Kursi</th>
                                    <th>Harga</th>
                                    <th>Pilih Jadwal</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let stateLihat = "CARI" // CARI | UBAH
    const lihatJadwal = () => {
        if (stateLihat == "CARI") {
            cari()
        } else {
            stateLihat = "CARI"
            setDisable(false)
            $("#btnLihatJadwal").text("Lihat Jadwal")
            $("#btnLihatJadwal").removeClass("btn-danger")
            $("#btnLihatJadwal").addClass("btn-primary")
        }
    }

    const setDisable = (flag) => {
        $("#uuid_user").prop('disabled', flag);
        $("#telp").prop('disabled', flag);
        $("#tanggal_pemesanan").prop('disabled', flag);
        $("#lokasi_penjemputan").prop('disabled', flag);
    }

    const cari = () => {
        let pemesan = $("#uuid_user").val()
        let telp = $("#telp").val()
        let tanggal = $("#tanggal_pemesanan").val()
        let lokasi = $("#lokasi_penjemputan").val()

        if (pemesan == "") {
            Swal.fire({
                title: 'Gagal',
                html: "Silahkan input pemesan terlebih dahulu !",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Tutup'
            })
            return
        }

        if (telp == "") {
            Swal.fire({
                title: 'Gagal',
                html: "Silahkan input No handphone terlebih dahulu !",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Tutup'
            })
            return
        }

        if (tanggal == "") {
            Swal.fire({
                title: 'Gagal',
                html: "Silahkan input tanggal pemesanan terlebih dahulu !",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Tutup'
            })
            return
        }

        if (lokasi == "") {
            Swal.fire({
                title: 'Gagal',
                html: "Silahkan input Lokasi Penjemputan terlebih dahulu !",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Tutup'
            })
            return
        }

        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            text: 'Sedang mengambil data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
                $("#layoutTable").hide()
                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    contentType: "application/json; charset=utf-8",
                    url: "<?= base_url("transaksi/pemesanan/tambah/lihat-jadwal/") ?>" + tanggal,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(result) {
                        Swal.close()
                        if (result.code == 200) {
                            setDisable(true)
                            stateLihat = "UBAH"
                            $("#btnLihatJadwal").text("Ubah Jadwal")
                            $("#btnLihatJadwal").removeClass("btn-primary")
                            $("#btnLihatJadwal").addClass("btn-danger")

                            setData(result.data, pemesan, telp, tanggal, lokasi)
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
    }

    const setData = (data, pemesan, telp, tanggal, lokasi) => {
        const defaultRow = /* html */ `
            <tr>
                <td class="text-center" colspan="9">Mohon maaf, jadwal tidak ditemukan. Silahkan ubah tanggal pemesanan</td>
            </tr>
        `
        $("#bodyTable").html(defaultRow)
        let htmlAppend = ""
        data.forEach((currentValue, index, dataArray) => {
            htmlAppend += /* html */ `
                <tr>
                    <td class="text-center">${index+1}</td>
                    <td class="text-center"><img style="cursor: pointer;" onclick="showModalIframe('Detail Kendaraan', '${currentValue.image_kendaraan}', 'YA')" height="50px" src="${currentValue.image_kendaraan}" alt="${currentValue.nama_kendaraan}"></td>
                    <td>${currentValue.nama_kota_asal}</td>
                    <td>${currentValue.nama_kota_tujuan}</td>
                    <td>${currentValue.nama_kendaraan}</td>
                    <td>${currentValue.waktu_berangkat}</td>
                    <td>${currentValue.waktu_sampai}</td>
                    <td>${currentValue.sisa_kursi}</td>
                    <td>${formatRupiah(currentValue.harga)}</td>
                    <td class="text-center"><button ${currentValue.sisa_kursi === 0 ? "disabled" : ""} class="btn btn-${currentValue.sisa_kursi > 0 ? "success" : "danger"}" onclick="pilih('${currentValue.uuid}', '${pemesan}', '${telp}', '${tanggal}', '${lokasi}')">Pilih Jadwal</button></td>
                </tr>
            `
        })
        if (htmlAppend !== "") $("#bodyTable").html(htmlAppend)
        $("#layoutTable").show()
    }

    const pilih = (uuid, pemesan, telp, tanggal, lokasi) => {
        Swal.fire({
            title: "Konfirmasi Pemesanan",
            text: `Apakah ingin melakukan pemesanan travel pada tanggal ${tanggal} menggunakan jadwal yang dipilih ?`,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Tidak, batalkan",
            confirmButtonText: "Ya, pesan"
        }).then((result) => {
            if (result.isConfirmed) {
                prosesPesan(uuid, pemesan, telp, tanggal, lokasi)
            }
        })
    }

    const prosesPesan = (uuid, pemesan, telp, tanggal, lokasi) => {
        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            text: 'Sedang melakukan pemesanan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "<?= base_url("transaksi/pemesanan/tambah/proses-pesan/") ?>",
                    data: {
                        uuid_pemesan: pemesan,
                        telp: telp,
                        tanggal: tanggal,
                        lokasi: lokasi,
                        uuid_jadwal: uuid
                    },
                    success: function(result) {
                        Swal.close()
                        if (result.code == 200) {
                            Swal.fire({
                                title: "Sukses",
                                text: result.message,
                                icon: "success",
                                allowOutsideClick: false,
                                confirmButtonText: "Lanjutkan ke pembayaran"
                            }).then(x => {
                                location.href = "<?= base_url("/transaksi/pemesanan/tambah/pembayaran/") ?>" + result.data
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
    }
</script>