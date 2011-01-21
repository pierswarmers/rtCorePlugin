<?php $keys = $sf_data->getRaw('keys') ?>
<?php $values = $sf_data->getRaw('values') ?>
<?php echo implode(', ',$keys) . "\r\n"; ?>
<?php foreach($values as $value): ?>
<?php if(count($keys) == count($value)): ?>
<?php echo implode(', ',$value) . "\r\n"; ?>
<?php endif; ?>
<?php endforeach; ?>