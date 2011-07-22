<?php

use_helper('I18N', 'rtText');

$class = isset($class) ? $class : 'rt-admin-edit-tools-panel-small';

$options =array(
  'class'        => 'rt-admin-edit-tools-trigger',
  'query_string' => 'rt-snippet-referer=' . urlencode(rtSiteToolkit::getRequestUri())
);

?>

<?php if ($snippets && $snippets->count()): ?>

  <div class="rt-snippet <?php echo $class ?>">
    <?php foreach($snippets as $snippet): ?>
    <!--RTAS <div class="rt-admin-tools"><?php echo link_to(__('Edit Snippet'), 'rtSnippetAdmin/edit?id='.$snippet->getId(), $options) ?></div> RTAS-->
    <?php echo markdown_to_html($snippet->getContent(), $snippet); ?>
    <?php endforeach; ?>
  </div>

<?php else: ?>

  <div class="rt-snippet <?php echo $class ?>">
      <?php $options['query_string'] .= '&collection='.$collection ?>
      <!--RTAS <div class="rt-admin-tools"><?php echo link_to(__('Edit Snippet'), 'rtSnippetAdmin/new',$options) ?></div> RTAS-->
      <?php echo isset($default) ? markdown_to_html($default) : ''  ?>
  </div>

<?php endif; ?>