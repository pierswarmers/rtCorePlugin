<?php $show_items = isset($show_items) ? $show_items->getRawValue() : array('text','graph'); ?>

<div class="rt-rating">
    
  <!------ Text rating -->
  <?php if(array_search('text',$show_items) !== false): ?>
    <div class="rt-rating-text">
      <?php echo sprintf('%s / 10',$rating_value * 10) ?>
    </div>
  <?php endif; ?>
  
  <!------ Graph rating -->
  <?php if(array_search('graph',$show_items) !== false): ?>
    <div class="rt-rating-graph">
      <div style="width: <?php echo $rating_value * 100 ?>%"></div>
    </div>
  <?php endif; ?>
  
</div>