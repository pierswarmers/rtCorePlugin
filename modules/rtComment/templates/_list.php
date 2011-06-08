<?php use_helper('I18N', 'Date', 'rtText', 'rtGravatar') ?>
<?php if(sfConfig::get('app_rt_comment_active', true)): ?>



<div class="rtPageHolder rtComments">
  
  <div class="rtPageHeading">
    <h3><?php echo count($comments) . ' ' .  __('responses to') . ' "' . $title . '"' ?></h3>
  </div>

  <ul class="rtPageContent">
    <?php foreach($comments as $comment): ?>
    <li class="rtPageContentItem rtComment clearfix">
      <?php echo gravatar_for($comment->getAuthorEmail(), sfConfig::get('app_rt_gravatar_size_medium', 64), sfConfig::get('app_rt_gravatar_default', 'mm'), sfConfig::get('app_rt_gravatar_rating', 'g')) ?>
      <div>
        <cite><?php echo link_to_if(trim($comment->getAuthorWebsite()) !== '', $comment->getAuthorName(), $comment->getAuthorWebsite()) ?></cite>
        <small><?php echo __('Left On') ?> <a href="#rt-comment-<?php echo $comment->getId() ?>" title=""><?php echo format_date($comment->getCreatedAt(), 'D', $sf_user->getCulture()) ?></a></small>
        <?php echo markdown_to_html_safe($comment->getContent()) ?>
      </div>
    </li>
    <?php endforeach; ?>
  </ul>

</div>
<?php endif; ?>