<?php use_helper('I18N', 'Date', 'rtText', 'rtGravatar') ?>
<ul class="rt-comment-list">
  <?php foreach($comments as $comment): ?>
  <li id="rt-comment-<?php echo $comment->getId() ?>">
    <div class="rt-avatar"><?php echo gravatar_for($comment->getAuthorEmail(), sfConfig::get('app_rt_comment_avatar_size', 48), sfConfig::get('app_rt_comment_avatar_default', 'mm'), sfConfig::get('app_rt_comment_avatar_rating', 'g')) ?></div>
    <cite><?php echo $comment->getAuthorName() ?></cite>
    <small class="rt-comment-meta-data"><a href="#rt-comment-<?php echo $comment->getId() ?>" title=""><?php echo format_date($comment->getCreatedAt(), 'D', $sf_user->getCulture()) ?></a>: </small>
    <div class="rt-comment-text">
      <?php echo markdown_to_html_safe($comment->getContent()) ?>
    </div>
  </li>
  <?php endforeach; ?>
</ul>