<?php use_helper('I18N', 'rtForm') ?>

<form id="rtComment" action="<?php echo url_for('rtComment/'.($form->getObject()->isNew() ? 'new' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" class="rt-compact">
  <input type="hidden" name="id" value="<?php echo sfContext::getInstance()->getRequest()->getParameter('id') ?>" />
  <?php echo $form->renderHiddenFields() ?>
  <table>
    <tbody>
      <?php echo render_form_row($form['author_name']); ?>
      <?php echo render_form_row($form['author_email']); ?>
      <?php echo render_form_row($form['author_website']); ?>
      <?php echo render_form_row($form['content']); ?>
    </tbody>
  </table>
  <p><button type="submit"><?php echo __('Save comment') ?></button></p>
</form>