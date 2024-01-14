<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Landing_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function loadLandingView($view = NULL, $local_data = array(), $asData = FALSE)
    {
        if (!file_exists(APPPATH . "views/$view" . ".php")) {
            show_404();
        }

        $data               = array_merge($this->global_data, $local_data);

        $this->loadView("template/landing/landing_top", $data, $asData);
        $this->loadView($view, $data, $asData);
        $this->loadView("template/landing/landing_bottom", $data, $asData);
    }
}
