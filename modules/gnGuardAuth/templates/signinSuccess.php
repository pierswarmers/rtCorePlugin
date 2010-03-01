<?php use_helper('I18N') ?>
<h1><?php echo __('Signin', null, 'sf_guard') ?></h1>
<?php include_partial('gnGuardAuth/flashes')?>
<?php echo get_partial('gnGuardAuth/signin_form', array('form' => $form)) ?>