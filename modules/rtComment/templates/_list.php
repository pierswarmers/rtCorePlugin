<?php use_helper('I18N', 'Date', 'rtText', 'rtGravatar') ?>
<div class="rt-comment-list">
  <h3><?php echo count($comments) . ' ' .  __('responses to') . '"' . $title . '"' ?></h3>
  <ul class="rt-comment-list">
    <?php foreach($comments as $comment): ?>
    <li id="rt-comment-<?php echo $comment->getId() ?>">
      <div class="rt-avatar"><?php echo gravatar_for($comment->getAuthorEmail(), sfConfig::get('app_rt_gravatar_size_medium', 48), sfConfig::get('app_rt_gravatar_default', 'mm'), sfConfig::get('app_rt_gravatar_rating', 'g')) ?></div>
      <cite><?php echo link_to_if(trim($comment->getAuthorWebsite()) !== '', $comment->getAuthorName(), $comment->getAuthorWebsite()) ?></cite>
      <small class="rt-comment-meta-data"><?php echo __('said on') ?>: <a href="#rt-comment-<?php echo $comment->getId() ?>" title=""><?php echo format_date($comment->getCreatedAt(), 'D', $sf_user->getCulture()) ?></a>: </small>
      <div class="rt-comment-text">
        <?php echo markdown_to_html_safe($comment->getContent()) ?>
      </div>
    </li>
    <?php endforeach; ?>
  </ul>
</div>