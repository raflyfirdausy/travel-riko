<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends RFL_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            "User_model"            => "user",
        ]);

        $this->module                   = "Akun User";
        $this->model                    = $this->user;
        $this->modelView                = $this->user;
        $this->fieldForm                = $this->user->fieldForm();
        $this->enableExportImportButton = FALSE;
        $this->kondisiGetData           = ["role" => USER];
        $this->additionalDataCreate     = ["role" => USER];
    }
}
