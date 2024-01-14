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
                        <select required class="form-control select2" id="uuid_user" name="uuid_user" style="width: 100%;">
                            <option value="">Pilih User</option>
                            <?php foreach ($user as $opt) : ?>
                                <option value="<?= $opt["uuid"] ?>"><?= $opt["nama"] ?> (<?= $opt["username"] ?>)</option>
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
                        <button class="btn btn-success" onclick="lihatJadwal()" id="btnLihatJadwal">Lihat Jadwal</button>
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
    const lihatJadwal = () => {
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
                    <td><img style="cursor: pointer;" onclick="showModalIframe('Detail Kendaraan', '${currentValue.image_kendaraan}', 'YA')" height="50px" src="${currentValue.image_kendaraan}" alt="${currentValue.nama_kendaraan}"></td>
                    <td>${currentValue.nama_kota_asal}</td>
                    <td>${currentValue.nama_kota_tujuan}</td>
                    <td>${currentValue.nama_kendaraan}</td>
                    <td>${currentValue.waktu_berangkat}</td>
                    <td>${currentValue.waktu_sampai}</td>
                    <td>${formatRupiah(currentValue.harga)}</td>
                    <td class="text-center"><button class="btn btn-success" onclick="pilih('${currentValue.uuid}', '${pemesan}', '${telp}', '${tanggal}', '${lokasi}')">Pilih Jadwal</button></td>
                </tr>
            `
        })
        if (htmlAppend !== "") $("#bodyTable").html(htmlAppend)
        $("#layoutTable").show()
    }

    const pilih = (uuid, pemesan, telp, tanggal, lokasi) => {
        console.log({
            uuid,
            pemesan,
            telp,
            tanggal,
            lokasi
        })
    }
</script>