<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_helper('I18N', 'rtForm', 'Text') ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>

<?php slot('rt-title') ?>
<?php echo __('Search Results') ?>
<?php end_slot(); ?>

<?php if(isset($pager)): ?>
<div class="rt-container rt-collection">
  <?php if(count($pager) > 0): ?>
    <ul>
    <?php $i = 1; foreach($pager->getResults() as $rt_index): ?>
      <li class="rt-list-item rt-list-item-<?php echo $i ?>">
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
</div>
<?php endif; ?>

<?php include_partial('rtAdmin/pagination_public', array('pager' => $pager, 'params' => $sf_request->hasParameter('q') ? '&q=' . $sf_request->getParameter('q') : '')); ?>
