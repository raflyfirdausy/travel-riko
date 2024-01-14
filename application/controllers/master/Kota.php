<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kota extends RFL_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            "Kota_model"    => "kota",
        ]);

        $this->module         = "Kota";
        $this->model          = $this->kota;
        $this->modelView      = $this->kota;
        $this->fieldForm      = $this->kota->fieldForm();        
    }
}
