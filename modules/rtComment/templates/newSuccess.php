<?php use_helper('I18N', 'rtForm') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php include_partial('rtAdmin/flashes_public') ?>

<div class="rt-container short">

  <div class="rt-collection">
    <h3><?php echo __('Comments') ?></h3>
    <?php include_component('rtComment', 'comments', array()) ?>
  </div>
</div>
