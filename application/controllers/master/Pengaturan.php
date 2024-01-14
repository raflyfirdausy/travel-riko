<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Setting_model"     => "setting"
        ]);
    }

    public function index()
    {
        $this->loadRFLView("master/pengaturan/data_pengaturan");
    }

    public function proses_simpan()
    {


        $inputPost  = $this->input->post();

        foreach ($inputPost as $key => $value) {
            $cek = $this->setting->where(["key" => $key])->get();
            if ($cek) {
                $this->setting->where(["key" => $cek["key"]])->update(["value" => $value]);
            } else {
                $this->setting->insert(["key" => $key, "value" => $value]);
            }
        }

        if (!empty($_FILES)) {
            foreach ($_FILES as $FILE_KEY => $FILE_VALUE) {
                $this->uploadImage($FILE_KEY);
            }
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil menyimpan data pengaturan"
        ]);
    }

    private function uploadImage($formName)
    {
        if (!empty($_FILES[$formName]["name"])) {
            $configUpload   = [
                "upload_path"       => LOKASI_PENGATURAN,
                "allowed_types"     => "jpg|png|gif|webp|jpeg",
                "max_size"          => 5 * 1024,
                "encrypt_name"      => TRUE,
                "remove_space"      => TRUE,
                "overwrite"         => TRUE,
            ];

            if (!file_exists($configUpload['upload_path'])) {
                mkdir($configUpload['upload_path'], 0777, TRUE);
            }

            $this->upload->initialize($configUpload);
            $upload                 = $this->upload->do_upload($formName);
            if (!$upload) {
                echo json_encode([
                    "code"          => 503,
                    "message"       => "Terjadi kesalahan saat mengupload file. Keterangan : " . $this->upload->display_errors("", ""),
                    "data"          => NULL
                ]);
                die;
            }

            $dataUpload             = $this->upload->data();
            $fileName               = $dataUpload["file_name"];

            $cek = $this->setting->where(["key" => $formName])->get();
            if ($cek) {
                $filePath = LOKASI_PENGATURAN . $cek["value"];
                if (is_file($filePath)) unlink($filePath);
                $this->setting->where(["key" => $cek["key"]])->update(["value" => $fileName]);
            } else {
                $this->setting->insert(["key" => $formName, "value" => $fileName]);
            }
        }
    }
}
