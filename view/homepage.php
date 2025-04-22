<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<h1>User Profile</h1>
<?php foreach ($posts as $post): ?>
    <h2><?= $this->e($post['title']) ?></h2>
    <?php endforeach; ?>