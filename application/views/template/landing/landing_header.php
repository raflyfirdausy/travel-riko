<header id="tg-header" class="tg-header tg-headervtwo tg-haslayout">
    <div class="tg-topbar">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="tg-addnav">
                        <?php
                        $JUDUL_WEBSITE = getSetting("JUDUL_WEBSITE");
                        if ($JUDUL_WEBSITE) : ?>
                            <li>
                                <a href="/">
                                    <em><?= $JUDUL_WEBSITE ?></em>
                                </a>
                            </li>
                        <?php endif ?>

                        <?php $NPP = getSetting("NPP");
                        if ($NPP) : ?>
                            <li>
                                <a href="/">
                                    <em>NPP : <?= $NPP ?></em>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                    <div class="tg-userlogin">
                        <a href="/auth">
                            <span style="font-weight: 800;">Masuk Pustakawan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tg-middlecontainer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <strong class="tg-logo">
                        <a href="/">
                            <img style="height: 50px" src="<?= getLogo() ?>" alt="<?= getSetting("JUDUL_WEBSITE") ?>">
                        </a>
                    </strong>
                    <div class="tg-searchbox" style="margin-top: 10px;">
                        <form method="GET" class="tg-formtheme tg-formsearch" action="<?= $this->router->uri->uri_string == "e-book" ? "/e-book" : "/buku" ?>">
                            <fieldset style="padding: 0 150px;">
                                <input style="width: 500px;" type="text" name="search" value="<?= $this->input->get("search") ?>" class="typeahead form-control" placeholder="Cari buku berdasarkan judul, pengarang, kata kunci, ISBN...">
                                <button type="submit" class="tg-btn">Cari</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tg-navigationarea">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="tg-navigationholder">
                        <nav id="tg-nav" class="tg-nav">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div id="tg-navigation" class="collapse navbar-collapse tg-navigation">
                                <ul>
                                    <!-- <li class="current-menu-item"> -->
                                    <li>
                                        <a href="/">Beranda</a>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="javascript:void(0);">Profil</a>
                                        <ul class="sub-menu">
                                            <li><a href="/sejarah-perpustakaan">Sejarah Perpustakaan</a></li>
                                            <li><a href="/profil-perpustakaan">Profil Perpustakaan</a></li>
                                            <li><a href="/struktur-organisasi">Struktur Organisasi</a></li>
                                            <li><a href="/visi-misi">Visi Misi Perpustakaan</a></li>
                                            <li><a href="/pustakawan">Pustakawan</a></li>
                                            <li><a href="/denah-perpustakaan">Denah Perpustakaan</a></li>
                                            <li><a href="/mitra-kerja-sama">Mitra Kerja Sama</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="javascript:void(0);">Koleksi Buku</a>
                                        <ul class="sub-menu">
                                            <li><a href="/buku">Buku Fisik</a></li>
                                            <li><a href="/e-book">E-book</a></li>
                                            <li><a href="/buku-pilihan"><?= getSetting("BUKU_PILIHAN_NAMA", "Buku Pilihan") ?></a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/berita">Berita Perpustakaan</a></li>
                                    <li><a href="/fasilitas">Fasilitas Perpustakaan</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>