<?php use_helper('I18N', 'rtForm') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php include_partial('rtAdmin/flashes_public') ?>

<div class="rt-container rt-comment">
  <h1><?php echo __('Comments') ?></h1>
  <?php include_component('rtComment', 'form', array('form' => $form)) ?>
</div>
