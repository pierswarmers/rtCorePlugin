<?php use_helper('I18N', 'rtForm', 'rtSocialNetworking') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php $name = $object->getTitle() ? $object->getTitle() : __('Item Page'); ?>

<?php slot('rt-title') ?>
<?php echo __('Share this item via email') ?>
<?php end_slot(); ?>

<?php if($form->isValid()): ?>
  <p><?php echo __('Your message has been sent.') ?> <?php echo __('Return to') ?> <?php echo link_to($name, url_for($route_name, $object)) ?></p>
<?php else: ?>
  <div class="rt-share-preview">
    <?php if($object->getPrimaryImage()): ?>
    <?php
      $config = sfConfig::get('app_rt_social');
      $img_m_width  = isset($config['item_medium']['max_width'])  ? $config['item_medium']['max_width'] : 150;
      $img_m_height = isset($config['item_medium']['max_height']) ? $config['item_medium']['max_height'] : 150;
      $img_path = rtAssetToolkit::getThumbnailPath($object->getPrimaryImage()->getSystemPath(), array('maxHeight' => $img_m_height, 'maxWidth' => $img_m_width));
      echo link_to(image_tag($img_path), url_for($route_name, $object));
    ?>
    <?php endif; ?>

    <h2><?php echo link_to($name, url_for($route_name, $object)) ?></h2>
    <p><?php echo $object->getDescription() ?></p>

  </div>
  <form action="<?php echo url_for('rt_social_email',array('model' => $model,'model_id' => $model_id)) ?>" method="post" class="rt-compact">
    <?php echo $form->renderHiddenFields() ?>
    <fieldset>
    <legend><?php echo __('Your Details') ?></legend>
      <ul class="rt-form-schema">
        <?php echo $form; ?>
      </ul>
    </fieldset>
    <p class="rt-form-tools">
      <button><?php echo __('Send email') ?></button>
      <?php echo __('Or, return to') ?> <?php echo link_to($name, url_for($route_name, $object)) ?>
    </p>
  </form>
<?php endif; ?>