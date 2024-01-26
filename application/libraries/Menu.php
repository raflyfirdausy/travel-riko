<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu
{
    private $CI;
    private $ROLE;

    public function __construct($params = [])
    {
        $this->CI   = &get_instance();
        $this->ROLE = $params["role"];
    }

    public function generateChild($parent, $iteration = 1)
    {
        $data = ["menuList"  => $parent, "iteration" => $iteration];
        $this->CI->load->view("template/great/sidebar/child", $data);
    }

    public function generateBreadcrumbs()
    {
        $path       = "/" . $this->CI->uri->uri_string();
        $path       = str_replace("_", "-", $path);

        $menuList   = $this->_getMenuList();

        $posisiKetemu = NULL;

        $iterasiSection = 0;
        foreach ($menuList as $menu) {
            if (!empty($menu["child"])) {
                $iterasiMenu    = 0;
                $posisiKetemu = NULL;
                foreach ($menu["child"] as $child) {
                    if (str_replace("_", "-", $child["path"]) == $path) {
                        $posisiKetemu = "MENU";
                        break 2;
                    }

                    $posisiKetemu = NULL;
                    if (!empty($child["child"])) {
                        $iterasiSubMenu = 0;
                        foreach ($child["child"] as $c) {
                            if (str_replace("_", "-", $c["path"]) == $path) {
                                $posisiKetemu = "SUB_MENU";
                                break 3;
                            }
                            $iterasiSubMenu++;
                        }
                    }
                    $iterasiMenu++;
                }
            }

            $iterasiSection++;
        }

        $iSection   = 0;
        $iMenu      = 0;
        $iSubMenu   = 0;

        $dataBreadCrumbs = [];
        if (isset($iterasiSection)) {
            $iSection = $iterasiSection;
            if (isset($menuList[$iterasiSection]["title"])) {
                $dataBreadCrumbs[] = [
                    "path"  => base_url("/"),
                    "title" => $menuList[$iterasiSection]["title"]
                ];
            }
        }

        if (isset($iterasiMenu)) {
            $iMenu  = $iterasiMenu;
            if (isset($menuList[$iSection]["child"][$iMenu]["title"]) && isset($menuList[$iSection]["child"][$iMenu]["path"])) {
                $dataBreadCrumbs[] = [
                    "path"  => base_url($menuList[$iSection]["child"][$iMenu]["path"]),
                    "title" => $menuList[$iSection]["child"][$iMenu]["title"]
                ];
            }
        }

        if (isset($iterasiSubMenu)) {
            $iSubMenu = $iterasiSubMenu;
            if ($posisiKetemu !== NULL && $posisiKetemu == "SUB_MENU") {
                if (isset($menuList[$iSection]["child"][$iMenu]["child"][$iSubMenu]["path"]) && isset($menuList[$iSection]["child"][$iMenu]["child"][$iSubMenu]["title"])) {
                    $dataBreadCrumbs[] = [
                        "path"  => base_url($menuList[$iSection]["child"][$iMenu]["child"][$iSubMenu]["path"]),
                        "title" => $menuList[$iSection]["child"][$iMenu]["child"][$iSubMenu]["title"]
                    ];
                }
            }
        }

        return $this->CI->load->view("template/great/great_breadcrumbs", ["DATA_BREADCRUMBS" => $dataBreadCrumbs]);
    }

    public function generate()
    {
        $resultMenuList = $this->getChild($this->_getMenuList());
        for ($i = 0; $i < sizeof($resultMenuList); $i++) {
            if (empty($resultMenuList[$i]["child"])) {
                unset($resultMenuList[$i]);
            }
        }

        $data = [
            "menuList"  => $resultMenuList
        ];
        return $this->CI->load->view("template/great/sidebar/base", $data);
    }

    public function getChild($menuList)
    {
        $resultMenuList    = [];
        foreach ($menuList as $mList) {
            if (isset($mList["roles"])) {
                if (in_array("*", $mList["roles"]) || in_array($this->ROLE, $mList["roles"])) {
                    $child = [];
                    if (isset($mList["child"]) && !empty($mList["child"])) {
                        $child = $mList["child"];
                        unset($mList["child"]);
                        $mList["child"] = $this->getChild($child);
                    }
                    array_push($resultMenuList, $mList);
                }
            }
        }
        return $resultMenuList;
    }

    private function _menuBerandaList()
    {
        return [
            "title"         => "Beranda",
            "roles"         => ["*"],
            "child"         => [
                [
                    "title"     => "Dashboard",
                    "path"      => "/dashboard",
                    "icon"      => "nav-icon fas fa-house-user",
                    "roles"     => ["*"],
                    "child"     => [],
                ],
                [
                    "title"     => "Pengaturan",
                    "path"      => "/master/pengaturan",
                    "icon"      => "nav-icon fas fa-cog",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [],
                ],
            ],
        ];
    }

    private function _menuMasterList()
    {
        return [
            "title"         => "Master Data",
            "roles"         => [SUPER_ADMIN, ADMIN],
            "child"         => [
                [
                    "title"     => "Data Pengguna",
                    "path"      => "#",
                    "icon"      => "nav-icon fas fa-users",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [
                        [
                            "title"     => "Akun Admin",
                            "path"      => "/master/pengguna/admin",
                            "icon"      => "nav-icon fas fa-user-tag",
                            "roles"     => [SUPER_ADMIN, ADMIN],
                            "child"     => [],
                        ],
                        [
                            "title"     => "Akun User",
                            "path"      => "/master/pengguna/user",
                            "icon"      => "nav-icon fas fa-user-check",
                            "roles"     => [SUPER_ADMIN, ADMIN],
                            "child"     => [SUPER_ADMIN],
                        ],
                    ],
                ],
                [
                    "title"     => "Rekening Pembayaran",
                    "path"      => "/master/rekening",
                    "icon"      => "nav-icon fas fa-money-check-alt",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [],
                ],
                [
                    "title"     => "Kota",
                    "path"      => "/master/kota",
                    "icon"      => "nav-icon fas fa-city",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [],
                ],
                [
                    "title"     => "Kendaraan",
                    "path"      => "/master/kendaraan",
                    "icon"      => "nav-icon fas fa-car",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [],
                ],                
                [
                    "title"     => "Jadwal",
                    "path"      => "/master/jadwal",
                    "icon"      => "nav-icon fas fa-calendar-alt",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [],
                ],
            ],
        ];
    }

    private function _menuPemesananTravel()
    {
        return [
            "title"         => "Pemesanan Travel",
            "roles"         => [SUPER_ADMIN, ADMIN, USER],
            "child"         => [
                [
                    "title"     => "Tambah Pemesanan",
                    "path"      => "/transaksi/pemesanan/tambah",
                    "icon"      => "nav-icon fas fa-plus",
                    "roles"     => [SUPER_ADMIN, ADMIN, USER],
                    "child"     => [],
                ],
                [
                    "title"     => "Pemesanan Menunggu",
                    "path"      => "/transaksi/pemesanan/menunggu",
                    "icon"      => "nav-icon fas fa-hourglass-half",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [],
                ],
                [
                    "title"     => "Pemesanan Diproses",
                    "path"      => "/transaksi/pemesanan/proses",
                    "icon"      => "nav-icon fas fa-check",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [],
                ],
                [
                    "title"     => "Pemesanan Ditolak",
                    "path"      => "/transaksi/pemesanan/tolak",
                    "icon"      => "nav-icon fas fa-times",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [],
                ],
                [
                    "title"     => "Semua Pemesanan",
                    "path"      => "/transaksi/pemesanan/semua",
                    "icon"      => "nav-icon fas fa-list-ul",
                    "roles"     => [SUPER_ADMIN, ADMIN],
                    "child"     => [],
                ],
                [
                    "title"     => "Riwayat Pemesanan",
                    "path"      => "/transaksi/pemesanan/riwayat",
                    "icon"      => "nav-icon fas fa-list-ul",
                    "roles"     => [USER],
                    "child"     => [],
                ],
            ],
        ];
    }

    public function _getMenuList()
    {
        $listMenuPush       = [
            $this->_menuBerandaList(),
            $this->_menuMasterList(),
            $this->_menuPemesananTravel(),
        ];

        $resultMenuDrawer   = [];
        foreach ($listMenuPush as $list) {
            array_push($resultMenuDrawer, $list);
        }
        return $resultMenuDrawer;
    }
}
