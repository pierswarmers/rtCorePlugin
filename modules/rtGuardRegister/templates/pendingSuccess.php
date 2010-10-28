<?php use_helper('I18N') ?>
<?php slot('rt-title') ?>
<?php echo __('Registration Pending') ?>
<?php end_slot(); ?>
<?php include_component('rtSnippet','snippetPanel', array('collection' => 'rt-guard-register-pending-prefix','sf_cache_key' => 'rt-guard-register-pending-prefix', 'default' => __('You have successfully registered and your account is pending activation. An email will be sent when the account has been activated.'))); ?>