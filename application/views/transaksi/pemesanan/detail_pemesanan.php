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
                    </tr>
                    <tr>
                        <td> <img width="100%" src="<?= $detail["transfer_bukti"] ?>" alt="Bukti pembayaran"> </td>
                    </tr>
                </table>
            </div>
        </div>



    </div>
</div>