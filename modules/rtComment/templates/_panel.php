<?php use_helper('I18N', 'Date', 'rtText', 'rtGravatar') ?>

<?php $commenting = sfConfig::get('app_rt_comment_active', true) && sfConfig::get('app_rt_comment_active', true) ?>

<?php if ($commenting): ?><div class="rt-section rt-comments"><?php endif; ?>

<?php if(sfConfig::get('app_rt_comment_active', true) && count($comments) > 0): ?>

  <div class="rt-section-header">
    <h2><?php echo count($comments) . ' ' .  (count($comments) > 1 ? __('Person Has Commented') : __('People Have Commented')) ?>
    <?php if($rating_enabled): ?>
      <?php include_partial('rtComment/rating', array('rating_value' => $parent_object->getOverallRating(), 'show_items' => array('text','graph'))) ?>
    <?php endif; ?>
    </h2>
  </div>

  <div class="rt-section-content rt-comments-list">
    <ul>
      <?php foreach($comments as $comment): ?>
        <li id="rt-comment-<?php echo $comment->getId() ?>">
          <?php echo gravatar_for($comment->getAuthorEmail(), sfConfig::get('app_rt_gravatar_size_medium', 64), sfConfig::get('app_rt_gravatar_default', 'mm'), sfConfig::get('app_rt_gravatar_rating', 'g')) ?>
          <div class="rt-comment-content">
            <cite class="rt-metas">
              <?php echo link_to_if(trim($comment->getAuthorWebsite()) !== '', $comment->getAuthorName(), $comment->getAuthorWebsite()) ?> <?php echo __('said') ?>
              ( <a href="#comment-<?php echo $comment->getId() ?>" title=""><?php echo format_date($comment->getCreatedAt(), 'D', $sf_user->getCulture()) ?></a>)
              <?php if($rating_enabled): ?>
                <span class="rating"> <?php include_partial('rtComment/rating', array('rating_value' => $comment->getRating(), 'show_items' => array('graph'))) ?></span>
              <?php endif; ?>
            </cite>
            <?php echo markdown_to_html_safe($comment->getContent()) ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="rt-comment-tools"><a href="" target="_self"><span><?php echo __('Show more comments') ?></span><span style="display: none"><?php echo __('Show fewer comments') ?></span></a></p>
  </div>
    
<script type="text/javascript">
  $(function(){

    // Only show the toggle button if needed.
    if($('.rt-comments-list li').size() < 3) { $('.rt-comment-tools a').hide(); }

    // Look for special cases, like when a hash link is present
    if(location.href.indexOf("#") == -1) {
      $('.rt-comments .rt-comments-list li:gt(1)').hide();
    } else {
      $('.rt-comment-tools span').toggle();
    }

    // Enable the onclick action
    $('.rt-comment-tools a').click(function(){
      event.preventDefault();  $(this).find('span').toggle(); $('.rt-comments .rt-comments-list li:gt(1)').toggle();
    });
  });  
</script>    
    
<?php endif; ?>

<?php if(sfConfig::get('app_rt_comment_active', true)): ?>

  <div class="rt-section-content">

    <?php include_component('rtComment', 'form', array('form' => $form, 'rating_enabled' => $rating_enabled)) ?>

  </div>
  
<?php endif; ?>

<?php if ($commenting): ?></div><?php endif; ?>





