<?php use_helper('I18N', 'Date', 'rtText', 'rtGravatar') ?>

<?php $commenting = sfConfig::get('app_rt_comment_active', true) && sfConfig::get('app_rt_comment_active', true) ?>



<?php if ($commenting): ?><div class="section rt-comments"><?php endif; ?>


<?php if(sfConfig::get('app_rt_comment_active', true) && count($comments) > 0): ?>

  <div class="section-header">
    <h3><?php echo count($comments) . ' ' .  __('responses to') . ' "' . $title . '"' ?></h3>
  </div>

  <ul class="section-content">
    <?php foreach($comments as $comment): ?>
    <li class="section-repeater clearfix" id="comment-<?php echo $comment->getId() ?>">
      <?php echo gravatar_for($comment->getAuthorEmail(), sfConfig::get('app_rt_gravatar_size_medium', 64), sfConfig::get('app_rt_gravatar_default', 'mm'), sfConfig::get('app_rt_gravatar_rating', 'g')) ?>
      <div>
        <cite><?php echo link_to_if(trim($comment->getAuthorWebsite()) !== '', $comment->getAuthorName(), $comment->getAuthorWebsite()) ?></cite>
        <small class="metas"><?php echo __('Left On') ?> <a href="#comment-<?php echo $comment->getId() ?>" title=""><?php echo format_date($comment->getCreatedAt(), 'D', $sf_user->getCulture()) ?></a></small>
        <?php echo markdown_to_html_safe($comment->getContent()) ?>
      </div>
    </li>
    <?php endforeach; ?>
  </ul>

<?php endif; ?>

<?php if(sfConfig::get('app_rt_comment_active', true)): ?>
  <form action="<?php echo url_for('rtComment/create') ?>" method="post">
    <fieldset>
      <legend><?php echo __('Have your say!') ?></legend>
      <?php echo $form->renderHiddenFields() ?>
      <ul>
        <?php echo $form; ?>
      </ul>
    </fieldset>
    <p class="section-tools-submit"><button type="submit"><?php echo __('Save comment') ?></button></p>
  </form>
<?php endif; ?>

<?php if ($commenting): ?></div><?php endif; ?>





