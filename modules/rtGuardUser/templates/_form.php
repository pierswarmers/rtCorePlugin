<?php use_helper('I18N') ?>



<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>


<?php include_partial('rtAdmin/flashes_public') ?>

<form action="<?php echo url_for('rtGuardUser/update') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form->renderHiddenFields() ?>
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

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Billing Address') ?></h2>
    <?php include_partial('address_form', array('form' => $form['billing_address'])); ?>
  </div>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Shipping Address') ?></h2>
    <?php include_partial('address_form', array('form' => $form['shipping_address'])); ?>
  </div>
  <p><button type="submit"><?php echo __('Save Changes') ?></button></p>
</form>
