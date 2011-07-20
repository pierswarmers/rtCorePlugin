<?php use_helper('I18N', 'rtForm') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('rt-title') ?>
<?php echo __('Contact Us') ?>
<?php end_slot(); ?>

<?php include_component('rtSnippet','snippetPanel', array('collection' => 'rt-contact-prefix','sf_cache_key' => 'rt-contact-prefix', 'default' => __('Please fill out your enquiry details in the form below.'))); ?>
<form action="<?php echo url_for('rt_contact') ?>" method="post" class="rt-compact">
  <?php echo $form->renderHiddenFields() ?>
  <fieldset>
  <legend><?php echo __('Your Details') ?></legend>
    <ul class="rt-form-schema">
      <?php echo $form; ?>
    </ul>
  </fieldset>
  <p class="rt-form-tools"><button type="submit"><?php echo __('Submit Details') ?></button></p>
</form>