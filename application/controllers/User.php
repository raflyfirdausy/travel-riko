<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends RFL_Controller
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
        redirect("/dashboard");
    }

    public function ganti_password()
    {
        $data       = [
            "title"     => "Ganti password"
        ];

        $this->loadRFLView("user/ganti_password", $data);
    }

    public function update_password()
    {
        $config = [
            [
                'field' => 'password_lama',
                'label' => 'Password lama',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'password_baru',
                'label' => 'Password baru',
                'rules' => 'trim|required|min_length[8]',
            ],
            [
                'field' => 'konfirmasi_password',
                'label' => 'Konfirmasi password',
                'rules' => 'trim|required|matches[password_baru]',
            ],
        ];

        $this->runValidation($config);

        $_user                  = $this->getCurrentUser();
        $password_lama          = $this->input->post("password_lama");
        $password_baru          = $this->input->post("password_baru");

        $verify                 = password_verify($password_lama, $_user["password"]);
        if (!$verify) {
            echo json_encode([
                "code"          => 403,
                "message"       => "Maaf password lama yang kamu masukan salah. Silahkan coba lagi",
                "data"          => NULL
            ]);
            die;
        }

        $passwordHash           = password_hash($password_baru, PASSWORD_DEFAULT);
        $updatePassword         = $this->user->where(["uuid" => $_user["uuid"]])->update(["password" => $passwordHash]);
        if (!$updatePassword) {
            echo json_encode([
                "code"          => 403,
                "message"       => "Terjadi kesalahan saat melakukan perubahan password. Silahkan coba lagi. (Kode: R002)",
                "data"          => NULL
            ]);
            die;
        }

        echo json_encode([
            "code"          => 200,
            "message"       => "Password berhasil diubah",
            "errors"        => NULL
        ]);
        die;
    }
}
