<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Editing Comment') ?></h1>

<?php include_partial('form', array('form' => $form, 'parent_model' => isset($parent_model) ? $parent_model : '')) ?>