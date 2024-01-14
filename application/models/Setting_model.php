<?php

class Setting_model extends RFL_Model
{
    public $table                   = 'm_setting';
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
