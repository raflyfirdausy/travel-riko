<div class="pagetitle">
    <h1><?= isset($page_title) ? $page_title : (isset($title) ? ucwords(strtolower($title)) : "")  ?></h1>
    <?php $this->menu->generateBreadcrumbs() ?>
</div>