<?php use_helper('I18N', 'rtForm') ?>
<?php slot('rt-title') ?>
<?php echo __('Hello %name%', array('%name%' => $user->getName()), 'sf_guard') ?>
<?php end_slot(); ?>
<?php include_component('rtSnippet','snippetPanel', array('collection' => 'rt-guard-forgot-password-change-prefix','sf_cache_key' => 'rt-guard-forgot-password-change-prefix', 'default' => __('Enter your new password in the form below.', null, 'sf_guard'))); ?>
<form action="<?php echo url_for('@sf_guard_forgot_password_change?unique_key='.$sf_request->getParameter('unique_key')) ?>" method="POST">
  <?php echo $form->renderHiddenFields() ?>
  <fieldset>
  <legend><?php echo __('New password') ?></legend>
    <ul class="rt-form-schema">
      <li class="rt-form-row"><?php echo $form['password']->renderLabel() ?><div class="rt-form-field"><?php echo $form['password'] ?></div></li>
      <li class="rt-form-row"><?php echo $form['password_again']->renderLabel() ?><div class="rt-form-field"><?php echo $form['password_again'] ?></div></li>
    </ul>
  </fieldset>
  <p class="rt-form-tools"><button><?php echo __('Change', null, 'sf_guard') ?></button></p>
</form>