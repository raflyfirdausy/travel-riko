<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "User_model"        => "user",
            "jadwalView_model"  => "vJadwal",
            "Booking_model"     => "booking",
        ]);
    }

    public function index()
    {
        $this->loadView("jadwal");
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
}
