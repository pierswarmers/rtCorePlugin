<?php use_helper('I18N', 'rtForm') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php slot('rt-title') ?>
<?php echo __('Comments') ?>
<?php end_slot(); ?>
<?php include_component('rtComment', 'form', array('form' => $form)) ?>
