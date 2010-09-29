<?php use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtAdmin') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php use_javascript('/rtCorePlugin/js/main.js') ?>

<?php slot('rt-tools') ?>
<?php include_partial('rtAdmin/standard_modal_tools', array('show_route_handle' => 'admin', 'object' => $form->getObject()))?>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

<form id="rtAdminForm" action="<?php echo url_for('rtCommentAdmin/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form->renderHiddenFields(false) ?>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<input type="hidden" name="rt_post_save_action" value="edit" />
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <?php if(isset($parent_model)): ?>
        <?php
          $title = '';
          if($parent_model->getTitle())
          {
            $title = $parent_model->getTitle();
          }
          elseif($parent_model)
          {
            $title = $parent_model;
          }
        ?>
        <tr>
          <th><?php echo __('Attached to') ?></th>
          <td><?php echo ($title != '') ? link_to($parent_model,$form->getObject()->getModel().'Admin/edit?id='.$parent_model->getId()) : __('...') ?></td>
        </tr>
      <?php endif; ?>
      <?php echo render_form_row($form['is_active']); ?>
      <?php echo render_form_row($form['author_name']); ?>
      <?php echo render_form_row($form['author_email']); ?>
      <?php echo render_form_row($form['author_website']); ?>
      <?php echo render_form_row($form['content']); ?>      
    </tbody>
  </table>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Moderator') ?></h2>
    <table class="rt-admin-toggle-panel-content">
      <tbody>
        <?php echo render_form_row($form['moderator_note']); ?>
      </tbody>
    </table>
  </div>


</form>