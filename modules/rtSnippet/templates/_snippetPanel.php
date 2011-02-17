<?php

use_helper('I18N', 'rtText');

$class = isset($class) ? $class : 'rt-admin-edit-tools-panel-small';

$options =array(
  'class'        => 'rt-admin-edit-tools-trigger',
  'query_string' => 'rt-snippet-referer=' . urlencode(rtSiteToolkit::getRequestUri())
);

?>
<?php if ($snippets): ?>
  <div class="rt-snippet rt-show rt-primary-container rt-admin-edit-tools-panel <?php echo $class ?>">
    <?php if($snippets->count()): ?>
      <?php foreach($snippets as $snippet): ?>
        <?php echo link_to(__('Edit'), 'rtSnippetAdmin/edit?id='.$snippet->getId(), $options) ?>
        <?php echo markdown_to_html($snippet->getContent(), $snippet); ?>
      <?php endforeach; ?>
    <?php else: ?>
      <?php $options['query_string'] .= '&collection='.$collection ?>
      <?php echo link_to(__('Edit'), 'rtSnippetAdmin/new',$options) ?>
      <?php echo isset($default) ? markdown_to_html($default) : ''  ?>
    <?php endif; ?>
  </div>
<?php endif; ?>