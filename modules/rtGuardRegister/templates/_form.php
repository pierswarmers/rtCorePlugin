<?php use_helper('I18N', 'rtForm') ?>
<form action="<?php echo url_for('@sf_guard_register') ?>" method="post" class="rt-compact">
  <?php echo $form->renderHiddenFields() ?>
  <fieldset>
  <legend><?php echo __('User details') ?></legend>
    <ul class="rt-form-schema">
      <?php echo $form; ?>
    </ul>
  </fieldset>
  <p class="rt-form-tools"><button><?php echo __('Register', null, 'sf_guard') ?></button></p>
</form>