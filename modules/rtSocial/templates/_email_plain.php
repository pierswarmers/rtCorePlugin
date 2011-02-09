<?php use_helper('I18N') ?>
<?php $form_values = $sf_data->getRaw('form_values') ?>
<?php $object = $sf_data->getRaw('object') ?>
<?php $route_name = $sf_data->getRaw('route_name') ?>

<?php echo $from_text ?> requested that we send this e-mail. If you have questions about this item, please visit <?php echo url_for($route_name, $object, true) ?>  

<?php echo $name; ?>

================================

<?php if($object->getDescription() !== ''): ?>
<?php echo $object->getDescription(); ?>
<?php endif; ?> 

To view this item, go to: <?php echo url_for($route_name, $object, true) ?>

--------------------------------------------------------

<?php if($form_values['note'] !== ''): ?>
Comment from <?php echo $from_text ?>: <?php echo strip_tags(html_entity_decode($form_values['note'])) ?>
<?php endif; ?>