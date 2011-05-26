<?php use_helper('I18N') ?>

<?php use_javascript('/rtCorePlugin/js/admin-main.js') ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('rt-tools') ?>
<?php include_partial('rtAdmin/standard_modal_tools', array('object' => $form->getObject(), 'controller' => 'rtGuardUserAdmin'))?>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

<form id="rtAdminForm" action="<?php echo url_for('rtGuardUserAdmin/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form->renderHiddenFields() ?>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<input type="hidden" name="rt_post_save_action" value="edit" />
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
  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Profile Information') ?></h2>
    <table class="rt-admin-toggle-panel-content">
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
          <th><?php echo $form['company']->renderLabel() ?></th>
          <td>
            <?php echo $form['company']->renderError() ?>
            <?php echo $form['company'] ?>
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

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Permissions and Groups') ?></h2>
    <table class="rt-admin-toggle-panel-content">
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

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Billing Address') ?></h2>
    <?php include_partial('address_form', array('form' => $form['billing_address'])); ?>
  </div>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Shipping Address') ?></h2>
    <?php include_partial('address_form', array('form' => $form['shipping_address'])); ?>
  </div>
</form>
