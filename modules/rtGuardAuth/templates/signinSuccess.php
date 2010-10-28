<?php use_helper('I18N') ?>
<?php slot('rt-title') ?>
<?php echo __('Sign in', null, 'sf_guard') ?>
<?php end_slot(); ?>
<?php include_component('rtSnippet','snippetPanel', array('collection' => 'rt-guard-auth-prefix','sf_cache_key' => 'rt-guard-auth-prefix', 'default' => '')); ?>
<?php echo get_partial('rtGuardAuth/signin_form', array('form' => $form)) ?>