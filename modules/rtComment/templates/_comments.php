<?php use_helper('I18N', 'rtForm', 'Date', 'rtText') ?>

<div class="rt-comment-list">
  <?php if(count($comments) > 0): ?>
    <?php foreach($comments as $comment): ?>
      <?php if($comment->getIsActive()): ?>
        <h4>
          <span class="date"><?php echo format_date($comment->getCreatedAt(), 'D', $sf_user->getCulture()) ?></span>
          <?php echo __('Author') ?>: <?php echo $comment->getAuthorName() ?>
        </h4>
        <p><?php echo markdown_to_html_safe($comment->getContent()) ?></p>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php else: ?>
    <p><?php echo __('No comments found.'); ?></p>
  <?php endif; ?>
</div>

<?php include_partial('rtComment/form', array('form' => $form)) ?>