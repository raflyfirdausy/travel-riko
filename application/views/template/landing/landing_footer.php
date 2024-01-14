<footer id="tg-footer" class="tg-footer tg-haslayout">
    <div class="tg-footerarea">
        <div class="container">
            <div class="row">
                <div class="tg-threecolumns">
                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                        <div class="tg-footercol">
                            <strong class="tg-logo"><a href="/"><img style="height: 50px" src="<?= getLogo() ?>" alt="<?= getSetting("JUDUL_WEBSITE") ?>"></a></strong>
                            <ul class="tg-contactinfo">
                                <li>
                                    <i class="icon-apartment"></i>
                                    <address><?= getSetting("ALAMAT") ?></address>
                                </li>
                                <li>
                                    <i class="icon-phone-handset"></i>
                                    <span>
                                        <em><?= getSetting("TELP") ?></em>
                                    </span>
                                </li>
                                <li>
                                    <i class="icon-clock"></i>
                                    <span><?= nl2br(getSetting("JAM_OPERASIONAL")) ?></span>
                                </li>
                                <li>
                                    <i class="icon-envelope"></i>
                                    <span>
                                        <em><a href="mailto:<?= getSetting("EMAIL") ?>"><?= getSetting("EMAIL") ?></a></em>
                                    </span>
                                </li>
                            </ul>
                            <ul class="tg-socialicons">
                                <?php if (getSetting("INSTAGRAM")) : ?>
                                    <li class="tg-instagram"><a target="_blank" style="background: #b3247c" href="<?= getSetting("INSTAGRAM") ?>"><i class="fa fa-instagram"></i></a></li>
                                <?php endif ?>
                                <?php if (getSetting("FACEBOOK")) : ?>
                                    <li class="tg-facebook"><a target="_blank" href="<?= getSetting("FACEBOOK") ?>"><i class="fa fa-facebook"></i></a></li>
                                <?php endif ?>
                                <?php if (getSetting("TWITTER")) : ?>
                                    <li class="tg-twitter"><a target="_blank" href="<?= getSetting("TWITTER") ?>"><i class="fa fa-twitter"></i></a></li>
                                <?php endif ?>
                                <?php if (getSetting("YOUTUBE")) : ?>
                                    <li class="tg-googleplus"><a target="_blank" href="<?= getSetting("YOUTUBE") ?>"><i class="fa fa-youtube"></i></a></li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
                        <?php $MAPS_PERPUSTAKAAN = getSetting("MAPS_PERPUSTAKAAN"); if (!empty($MAPS_PERPUSTAKAAN)) : ?>
                            <?= $MAPS_PERPUSTAKAAN ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tg-footerbar">
        <a id="tg-btnbacktotop" class="tg-btnbacktotop" href="javascript:void(0);"><i class="icon-chevron-up"></i></a>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="tg-copyright"><?= date("Y") ?> All Rights Reserved By &copy; ultranesia</span>
                </div>
            </div>
        </div>
    </div>
</footer>