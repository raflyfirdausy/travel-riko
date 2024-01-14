<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "User_model"        => "user"
        ]);
    }

    public function index()
    {
        // $user       = $this->getCurrentUser();

        $data       = [
            "title"         => "Dashboard",
            // "user"          => $user
        ];

        $this->loadRFLView("dashboard/dashboard", $data);
    }

    public function maintenance()
    {
        die("ACCESS DENIED");
        $inputFileType  = 'Csv';
        $inputFileName  = LOKASI_MAINTENANCE . "sample.csv";
        $reader         = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();

        $dataArray  = $worksheet->toArray();
        $data       = [];
        $bahasa     = [];
        $kolomB     = [];
        foreach ($dataArray as $da) {
            $data[] = [
                "uuid_kategori"     => "5b99b9eb-dd53-4a0a-bb4a-8a180cd5f07e",
                "uuid_bahasa"       => $da[9] === "Indonesia" ? "f076ec07-5d80-4280-a5a5-676927bf70aa" : ($da[9] === "English" ? "7539fc07-011d-4992-97f7-9b450ef55088" : NULL),
                "image"             => $da[13],
                "judul"             => $da[0],
                "deskripsi_buku"    => $da[12],
                "deskripsi_fisik"   => $da[6],
                "pengarang"         => $da[14],
                "isbn_issn"         => $da[3],
                "call_number"       => $da[8],
                "penerbit_kota"     => $da[10],
                "penerbit_nama"     => $da[4],
                "penerbit_tahun"    => $da[5],
                "edisi"             => $da[2],
                "is_tabagasi"       => "TIDAK"
            ];

            if (!in_array($da[9], $bahasa)) {
                if (!empty($da[9])) {
                    $bahasa[] = $da[9];
                }
            }

            if (!in_array($da[1], $kolomB)) {
                $kolomB[] = $da[1];
            }
        }

        // d($data);

        $this->load->model(["Buku_model" => "buku"]);
        $this->buku->insert($data);
        d([
            "total"     => sizeof($data),
            "kolomB"    => $kolomB,
            "bahasa"    => $bahasa,
            "data"      => $data
        ]);

        // d($worksheet->toArray());
    }
}
