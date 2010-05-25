<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_helper('I18N', 'gnForm') ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>

<h1><?php echo __('Search Results') ?></h1>

<?php if(isset($pager)): ?>
<div class="gn-search-results">
  <?php if(count($pager) > 0): ?>
    <ul>
    <?php foreach($pager->getResults() as $gn_index): ?>
      <li><?php echo link_to_if(isset($routes[Doctrine_Inflector::tableize($gn_index->getCleanModel()).'_show']),$gn_index->getObject()->getTitle(), Doctrine_Inflector::tableize($gn_index->getCleanModel()).'_show', $gn_index->getObject()) ?></li>
    <?php endforeach; ?>
    </ul>
  <?php else: ?>
  <p><?php echo __('Nothing found, please try again.') ?></p>
  <?php endif; ?>
</div>
<?php endif; ?>