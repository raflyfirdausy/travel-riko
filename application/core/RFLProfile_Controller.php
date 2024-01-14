<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RFLProfile_Controller extends RFL_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "Setting_model"     => "setting"
        ]);
    }

    protected function loadRFLProfileView($view = NULL, $local_data = array(), $asData = FALSE)
    {
        $primaryData = [
            "URL_PROSES_SIMPAN" => "/" . $this->pathUrl . "/proses-simpan/",
            "URL_UPLOAD_IMAGE"  => "/" . $this->pathUrl . "/upload-image/",
            "URL_DELETE_IMAGE"  => "/" . $this->pathUrl . "/delete-image/",
        ];

        $data = array_merge($primaryData, $local_data);
        $this->loadRFLView($view, $data, $asData);
    }

    public function proses_simpan()
    {
        $inputPost = $this->input->post();
        foreach ($inputPost as $key => $value) {
            $cek = $this->setting->where(["key" => $key])->get();
            if ($cek) {
                $this->setting->where(["key" => $cek["key"]])->update(["value" => $value]);
            } else {
                $this->setting->insert(["key" => $key, "value" => $value]);
            }
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Berhasil menyimpan data profile prodi"
        ]);
    }

    public function upload_image()
    {
        $formNameFile           = "image";
        if (!empty($_FILES[$formNameFile]["name"])) {
            $configUpload   = [
                "upload_path"       => LOKASI_PENGATURAN,
                "allowed_types"     => "jpg|jpeg|png",
                "max_size"          => 1024 * 50,    //? 50MB
                "encrypt_name"      => TRUE,
                "remove_space"      => TRUE,
                "overwrite"         => TRUE,
            ];

            if (!file_exists($configUpload['upload_path'])) {
                mkdir($configUpload['upload_path'], 0777, TRUE);
            }

            $this->upload->initialize($configUpload);
            $upload                 = $this->upload->do_upload($formNameFile);
            if (!$upload) {
                echo json_encode([
                    "code"          => 503,
                    "message"       => "Terjadi kesalahan saat mengupload image. Keterangan : " . $this->upload->display_errors("", ""),
                ]);
                die;
            }

            $dataUpload             = $this->upload->data();

            echo json_encode([
                "code"      => 200,
                "message"   => "Berhasil menambahkan gambar",
                "url"       => "/" . LOKASI_PENGATURAN . $dataUpload["file_name"]
            ]);
            die;
        }

        echo json_encode([
            "code"          => 503,
            "message"       => "Terjadi kesalahan saat mengupload image. Keterangan : image tidak ditemukan",
            "url"           => NULL
        ]);
        die;
    }

    public function delete_image()
    {
        $image          = $this->input->post('image');
        $fileNameArray  = explode("/", $image);
        $fileName       = end($fileNameArray);


        if (is_file(LOKASI_PENGATURAN . $fileName)) {
            unlink(LOKASI_PENGATURAN . $fileName);
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "OK",
            "fileName"  => $fileName
        ]);
    }
}
