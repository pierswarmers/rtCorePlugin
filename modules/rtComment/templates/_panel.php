<?php use_helper('I18N', 'Date', 'rtText', 'rtGravatar') ?>

<style type="text/css">
  /* Slider */
  #rating               { margin: 0 10px; }
  
  /* Rating styling */
  .rt-rating            { display: inline-block; vertical-align: text-bottom; }
  
  .rt-rating-text       { display: none; }
  
  .rt-rating-graph, .rt-rating-graph div { height: 20px; background-image: url('/rtUserPlugin/img/rating.png'); background-position: 0 0; background-repeat: repeat-x; }
  .rt-rating-graph      { width: 100px; background-color: #CCC; }
   .rt-rating-graph div { background-color: #000; }
   
   .rt-metas .rt-rating-graph, .rt-metas .rt-rating-graph div { background-position: 0 -20px; height: 10px; }
   .rt-metas .rt-rating-graph { width: 50px; }
</style>

<?php $commenting = sfConfig::get('app_rt_comment_active', true) && sfConfig::get('app_rt_comment_active', true) ?>

<?php if ($commenting): ?><div class="rt-section rt-comments"><?php endif; ?>

<?php if(sfConfig::get('app_rt_comment_active', true) && count($comments) > 0): ?>

  <div class="rt-section-header">
    <h3><?php echo count($comments) . ' ' .  __('responses to') . ' "' . $title . '"' ?>
    <?php if($rating_enabled): ?>
      <?php include_partial('rtComment/rating', array('rating_value' => $parent_object->getOverallRating(), 'show_items' => array('text','graph'))) ?>
    <?php endif; ?>
    </h3>
  </div>

  <div class="rt-section-content">
    <ul class="rt-comments-list">
      <?php foreach($comments as $comment): ?>
        <li class="clearfix" id="comment-<?php echo $comment->getId() ?>">
          <?php echo gravatar_for($comment->getAuthorEmail(), sfConfig::get('app_rt_gravatar_size_medium', 64), sfConfig::get('app_rt_gravatar_default', 'mm'), sfConfig::get('app_rt_gravatar_rating', 'g')) ?>
          <div>
            <cite>
              <?php echo link_to_if(trim($comment->getAuthorWebsite()) !== '', $comment->getAuthorName(), $comment->getAuthorWebsite()) ?> 
            </cite>
            <small class="rt-metas">
              <?php echo __('Left On') ?> <a href="#comment-<?php echo $comment->getId() ?>" title=""><?php echo format_date($comment->getCreatedAt(), 'D', $sf_user->getCulture()) ?></a>
              <span class="rating"><?php if($rating_enabled): ?><?php include_partial('rtComment/rating', array('rating_value' => $comment->getRating(), 'show_items' => array('graph'))) ?><?php endif; ?></span>
            </small>
            <?php echo markdown_to_html_safe($comment->getContent()) ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="rt-comment-tools"><a href="" target="_self"><span><?php echo __('Show more comments') ?></span><span style="display: none"><?php echo __('Show less comments') ?></span></a></p>
  </div>
    
<script type="text/javascript">
  $(function(){
    $('.rt-comments .rt-comments-list li:gt(1)').hide();
    $('.rt-comment-tools a').click(function(){
      event.preventDefault();    
      $(this).find('span').toggle();
      $('.rt-comments .rt-comments-list li:gt(1)').toggle();
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





