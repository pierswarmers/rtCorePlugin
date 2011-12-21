<?php use_helper('I18N', 'rtForm') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('rt-tools') ?>
<?php
$options = array();
$options['object'] = $form->getObject();
if($sf_user->hasAttribute('rt-site-referer'))
{
  $options['show_route_handle'] = 'admin';
}
?>
<?php include_partial('rtAdmin/standard_modal_tools', $options)?>
<?php end_slot(); ?>

<?php slot('rt-side') ?>
<?php include_component('rtAsset', 'form', array('object' => $form->getObject())) ?>
<?php end_slot(); ?>

<form id ="rtAdminForm" action="<?php echo url_for('rtSiteAdmin/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php echo $form->renderHiddenFields(false) ?>
  <input type="hidden" name="rt_post_save_action" value="edit" />
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  <table>
    <tbody>
    <?php echo $form->renderGlobalErrors() ?>
    <?php echo render_form_row($form['title']); ?>
    <?php echo render_form_row($form['content']); ?>
    </tbody>
  </table>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Social Linking') ?></h2>
    <table class="rt-admin-toggle-panel-content">
      <tbody>
      <?php echo render_form_row($form['devour_url']); ?>
      <?php echo render_form_row($form['facebook_url']); ?>
      <?php echo render_form_row($form['flickr_url']); ?>
      <?php echo render_form_row($form['tumblr_url']); ?>
      <?php echo render_form_row($form['twitter_url']); ?>
      <?php echo render_form_row($form['youtube_url']); ?>

      </tbody>
    </table>
  </div>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Statistics') ?></h2>
    <table class="rt-admin-toggle-panel-content">
      <tbody>
      <?php echo render_form_row($form['ga_code']); ?>
      <?php echo render_form_row($form['ga_domain']); ?>
      </tbody>
    </table>
  </div>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Publish Status') ?></h2>
    <table class="rt-admin-toggle-panel-content">
      <tbody>
      <?php echo render_form_row($form['published']); ?>
      </tbody>
    </table>
  </div>

  <div class="rt-admin-toggle-panel">
    <h2><?php echo __('Advanced') ?></h2>
    <table class="rt-admin-toggle-panel-content">
      <tbody>
      <?php echo render_form_row($form['reference_key']); ?>
      <?php echo render_form_row($form['domain']); ?>
      </tbody>
    </table>
  </div>


</form>
