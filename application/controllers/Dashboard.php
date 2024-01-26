<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "User_model"        => "user",
            "Armada_model"      => "armada",
            "Booking_model"     => "booking",
            "Kota_model"        => "kota",
            "Rekening_model"    => "rekening",
        ]);
    }

    public function index()
    {
        $user       = $this->user->where(["role" => USER])->count_rows();
        $kota       = $this->kota->count_rows();
        $rekening   = $this->rekening->count_rows();
        $armada     = $this->armada->count_rows();


        $menunggu   = $this->booking->where(["status" => MENUNGGU])->count_rows();
        $diproses   = $this->booking->where(["status" => DIPROSES])->count_rows();
        $ditolak    = $this->booking->where(["status" => DITOLAK])->count_rows();


        $data       = [
            "title"         => "Dashboard",

            "total"         => [
                "user"          => $user,
                "kota"          => $kota,
                "rekening"      => $rekening,
                "kendaraan"     => $armada,

                "menunggu"      => $menunggu,
                "diproses"      => $diproses,
                "ditolak"       => $ditolak
            ]
            // "user"          => $user
        ];

        if($this->session->userdata(SESSION)["role"] === USER){
            redirect(base_url("transaksi/pemesanan/tambah"));
        }

        $this->loadRFLView("dashboard/dashboard", $data);
    }
}
