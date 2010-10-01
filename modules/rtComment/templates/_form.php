<?php use_helper('I18N'); ?>
<?php include_javascripts_for_form($form) ?>
<?php include_stylesheets_for_form($form) ?>
<div class="rt-comment-form">
  <form action="<?php echo url_for('rtComment/create') ?>" method="post">
    <fieldset>
      <legend><?php echo __('Have your say!') ?></legend>
      <input type="hidden" name="id" value="<?php echo sfContext::getInstance()->getRequest()->getParameter('id') ?>" />
      <?php echo $form->renderHiddenFields() ?>
      <ul class="rt-form-schema">
      <?php echo $form; ?>
      </ul>
    </fieldset>
    <p class="rt-button-set"><button type="submit"><?php echo __('Save comment') ?></button></p>
  </form>
</div>