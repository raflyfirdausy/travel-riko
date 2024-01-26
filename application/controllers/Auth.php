<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            "User_model"    => "user"
        ]);
    }

    public function index()
    {
        redirect(base_url("auth/login"));
    }

    public function login()
    {
        if ($this->session->has_userdata(SESSION)) {
            redirect(base_url("dashboard"));
        }
        $this->loadView('auth/login');
    }

    public function register()
    {
        if ($this->session->has_userdata(SESSION)) {
            redirect("/dashboard");
        }

        $this->loadView('auth/register');
    }

    public function register_proses()
    {
        $nama_lengkap           = trim($this->input->post("nama_lengkap"));
        $telp                   = trim($this->input->post("telp"));
        $jenis_kelamin          = trim($this->input->post("jenis_kelamin"));
        $username               = trim($this->input->post("username"));

        $password               = $this->input->post("password");

        $config                  = [
            [
                "field" => "nama_lengkap",
                "label" => "Nama Lengkap",
                "rules" => "required"
            ],
            [
                "field" => "jenis_kelamin",
                "label" => "Jenis Kelamin",
                "rules" => "required"
            ],
            [
                "field" => "telp",
                "label" => "No Telp",
                "rules" => "required"
            ],
            [
                "field" => "username",
                "label" => "Username",
                "rules" => "required"
            ],
            [
                "field" => "password",
                "label" => "Password",
                "rules" => "required|min_length[8]"
            ],
            [
                "field" => "konfirmasi_password",
                "label" => "Konfirmasi Password",
                "rules" => "required|matches[password]"
            ],
        ];

        $this->form_validation->set_rules($config);
        $run    = $this->form_validation->run();
        if (!$run) {
            $error  = $this->form_validation->error_array();
            echo json_encode([
                "code"          => 403,
                "message"       => validationError($error),
                "errors"        => $error
            ]);
            die;
        }

        $cekUsername   = $this->user->where(["username" => $username])->get();
        if ($cekUsername) {
            echo json_encode([
                "code"          => 403,
                "message"       => "Username sudah terdaftar, silahkan gunakan yang lain",
            ]);
            die;
        }

        $dataInsert = [
            "username"          => $username,
            "role"              => USER,
            "password"          => password_hash($password, PASSWORD_DEFAULT),
            "nama"              => $nama_lengkap,
            "jenis_kelamin"     => $jenis_kelamin,
            "telp"              => $telp,
        ];

        $insert = $this->user->insert($dataInsert);
        if (!$insert) {
            echo json_encode([
                "code"          => 403,
                "message"       => "Terjadi kesalahan saat membuat akun. Silahkan coba lagi. Kode : A001",
            ]);
            die;
        }

        echo json_encode([
            "code"          => 200,
            "message"       => "Pendaftaran berhasil dilakukan. Silahkan masuk menggunakan akun yang telah dibuat",
        ]);
        die;
    }

    public function login_proses()
    {

        $username       = $this->input->post("username");
        $password       = $this->input->post("password");

        $userCredential = $this->user->getCredential($username, $password);
        if ($userCredential) {
            $this->session->set_userdata(SESSION, $userCredential);
            $this->session->set_userdata("userId", $userCredential["uuid"]);
            redirect(base_url("dashboard"));
        } else {
            $this->session->set_flashdata("gagal", "Username atau password tidak sesuai! ");
            redirect(base_url("auth/login"));
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
