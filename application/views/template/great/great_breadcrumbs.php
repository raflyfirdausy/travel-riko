<?php
$SIZE_BREADCRUMBS = sizeof($DATA_BREADCRUMBS);
?>

<nav>
    <ol class="breadcrumb">
        <?php for ($i = 0; $i < $SIZE_BREADCRUMBS; $i++) : ?>
            <li class="breadcrumb-item <?= ($i == ($SIZE_BREADCRUMBS-1)) ? "active" : "" ?>"><a href="<?= $DATA_BREADCRUMBS[$i]["path"] ?>"><?= $DATA_BREADCRUMBS[$i]["title"] ?></a></li>
        <?php endfor ?>        
    </ol>
</nav>