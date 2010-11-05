<?php
use_helper('I18N');
$routes = $sf_context->getRouting()->getRoutes();
$route_name = Doctrine_Inflector::tableize($model).'_show';
?>
<?php slot('rt-title', __('Thanks for the comment')) ?>
<p><?php echo __('Your comment has been added and is awaiting approval.') ?></p>
<p><?php echo link_to_if(isset($routes[$route_name]), __('Go back'), $route_name, $object) ?></p>