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
            "User_model"        => "user"
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
            $jadwal[$i]["image_kendaraan"] = setImage(LOKASI_ARMADA, $jadwal[$i]["image_kendaraan"]);
        }

        echo json_encode([
            "code"      => 200,
            "message"   => $noHari,
            "data"      => $jadwal
        ]);
    }
}
