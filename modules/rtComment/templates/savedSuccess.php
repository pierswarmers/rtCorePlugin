<?php use_helper('I18N') ?>
<?php

$routes = $sf_context->getRouting()->getRoutes();
$route_name = Doctrine_Inflector::tableize($model).'_show';

?>
<h1><?php echo __('Comment Saved') ?></h1>

<p>Saved, needs approval... will show on site very soon.</p>
<p><?php echo link_to_if(isset($routes[$route_name]), __('Go back'), $route_name, $object) ?></p>