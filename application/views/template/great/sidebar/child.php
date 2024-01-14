<?php foreach ($menuList as $list) : ?>
    <?php
    $hasChild   = !empty($list["child"]);
    $href       = $hasChild ? "#" : base_url($list["path"]);
    $idList     = preg_replace("/[^A-Za-z0-9]/", '', $list["title"]);
    $idList     = strtolower($idList) . $iteration;
    $currentUri = strtok($_SERVER["REQUEST_URI"], '?');
    $isActive   = $list["path"] == $currentUri;
    ?>

    <li class="nav-item">
        <a class="nav-link collapsed" href="<?= $href ?>" <?= $hasChild ? "data-bs-target='#$idList' data-bs-toggle='collapse'" : "" ?>>
            <?php if (isset($list["icon"]) && !empty($list["icon"])) : ?>
                <i class="<?= $list["icon"] ?>"></i>
            <?php endif ?>
            <span><?= $list["title"] ?></span>

            <?php if ($hasChild) : ?>
                <?php if (isset($list["badge"]) && !empty($list["badge"])) : ?>
                    <span style="right: 1rem;position:absolute;margin-right: 2rem" class="badge bg-<?= $list["badge"]["color"] ?>"><?= $list["badge"]["text"] ?></span>
                <?php endif ?>
                <i class="bi bi-chevron-down ms-auto"></i>
            <?php else : ?>
                <?php if (isset($list["badge"]) && !empty($list["badge"])) : ?>
                    <span style="right: 1rem;position:absolute;" class="badge bg-<?= $list["badge"]["color"] ?>"><?= $list["badge"]["text"] ?></span>
                <?php endif ?>
            <?php endif ?>

        </a>
        <?php if ($hasChild) : ?>
            <ul id="<?= $idList ?>" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <?php $this->menu->generateChild($list["child"], ($iteration + 1)) ?>
            </ul>
        <?php endif ?>
    </li>

<?php endforeach ?>