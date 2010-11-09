<?php use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtSite') ?>
<?php $class = isset($class) ? $class : 'rt-admin-edit-tools-panel-small'?>
<?php if ($snippets): ?>
  <div class="rt-snippet rt-show rt-primary-container rt-admin-edit-tools-panel <?php echo $class ?>">
    <?php $referer = url_for($sf_request->getParameter('module').DIRECTORY_SEPARATOR.$sf_request->getParameter('action'),true); ?>
    <?php if($snippets->count()): ?>
      <?php foreach($snippets as $snippet): ?>
        <?php $sf_user->getAttributeHolder()->remove('referer'); ?>
        <?php echo link_to(__('Edit'), 'rtSnippetAdmin/edit?id='.$snippet->getId(), array('class' => 'rt-admin-edit-tools-trigger')) ?>
        <a href="<?php echo url_for('rtSnippetAdmin/edit?id='.$snippet->getId()) . '?referer='.  urlencode($referer) ?>" class="rt-admin-edit-tools-trigger"><?php echo __('Edit') ?></a>
        <?php echo markdown_to_html($snippet->getContent(), $snippet); ?>
      <?php endforeach; ?>
    <?php else: ?>
      <a href="<?php echo url_for('rtSnippetAdmin/new?collection='.$collection) . '?referer='.  urlencode($referer) ?>" class="rt-admin-edit-tools-trigger"><?php echo __('Edit') ?></a>
      <?php echo isset($default) ? markdown_to_html($default) : '';  ?>
    <?php endif; ?>
  </div>
<?php endif; ?>