<?php use_helper('I18N') ?>
<?php if (sfConfig::has('app_rt_email_signature_html')): ?>
<p><?php echo sfConfig::get('app_rt_email_signature_html', '') ?></p>
<?php endif; ?>