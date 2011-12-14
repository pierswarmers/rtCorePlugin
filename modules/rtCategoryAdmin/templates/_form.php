<?php use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtAdmin') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php use_javascript('/rtCorePlugin/js/admin-main.js') ?>

<?php slot('rt-tools') ?>
<?php include_partial('rtAdmin/standard_modal_tools', array('object' => $form->getObject()))?>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

<form id="rtAdminForm" action="<?php echo url_for('rtCategoryAdmin/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form->renderHiddenFields(false) ?>
<input type="hidden" name="rt_post_save_action" value="edit" />
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <?php echo render_form_row($form['title']); ?>
    </tbody>
  </table>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Menu and Navigation') ?></h2>
    <table class="rt-admin-toggle-panel-content">
      <tbody>
        <?php echo render_form_row($form['position']); ?>
        <?php echo render_form_row($form['display_in_menu']); ?>
        <?php echo render_form_row($form['menu_title']); ?>
      </tbody>
    </table>
  </div>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Location and Referencing') ?></h2>
    <table class="rt-admin-toggle-panel-content">
      <tbody>
        <?php echo render_form_row($form['slug']); ?>
      </tbody>
    </table>
  </div>

</form>
