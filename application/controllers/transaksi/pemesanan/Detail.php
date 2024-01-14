<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail extends RFL_Controller
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
        redirect("transaksi/pemesanan/menunggu");
    }

    public function view($uuid = NULL)
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
            "title"     => "Detail Pemesanan",
            "detail"    => $detail,
        ];
        $this->loadRFLView("transaksi/pemesanan/detail_pemesanan", $data);
    }

    public function terima_tolak($uuid = NULL, $terimaTolak = NULL)
    {
        if (!in_array($terimaTolak, [DIPROSES, DITOLAK])) {
            echo json_encode([
                "code"      => 504,
                "message"   => "Status diproses atau ditolak tidak sesuai dengan format"
            ]);
            die;
        }

        $cek = $this->booking->where(["uuid" => $uuid])->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 504,
                "message"   => "Data pemesanan tidak diketahui"
            ]);
            die;
        }

        $this->booking->where(["uuid" => $uuid])->update(["status" => $terimaTolak]);
        echo json_encode([
            "code"      => 200,
            "message"   => "Data pemesanan berhasil di " . ($terimaTolak === DIPROSES ? "Di proses" : "Di tolak")
        ]);
    }
}
