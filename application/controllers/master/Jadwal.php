<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends RFL_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            "Jadwal_model"      => "jadwal",
            "jadwalView_model"  => "vJadwal"
        ]);

        $this->module         = "Jadwal Travel";
        $this->model          = $this->jadwal;
        $this->modelView      = $this->vJadwal;
        $this->fieldForm      = $this->jadwal->fieldForm();        
    }
}
