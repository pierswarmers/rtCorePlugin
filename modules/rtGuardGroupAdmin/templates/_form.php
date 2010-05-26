<?php use_helper('I18N') ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('rt-side') ?>
<p>
  <button type="submit" class="button positive" onclick="$('#rtAdminForm').submit()"><?php echo $form->getObject()->isNew() ? __('Create this group') : __('Save and close') ?></button>
  <?php echo button_to(__('Cancel'),'rtGuardGroupAdmin/index', array('class' => 'button cancel')) ?>
  <?php if (!$form->getObject()->isNew()): ?>
    <br /><?php echo __('Or') ?>, <?php echo link_to('delete this group', 'rtGuardGroupAdmin/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
  <?php endif; ?>
</p>
<?php end_slot(); ?>

<form id="rtAdminForm" action="<?php echo url_for('rtGuardGroupAdmin/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form->renderHiddenFields(false) ?>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['permissions_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['permissions_list']->renderError() ?>
          <?php echo $form['permissions_list'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['users_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['users_list']->renderError() ?>
          <?php echo $form['users_list'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
