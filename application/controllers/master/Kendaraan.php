<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kendaraan extends RFL_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            "Armada_model"    => "armada",
        ]);

        $this->module         = "Kendaraan";
        $this->model          = $this->armada;
        $this->modelView      = $this->armada;
        $this->fieldForm      = $this->armada->fieldForm();
    }
}
