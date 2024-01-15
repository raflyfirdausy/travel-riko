<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tambah extends RFL_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            "Jadwal_model"      => "jadwal",
            "jadwalView_model"  => "vJadwal",
            "User_model"        => "user",
            "Booking_model"     => "booking",
            "Rekening_model"    => "rekening"
        ]);
    }

    public function index()
    {
        $dataPengguna   = $this->user->where(["role" => USER])->order_by("nama", "ASC")->get_all() ?: [];

        $data       = [
            "title"     => "Tambah Pemesanan",

            "user"      => $dataPengguna
        ];
        $this->loadRFLView("transaksi/pemesanan/data_tambah", $data);
    }

    public function lihat_jadwal($tanggal = "")
    {
        if (empty($tanggal)) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Silahkan input tanggal terlebih dahulu"
            ]);
            die;
        }

        if (!validateDate($tanggal)) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Format tanggal tidak sesuai"
            ]);
            die;
        }

        $noHari         = date("N", strtotime($tanggal));

        $jadwal         = $this->vJadwal->where(["no_hari" => $noHari, "aktif" => "YA"])->get_all() ?: [];
        for ($i = 0; $i < sizeof($jadwal); $i++) {
            $jadwal[$i]["image_kendaraan"]  = setImage(LOKASI_ARMADA, $jadwal[$i]["image_kendaraan"]);

            $currentBooking                 = $this->booking->where(["uuid_jadwal" => $jadwal[$i]["uuid"], "status !=" => DITOLAK])->count_rows();
            $jadwal[$i]["kapasitas"]        = $jadwal[$i]["kapasitas"] ?: 0;
            $jadwal[$i]["sisa_kursi"]       = $jadwal[$i]["kapasitas"] - $currentBooking;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => $noHari,
            "data"      => $jadwal
        ]);
    }

    public function proses_pesan()
    {
        $uuidPemesan        = $this->input->post("uuid_pemesan");
        $telp               = $this->input->post("telp");
        $tanggal            = $this->input->post("tanggal");
        $lokasi             = $this->input->post("lokasi");
        $uuidJadwal         = $this->input->post("uuid_jadwal");

        if (!validateDate($tanggal)) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Mohon maaf, format tanggal tidak sesuai. Silahkan coba lagi"
            ]);
            die;
        }

        $pemesan            = $this->user->where(["uuid" => $uuidPemesan])->get();
        if (!$pemesan) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Mohon maaf, data user tidak ditemukan. Silahkan coba lagi"
            ]);
            die;
        }

        $jadwal             = $this->vJadwal->where(["uuid" => $uuidJadwal])->get();
        if (!$jadwal) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Mohon maaf, data jadwal tidak ditemukan. Silahkan coba lagi"
            ]);
            die;
        }

        $dataInsert         = [
            "uuid_pemesan"          => $pemesan["uuid"],
            "uuid_jadwal"           => $jadwal["uuid"],
            "status"                => MENUNGGU,
            "nama_pemesan"          => $pemesan["nama"],
            "nama_kota_asal"        => $jadwal["nama_kota_asal"],
            "nama_kota_tujuan"      => $jadwal["nama_kota_tujuan"],
            "nama_kendaraan"        => $jadwal["nama_kendaraan"],
            "nopol_kendaraan"       => $jadwal["nopol_kendaraan"],
            "waktu_berangkat"       => $jadwal["waktu_berangkat"],
            "waktu_sampai"          => $jadwal["waktu_sampai"],
            "harga"                 => $jadwal["harga"],
            "tanggal_pemesanan"     => $tanggal,
            "lokasi_penjemputan"    => $lokasi,
            "no_hp"                 => $telp,
        ];

        $insert = $this->booking->insert($dataInsert);
        if (!$insert) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat melakukan booking"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil melakukan proses booking, Silahkan lanjutkan ke proses pembayaran",
            "data"      => $insert
        ]);
    }

    public function pembayaran($uuid = NULL)
    {
        $detail     = $this->booking->where(["uuid" => $uuid])->get();
        if (!$detail) {
            redirect(base_url("/"));
        }

        $detail["transfer_bukti"] = setImage(LOKASI_TRANSFER, $detail["transfer_bukti"]);

        $rekening = $this->rekening->get_all() ?: [];
        for ($i = 0; $i < sizeof($rekening); $i++) {
            $rekening[$i]["image"] = setImage(LOKASI_REKENING, $rekening[$i]["image"]);
        }

        $data       = [
            "title"     => "Detail pembayaran",
            "detail"    => $detail,
            "rekening"  => $rekening
        ];
        $this->loadRFLView("transaksi/pemesanan/detail_pembayaran", $data);
    }

    public function proses_transfer()
    {
        $idData         = $this->input->post("id_data");
        $uuidRekening   = $this->input->post("uuid_rekening");

        $booking        = $this->booking->where(["uuid" => $idData])->get();
        if (!$booking) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data booking tidak ditemukan. Silahkan coba lagi"
            ]);
            die;
        }

        $rekening       = $this->rekening->where(["uuid" => $uuidRekening])->get();
        if (!$rekening) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Data rekening tidak ditemukan. Silahkan coba lagi"
            ]);
            die;
        }

        $dataUpdate     = [
            "transfer_atas_nama"        => $rekening["nama"],
            "transfer_bank"             => $rekening["bank"],
            "transfer_norek"            => $rekening["no_rek"],
            "transfer_bukti"            => "",
        ];

        //! UPLOAD FILE IF EXISTS  
        $fileName      = "bukti_transfer";
        if (empty($_FILES[$fileName]["name"])) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Bukti transfer tidak ditemukan. Silahkan coba lagi"
            ]);
            die;
        }

        $configUpload   = [
            "upload_path"       => LOKASI_TRANSFER,
            "allowed_types"     => "jpg|png|jpeg|webp",
            "max_size"          => 5 * 1024,
            "encrypt_name"      => TRUE,
            "remove_space"      => TRUE,
            "overwrite"         => TRUE,
        ];

        if (!file_exists($configUpload['upload_path'])) {
            mkdir($configUpload['upload_path'], 0777, TRUE);
        }

        $this->upload->initialize($configUpload);
        $upload                 = $this->upload->do_upload($fileName);
        if (!$upload) {
            echo json_encode([
                "code"          => 503,
                "message"       => "Terjadi kesalahan saat mengupload bukti transfer. Keterangan : " . $this->upload->display_errors("", ""),
                "data"          => NULL
            ]);
            die;
        }

        $dataUpload                     = $this->upload->data();
        $dataUpdate["transfer_bukti"]   = $dataUpload["file_name"];

        if (is_file(LOKASI_TRANSFER . $booking["transfer_bukti"])) {
            unlink(LOKASI_TRANSFER . $booking["transfer_bukti"]);
        }

        $update                 = $this->booking->where(["uuid" => $booking["uuid"]])->update($dataUpdate);
        if (!$update) {
            echo json_encode([
                "code"      => 503,
                "message"   => "Terjadi kesalahan saat melakukan upload bukti transfer. Silahkan coba lagi"
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Bukti transfer berhasil di upload. Silahkan tunggu konfirmasi dari admin"
        ]);
        die;
    }
}
