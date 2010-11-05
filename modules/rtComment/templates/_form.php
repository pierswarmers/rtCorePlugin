<?php use_helper('I18N'); ?>
<?php include_javascripts_for_form($form) ?>
<?php include_stylesheets_for_form($form) ?>
<?php if(sfConfig::get('app_rt_comment_active', true)): ?>
<div class="rt-comment-form">
  <form action="<?php echo url_for('rtComment/create') ?>" method="post">
    <fieldset>
      <legend><?php echo __('Have your say!') ?></legend>
      <?php echo $form->renderHiddenFields() ?>
      <ul class="rt-form-schema">
        <?php echo $form; ?>
      </ul>
    </fieldset>
    <p class="rt-form-tools"><button><?php echo __('Save comment') ?></button></p>
  </form>
</div>
<?php endif; ?>