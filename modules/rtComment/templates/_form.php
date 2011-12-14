<?php use_helper('I18N'); ?>

<?php use_javascripts_for_form($form) ?>
<?php use_stylesheets_for_form($form) ?>

<?php if(sfConfig::get('app_rt_comment_active', true)): ?>

    <form action="<?php echo url_for('rtComment/create?rating_enabled='.$rating_enabled) ?>" method="post">
      <fieldset>
        <legend><?php echo __('Have your say!') ?></legend>
        <?php echo $form->renderHiddenFields() ?>
        <ul class="rt-form-schema">
          <?php echo $form; ?>
        </ul>
      </fieldset>
      <p class="rt-section-tools-submit"><button type="submit"><?php echo __('Save comment') ?></button></p>
    </form>

<?php endif; ?>