<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_helper('I18N', 'GnForm') ?>

<h1>Search</h1>

<form action="<?php echo url_for('@gn_search') ?>" method="get">
  <p>
    <?php echo $form['q']->renderLabel() ?> <?php echo $form['q'] ?> <?php echo $form['q']->renderHelp() ?>
    <button type="submit" class="button positive medium"><?php echo __('Search') ?></button>
  </p>
</form>
<?php if(isset($pager)): ?>
<div class="gn-search-results">
  <p><?php echo count($pager) . ' ' . __('results found.') ?></p>
  <?php if(count($pager) > 0): ?>
    <ul>
    <?php foreach($pager->getResults() as $gn_index): ?>
      <li><?php echo link_to($gn_index->getObject()->getTitle(), Doctrine_Inflector::tableize($gn_index->getCleanModel()).'_show', $gn_index->getObject()) ?></li>
    <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>
<?php endif; ?>