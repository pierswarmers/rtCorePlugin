<?php

use_helper('I18N', 'rtForm', 'rtTemplate', 'Text');

slot('rt-title', __('Search Results'));

$routes = $sf_context->getRouting()->getRoutes();

?>

<div class="rt-section rt-search">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Search Results') ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">
  
  <?php if(isset($pager)): ?>
  
    <?php if(count($pager) > 0): ?>
      <ul>
      <?php $i = 1; foreach($pager->getResults() as $rt_index): ?>
        <li>
          <h2>
            <?php echo link_to_if(isset($routes[Doctrine_Inflector::tableize($rt_index->getCleanModel()).'_show']),$rt_index->getObject()->getTitle(), Doctrine_Inflector::tableize($rt_index->getCleanModel()).'_show', $rt_index->getObject()) ?>
            <?php if(rtSiteToolkit::isMultiSiteEnabled()): ?>
            <?php include_partial('rtAdmin/site_reference_key', array('id' => $rt_index->getSiteId()))?>
            <?php endif; ?>
          </h2>
          <p>
            <?php echo $rt_index->getObject()->getDescription() ?> ... <?php echo link_to_if(isset($routes[Doctrine_Inflector::tableize($rt_index->getCleanModel()).'_show']), __('read more'), Doctrine_Inflector::tableize($rt_index->getCleanModel()).'_show', $rt_index->getObject()) ?>
          </p>
        </li>
      <?php $i++; endforeach; ?>
      </ul>
    <?php else: ?>
    <p><?php echo __('Nothing found, please try again.') ?></p>
    <?php endif; ?>

  <?php endif; ?>

  </div>
</div>

<?php include_partial('rtAdmin/pagination_public', array('pager' => $pager, 'params' => $sf_request->hasParameter('q') ? '&q=' . $sf_request->getParameter('q') : '')); ?>

