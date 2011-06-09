<?php use_helper('I18N', 'Date', 'rtText', 'rtGravatar') ?>

<?php $commenting = sfConfig::get('app_rt_comment_active', true) && sfConfig::get('app_rt_comment_active', true) ?>



<?php if ($commenting): ?><div class="rt-section rt-comments"><?php endif; ?>


<?php if(sfConfig::get('app_rt_comment_active', true) && count($comments) > 0): ?>

  <div class="rt-section-header">
    <h3><?php echo count($comments) . ' ' .  __('responses to') . ' "' . $title . '"' ?></h3>
  </div>

  <div class="rt-section-content">
    <ul>
      <?php foreach($comments as $comment): ?>
      <li class="clearfix" id="comment-<?php echo $comment->getId() ?>">
        <?php echo gravatar_for($comment->getAuthorEmail(), sfConfig::get('app_rt_gravatar_size_medium', 64), sfConfig::get('app_rt_gravatar_default', 'mm'), sfConfig::get('app_rt_gravatar_rating', 'g')) ?>
        <div>
          <cite><?php echo link_to_if(trim($comment->getAuthorWebsite()) !== '', $comment->getAuthorName(), $comment->getAuthorWebsite()) ?></cite>
          <small class="rt-metas"><?php echo __('Left On') ?> <a href="#comment-<?php echo $comment->getId() ?>" title=""><?php echo format_date($comment->getCreatedAt(), 'D', $sf_user->getCulture()) ?></a></small>
          <?php echo markdown_to_html_safe($comment->getContent()) ?>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
  <div>
<?php endif; ?>

<?php if(sfConfig::get('app_rt_comment_active', true)): ?>

  <div class="rt-section-content">

    <?php include_component('rtComment', 'form', array('form' => $form)) ?>

  </div>
  
<?php endif; ?>

<?php if ($commenting): ?></div><?php endif; ?>





