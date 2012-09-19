<?php use_helper('I18N') ?>
<?php foreach($values as $key => $value): ?>
<?php if($key !== 'captcha' && $key !== 'special_name'): ?>
<strong><?php echo ucfirst($key) ?>:</strong> <?php echo nl2br($value) ?><br />
<?php endif; ?>
<?php endforeach; ?>