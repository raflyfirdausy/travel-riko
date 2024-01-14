<?php

class MY_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function where_between($field, $min, $max)
    {
        $this->_database->where("$field BETWEEN '$min' AND '$max'");
        return $this;
    }
}
