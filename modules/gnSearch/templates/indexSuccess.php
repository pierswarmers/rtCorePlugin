<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_helper('I18N', 'GnForm') ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>

<h1>Search</h1>

<?php include_partial('form', array('form' => $form)) ?>
<?php if(isset($pager)): ?>
<div class="gn-search-results">
  <p><?php echo count($pager) . ' ' . __('results found.') ?></p>
  <?php if(count($pager) > 0): ?>
    <ul>
    <?php foreach($pager->getResults() as $gn_index): ?>
      <li><?php echo link_to_if(isset($routes[Doctrine_Inflector::tableize($gn_index->getCleanModel()).'_show']),$gn_index->getObject()->getTitle(), Doctrine_Inflector::tableize($gn_index->getCleanModel()).'_show', $gn_index->getObject()) ?></li>
    <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>
<?php endif; ?>