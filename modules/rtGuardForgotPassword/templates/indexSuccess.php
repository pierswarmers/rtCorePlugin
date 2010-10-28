<?php use_helper('I18N', 'rtForm') ?>
<?php slot('rt-title') ?>
<?php echo __('Forgot your password?', null, 'sf_guard') ?>
<?php end_slot(); ?>
<?php include_component('rtSnippet','snippetPanel', array('collection' => 'rt-guard-forgot-password-prefix','sf_cache_key' => 'rt-guard-forgot-password-prefix', 'default' => 'Do not worry, we can help you get back in to your account safely! Fill out the form below to request an e-mail with information on how to reset your password.')); ?>
<form action="<?php echo url_for('@sf_guard_forgot_password') ?>" method="post">
  <?php echo $form->renderHiddenFields() ?>
  <fieldset>
  <legend><?php echo __('Reset your password') ?></legend>
    <ul class="rt-form-schema">
      <li class="rt-form-row"><?php echo $form['email_address']->renderLabel() ?><div class="rt-form-field"><?php echo $form['email_address'] ?></div></li>
    </ul>
  </fieldset>
  <p class="rt-form-tools">
    <button><?php echo __('Reset password', null, 'sf_guard') ?></button>
     <?php echo __('If you already know your password, you can') ?> <?php echo link_to(__('sign in here', null, 'sf_guard'), '@sf_guard_signin') ?>.
  </p>
</form>