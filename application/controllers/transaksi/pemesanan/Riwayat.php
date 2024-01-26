<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends RFL_Controller
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

        $this->module                       = "Riwayat Pemesanan";
        $this->model                        = $this->booking;
        $this->modelView                    = $this->booking;
        $this->fieldForm                    = $this->booking->fieldFormSemua();
        $this->enableAddButton              = FALSE;
        $this->enableExportImportButton     = FALSE;
        $this->kondisiGetData               = ["uuid_pemesan" => $this->session->userdata(SESSION)["uuid"]];
    }

    public function index()
    {
        $data       = [
            "FIELD_FORM"    => $this->fieldForm,
            "title"         => $this->module
        ];

        $this->loadRFLView("transaksi/pemesanan/data_riwayat", $data);
    }
}
