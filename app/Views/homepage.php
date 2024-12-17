<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div>
    <?php for($i = 0; $i < 100; $i++) : ?>
    <h1>Homepage</h1>
    <?php endfor ?>
</div>

<?= $this->endSection() ?>
