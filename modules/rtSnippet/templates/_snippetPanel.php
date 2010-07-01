<?php use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtSite') ?>
<?php if ($snippets): ?>
<?php foreach($snippets as $snippet): ?>
<div class="rt-nippet rt-show rt-primary-container rt-admin-edit-tools-panel">
  <?php echo link_to(__('Edit'), 'rtSnippetAdmin/edit?id='.$snippet->getId(), array('class' => 'rt-admin-edit-tools-trigger')) ?>
  <?php echo markdown_to_html($snippet->getContent(), $snippet); ?>
</div>
<?php endforeach; ?>
<?php endif; ?>