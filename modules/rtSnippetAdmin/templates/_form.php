<?php use_helper('I18N', 'rtForm') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('rt-tools') ?>
<?php
$options = array();
$options['object'] = $form->getObject();
if($sf_user->hasAttribute('rt-snippet-referer'))
{
  $options['show_route_handle'] = 'admin';
}
?>
<?php include_partial('rtAdmin/standard_modal_tools', $options)?>
<?php end_slot(); ?>

<?php slot('rt-side') ?>
<?php if ($form->getObject()->getMode() !== 'gallery'): ?>
<?php include_component('rtAsset', 'form', array('object' => $form->getObject())) ?>
<?php endif; ?>
<?php end_slot(); ?>

<form id ="rtAdminForm" action="<?php echo url_for('rtSnippetAdmin/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form->renderHiddenFields(false) ?>
<input type="hidden" name="rt_post_save_action" value="edit" />
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <?php if ($form->getObject()->getMode() !== 'gallery'): ?>
        <?php echo render_form_row($form['content']); ?>
      <?php else: ?>
      <tr>
          <th>Gallery</th>
          <td>
            <?php include_component('rtAsset', 'form', array('object' => $form->getObject())) ?>
          </td>
      </tr>
      <?php endif; ?>
      <?php echo render_form_row($form['mode']); ?>
    </tbody>
  </table>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Publish Status') ?></h2>
    <table class="rt-admin-toggle-panel-content">
      <tbody>
        <?php echo render_form_row($form['published']); ?>
        <?php echo render_form_row($form['published_from']); ?>
        <?php echo render_form_row($form['published_to']); ?>
      </tbody>
    </table>
  </div>

  <?php if(isset($form['site_id'])): ?>
    <div class="rt-admin-toggle-panel">
      <h2><?php echo __('Location and Referencing') ?></h2>
      <table class="rt-admin-toggle-panel-content">
        <tbody>
          <?php echo render_form_row($form['site_id']); ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Advanced Options') ?></h2>
    <table class="rt-admin-toggle-panel-content">
      <tbody>
        <?php echo render_form_row($form['title']); ?>
        <?php echo render_form_row($form['collection']); ?>
        <?php echo render_form_row($form['position']); ?>
      </tbody>
    </table>
  </div>

</form>
