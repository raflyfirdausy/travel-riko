<?php

class JadwalView_model extends RFL_Model
{
    public $table                   = 'v_jadwal';
    public $primary_key             = 'uuid';
    public $return_as               = "array";
    public $uuid                    = TRUE;
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;

    public function __construct()
    {
        parent::__construct();       
    }
}
