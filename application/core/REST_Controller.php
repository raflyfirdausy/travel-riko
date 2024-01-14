<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class REST_Controller extends RestController
{
    public function __construct()
    {
        parent::__construct();
        if (empty($_POST)) {
            $inputFromJson = file_get_contents('php://input');
            $_POST = json_decode($inputFromJson, TRUE);
        }
    }

    protected function runValidation($config)
    {
        $this->form_validation->set_rules($config);
        $run    = $this->form_validation->run();
        if (!$run) {
            $error  = $this->form_validation->error_array();
            return $this->response([
                "status"        => true,
                "code"          => REST_Controller::HTTP_BAD_REQUEST,
                "message"       => validationError($error),
                "errors"        => $error
            ], REST_Controller::HTTP_OK);
        }
    }
}
