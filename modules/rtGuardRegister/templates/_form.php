<?php use_helper('I18N', 'rtForm') ?>
<form action="<?php echo url_for('@sf_guard_register') ?>" method="post" class="rt-compact">
  <?php echo $form->renderHiddenFields() ?>
  <fieldset>
  <legend><?php echo __('Your registration details') ?></legend>
    <ul class="rt-form-schema">
      <?php echo $form; ?>
    </ul>
  </fieldset>
  <p class="rt-form-tools">
    <button><?php echo __('Register', null, 'sf_guard') ?></button>
     <?php echo __('If you already have an account, you can') ?> <?php echo link_to(__('sign in here', null, 'sf_guard'), '@sf_guard_signin') ?>.
  </p>
</form>