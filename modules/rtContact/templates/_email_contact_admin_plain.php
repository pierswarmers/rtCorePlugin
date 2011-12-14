<?php use_helper('I18N') ?>
<?php foreach($values as $key => $value): ?>
<?php if($key !== 'captcha'): ?>
<?php echo ucfirst($key) ?>: <?php echo nl2br($value) ?>

<?php endif; ?>
<?php endforeach; ?>