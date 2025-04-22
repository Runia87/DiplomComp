<?php
use function Tamtamchik\SimpleFlash\flash;
?>
<?php $this->layout('layout', ['title' => 'User Profile']) ?>
<?= flash()->display(); ?>
<h1>About page</h1>
<!--p><!-?=$this->e($title)?></!--p>