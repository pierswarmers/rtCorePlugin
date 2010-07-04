<?php use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtSite') ?>
<?php if ($snippets): ?>
  <div class="rt-nippet rt-show rt-primary-container rt-admin-edit-tools-panel">
    <?php if(count($snippets) >= 1): ?>
      <?php foreach($snippets as $snippet): ?>
        <?php echo link_to(__('Edit'), 'rtSnippetAdmin/edit?id='.$snippet->getId(), array('class' => 'rt-admin-edit-tools-trigger')) ?>
        <?php echo markdown_to_html($snippet->getContent(), $snippet); ?>
      <?php endforeach; ?>
    <?php else: ?>
      <?php echo markdown_to_html($default_snippet_content); ?>
    <?php endif; ?>
  </div>
<?php endif; ?>