<?php $session = lava_instance()->session; ?>

<h1>Welcome, <?= $session->userdata('username') ?>!</h1>
<p>Role: <?= $session->userdata('role') ?></p>

<a href="<?= site_url('auth/logout') ?>">Logout</a>