<?php use_helper('I18N') ?>
<h1><?php echo __('Register', null, 'sf_guard') ?></h1>
<div class="rt-container">
<?php include_partial('rtAdmin/flashes_public')?>
<?php echo get_partial('rtGuardRegister/form', array('form' => $form)) ?>
</div>