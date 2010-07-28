<?php $users = $sf_data->getRaw('users') ?>
<?php $keys = $sf_data->getRaw('key_order') ?>
<?php echo implode(', ',$keys) . "\r\n"; ?>
<?php foreach($users as $user): ?>
<?php echo implode(', ',$user) . "\r\n"; ?>
<?php endforeach; ?>