<?php use_helper('I18N') ?>
<h1><?php echo __('Access Denied!', null, 'sf_guard') ?></h1>
<?php if($sf_user->isAuthenticated()): ?>
<p><?php echo __('Oops! The page you asked for is secure and you don\'t have the required credentials.') ?></p>
<?php else: ?>
<p><?php echo __('Oops! The page you asked for is secure and you will need to login before accessing it.') ?></p>
<?php include_partial('sirtin_form', array('form' => new sfGuardFormSirtin())) ?>
<?php endif; ?>