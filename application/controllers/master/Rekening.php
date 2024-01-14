<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekening extends RFL_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            "Rekening_model"    => "rekening",
        ]);

        $this->module         = "Rekening Pembayaran";
        $this->model          = $this->rekening;
        $this->modelView      = $this->rekening;
        $this->fieldForm      = $this->rekening->fieldForm();
    }
}
