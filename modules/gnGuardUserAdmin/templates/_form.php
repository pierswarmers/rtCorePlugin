<?php use_helper('I18N') ?>

<?php use_javascript('/gnCorePlugin/js/main.js') ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('gn-side') ?>
<p>
  <button type="submit" class="button positive" onclick="$('#gnAdminForm').submit()"><?php echo $form->getObject()->isNew() ? __('Create this user') : __('Save and close') ?></button>
  <?php echo button_to(__('Cancel'),'gnGuardUserAdmin/index', array('class' => 'button cancel')) ?>
  <?php if (!$form->getObject()->isNew()): ?>
    <br /><?php echo __('Or') ?>, <?php echo link_to('delete this user', 'gnGuardUserAdmin/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
  <?php endif; ?>
</p>
<?php end_slot(); ?>

<form id="gnAdminForm" action="<?php echo url_for('gnGuardUserAdmin/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form->renderHiddenFields(false) ?>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['email_address']->renderLabel() ?></th>
        <td>
          <?php echo $form['email_address']->renderError() ?>
          <?php echo $form['email_address'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['username']->renderLabel() ?></th>
        <td>
          <?php echo $form['username']->renderError() ?>
          <?php echo $form['username'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>

      <tr>
        <th><?php echo $form['password_again']->renderLabel() ?></th>
        <td>
          <?php echo $form['password_again']->renderError() ?>
          <?php echo $form['password_again'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_active']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_active']->renderError() ?>
          <?php echo $form['is_active'] ?>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="gn-admin-toggle-panel">
    <h2><?php echo __('Profile Information') ?></h2>
    <table class="gn-admin-toggle-panel-content">
      <tbody>
      <tr>
        <th><?php echo $form['first_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['first_name']->renderError() ?>
          <?php echo $form['first_name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['last_name']->renderLabel() ?></th>
        <td>
          <?php echo $form['last_name']->renderError() ?>
          <?php echo $form['last_name'] ?>
        </td>
      </tr>
        <tr>
          <th><?php echo $form['date_of_birth']->renderLabel() ?></th>
          <td>
            <?php echo $form['date_of_birth']->renderError() ?>
            <?php echo $form['date_of_birth'] ?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form['phone']->renderLabel() ?></th>
          <td>
            <?php echo $form['phone']->renderError() ?>
            <?php echo $form['phone'] ?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form['fax']->renderLabel() ?></th>
          <td>
            <?php echo $form['fax']->renderError() ?>
            <?php echo $form['fax'] ?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form['mobile']->renderLabel() ?></th>
          <td>
            <?php echo $form['mobile']->renderError() ?>
            <?php echo $form['mobile'] ?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form['url']->renderLabel() ?></th>
          <td>
            <?php echo $form['url']->renderError() ?>
            <?php echo $form['url'] ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="gn-admin-toggle-panel">
    <h2><?php echo __('Permissions and Groups') ?></h2>
    <table class="gn-admin-toggle-panel-content">
      <tbody>
        <tr>
          <th><?php echo $form['is_super_admin']->renderLabel() ?></th>
          <td>
            <?php echo $form['is_super_admin']->renderError() ?>
            <?php echo $form['is_super_admin'] ?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form['groups_list']->renderLabel() ?></th>
          <td>
            <?php echo $form['groups_list']->renderError() ?>
            <?php echo $form['groups_list'] ?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form['permissions_list']->renderLabel() ?></th>
          <td>
            <?php echo $form['permissions_list']->renderError() ?>
            <?php echo $form['permissions_list'] ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</form>
