<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();
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

    public function login_proses()
    {
        $this->load->model([
            "User_model"    => "user"
        ]);

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
