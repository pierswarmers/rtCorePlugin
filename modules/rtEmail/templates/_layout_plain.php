<?php use_helper('I18N') ?>
<?php echo isset($content) ? $content : '' ?>


<?php if (sfConfig::has('app_rt_email_signature_plain')): ?>
--

<?php echo sfConfig::get('app_rt_email_signature_plain', '') ?>
<?php endif; ?>