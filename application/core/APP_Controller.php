<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class APP_Controller extends MY_Controller
{
    public $ROLE;
    public function __construct()
    {
        parent::__construct();
        //TODO : INI DISINI LEBIH BAIK DI KASIH VALIDASI SUDAH LOGIN APA BELUM GITU GITU
        if (!$this->session->has_userdata(SESSION)) {
            redirect(base_url("auth"));
        }

        $this->ROLE = $this->session->userdata(SESSION)["role"];

        $params  = ["role"  => $this->ROLE];
        $this->load->library("Menu", $params);
        // d($this->menu->getChild($this->menu->_getMenuList()));

        $this->client = new GuzzleHttp\Client(["base_uri"  => base_api()]);
        $this->header = ['auth' => [env("AUTH_KEY"), env("AUTH_PASS")]];
    }

    protected function loadViewBack($view = NULL, $local_data = array(), $asData = FALSE)
    {
        if (!file_exists(APPPATH . "views/$view" . ".php")) {
            show_404();
        }

        $data               = array_merge($this->global_data, $local_data);

        $this->loadView("template/great/great_top", $data, $asData);
        $this->loadView($view, $data, $asData);
        $this->loadView("template/great/great_bottom", $data, $asData);
    }

    protected function getCurrentUser()
    {
        $this->load->model(["User_model" => "user"]);
        $uuidUser   = $this->session->userdata(SESSION)["uuid"];
        $user       = $this->user->detail($uuidUser, FALSE);
        return $user;
    }

    protected function runValidation($config)
    {
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
    }
}
