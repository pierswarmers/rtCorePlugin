<?php use_helper('I18N') ?>
<h1><?php echo __('Oops! The page you asked for is secure and you do not have proper credentials.', null, 'sf_guard') ?></h1>
<p><?php echo sfContext::getInstance()->getRequest()->getUri() ?></p>
<?php include_partial('gnGuardAuth/flashes')?>
<h2><?php echo __('Login below to gain access', null, 'sf_guard') ?></h2>
<?php echo get_component('sfGuardAuth', 'signin_form') ?>