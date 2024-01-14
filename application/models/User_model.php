<?php

class User_model extends RFL_Model
{
    public $table                   = 'm_user';
    public $primary_key             = 'uuid';
    public $uuid                    = TRUE;
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();       
    }

    public function fieldForm()
    {
        $gender = [
            ["label" => LAKI_LAKI, "value" => LAKI_LAKI],
            ["label" => PEREMPUAN, "value" => PEREMPUAN],
        ];

        return [
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "username",
                "name_alias"        => "username",
                "label"             => "Username",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "required_edit"     => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "isUnique"          => TRUE
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "nama",
                "name_alias"        => "nama",
                "label"             => "Nama Lengkap",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "required_edit"     => TRUE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
            ],
            [
                "col"               => 6,
                "type"              => "text",
                "name"              => "telp",
                "label"             => "Telepon",
                "numberOnly"        => TRUE,
                "required"          => FALSE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "insertValidation"  => "regex_match[/^(?:0|\+?6)(?:\d(?:-)?){9,15}$/]",
            ],
            [
                "col"               => 6,
                "type"              => "select",
                "name"              => "jenis_kelamin",
                "label"             => "Jenis Kelamin",
                "numberOnly"        => FALSE,
                "required"          => FALSE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "options"       => [
                    "chain"         => FALSE,
                    "to"            => NULL,
                    "serverSide"    => FALSE,
                    "data"          => $gender,
                ],
            ],
            [
                "col"               => 12,
                "type"              => "textarea",
                "name"              => "detail_alamat",
                "name_alias"        => "detail_alamat",
                "label"             => "Detail Alamat",
                "numberOnly"        => FALSE,
                "required"          => FALSE,
                "required_edit"     => FALSE,
                "hideFromTable"     => FALSE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
            ],
            [
                "col"               => 6,
                "type"              => "password",
                "name"              => "password",
                "label"             => "Password",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "required_edit"     => FALSE,
                "hideFromTable"     => TRUE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "saveAsHash"        => TRUE,
                "insertValidation"  => "min_length[6]",
                "note_edit"         => "* Silahkan kosongi kolom ini jika tidak ingin mengubah password"
            ],
            [
                "col"               => 6,
                "type"              => "password",
                "name"              => "confirm_password",
                "label"             => "Konfirmasi Password",
                "numberOnly"        => FALSE,
                "required"          => TRUE,
                "required_edit"     => FALSE,
                "hideFromTable"     => TRUE,
                "hideFromEdit"      => FALSE,
                "hideFromCreate"    => FALSE,
                "hideFromUpdate"    => TRUE,
                "hideFromInsert"    => TRUE,
                "hideFromUpdate"    => TRUE,
                "saveAsHash"        => TRUE,
                "insertValidation"  => "matches[password]",
                "note_edit"         => "* Silahkan kosongi kolom ini jika tidak ingin mengubah password"
            ],
        ];
    }

    public function getCredential($usermame, $password)
    {
        $_user                  = $this->where(["LOWER(username)" => strtolower(trim($usermame))])->get();
        if (!$_user) return FALSE;
        $verify                 = password_verify($password, $_user["password"]);
        if (!$verify) return FALSE;
        return $this->detail($_user[$this->primary_key]);
    }

    public function detail($uuid, $removePassword = TRUE)
    {
        $_user  = $this->where([$this->primary_key => $uuid])->get();

        if (!$_user) return FALSE;
        if ($removePassword) {
            if (isset($_user["password"])) {
                unset($_user["password"]);
            }
        }
        return $_user;
    }
}
