<?php use_helper('I18N') ?>
<?php slot('rt-title') ?>
<?php echo __('Registration Confirmed') ?>
<?php end_slot(); ?>
<?php include_component('rtSnippet','snippetPanel', array('collection' => 'rt-guard-register-confirm-prefix','sf_cache_key' => 'rt-guard-register-confirm-prefix', 'default' => __('The user "%1%" has been activated and an email has been sent to notify them of this.', array('%1%' => $user->getName())))); ?>
