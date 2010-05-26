<?php use_helper('I18N') ?>
<h1><?php echo __('Sirtin', null, 'sf_guard') ?></h1>
<?php include_partial('rtGuardAuth/flashes')?>
<?php echo get_partial('rtGuardAuth/signin_form', array('form' => $form)) ?>