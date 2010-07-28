<?php use_helper('I18N') ?>
<?php if (sfConfig::has('email_signature')): ?>
<p><?php echo sfConfig::get('email_signature', '') ?></p>
<?php endif; ?>