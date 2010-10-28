<?php use_helper('I18N') ?>
<?php slot('rt-title') ?>
<?php echo __('Register an account', null, 'sf_guard') ?>
<?php end_slot(); ?>
<?php include_component('rtSnippet','snippetPanel', array('collection' => 'rt-guard-register-prefix','sf_cache_key' => 'rt-guard-register-prefix', 'default' => __('Please fill out your details in the form below to create a new account.'))); ?>
<?php echo get_partial('rtGuardRegister/form', array('form' => $form)) ?>