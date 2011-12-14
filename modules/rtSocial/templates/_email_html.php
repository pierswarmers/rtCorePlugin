<?php use_helper('I18N') ?>
<?php $form_values = $sf_data->getRaw('form_values') ?>
<?php $object = $sf_data->getRaw('object') ?>
<?php $route_name = $sf_data->getRaw('route_name') ?>

<p><?php echo $from_text ?> requested that we send this e-mail. If you have questions about this item, please visit <?php echo link_to($name, url_for($route_name, $object, true)) ?></p>

<table>
  <tbody>
    <tr>
      <?php if($object->getPrimaryImage()): ?>
        <td><?php
            $config = sfConfig::get('app_rt_social');
            $img_m_width  = isset($config['item_medium']['max_width'])  ? $config['item_medium']['max_width'] : 150;
            $img_m_height = isset($config['item_medium']['max_height']) ? $config['item_medium']['max_height'] : 150;
            $img_path = rtAssetToolkit::getThumbnailPath($object->getPrimaryImage()->getWebPath(), array('maxHeight' => $img_m_height, 'maxWidth' => $img_m_width));
            echo link_to(image_tag("http://" . $_SERVER['HTTP_HOST'] . $img_path), url_for($route_name, $object, true));
          ?></td>
      <?php endif; ?>
      <td><?php echo link_to($name, url_for($route_name, $object, true)) ?><br /><?php echo $object->getDescription() ?></td>
    </tr>
  </tbody>
</table>

<?php if($form_values['note'] !== ''): ?>
  <p><strong>Comment from <?php echo $from_text ?>:</strong> <?php echo strip_tags(html_entity_decode($form_values['note'])) ?></p>
<?php endif; ?>

