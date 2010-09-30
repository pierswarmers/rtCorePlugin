<?php use_helper('I18N') ?>
<?php include_javascripts_for_form($form) ?>
<?php include_stylesheets_for_form($form) ?>
<div class="rt-comment-list-form">
  <form id="rtComment" action="<?php echo url_for('rtComment/create') ?>" method="post" class="rt-compact">
    <h3><?php echo __('Have your say!') ?></h3>
    <input type="hidden" name="id" value="<?php echo sfContext::getInstance()->getRequest()->getParameter('id') ?>" />
    <?php echo $form->renderHiddenFields() ?>
    <table>
      <tbody>
        <?php echo $form; ?>
      </tbody>
    </table>
    <p><button type="submit"><?php echo __('Save comment') ?></button></p>
  </form>
</div>