<?php use_helper('I18N') ?>
<?php slot('rt-title') ?>
<?php echo __('Account Details') ?>
<?php end_slot(); ?>
<?php include_component('rtSnippet','snippetPanel', array('collection' => 'rt-guard-user-edit-prefix','sf_cache_key' => 'rt-guard-user-edit-prefix', 'default' => '')); ?>
<?php include_partial('form', array('form' => $form)) ?>