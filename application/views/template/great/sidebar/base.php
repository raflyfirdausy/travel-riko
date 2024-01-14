<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <?php foreach ($menuList as $list) : ?>
            <li class="nav-heading"><?= $list["title"] ?></li>
            <?php $this->menu->generateChild($list["child"]) ?>
        <?php endforeach ?>
    </ul>
</aside>