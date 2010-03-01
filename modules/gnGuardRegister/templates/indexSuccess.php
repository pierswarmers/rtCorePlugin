<?php use_helper('I18N') ?>
<h1><?php echo __('Register', null, 'sf_guard') ?></h1>
<?php include_partial('gnGuardAuth/flashes')?>
<?php echo get_partial('gnGuardRegister/form', array('form' => $form)) ?>