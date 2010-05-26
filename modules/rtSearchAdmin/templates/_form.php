<?php $heading_tag = isset($heading_tag) ? $heading_tag : 'h2' ?>
<div class="rt-search-holder">
  <<?php echo $heading_tag ?>><?php echo __('Site Search') ?></<?php echo $heading_tag ?>>
  <form class="rt-search-form" action="<?php echo url_for('@rt_search') ?>" method="get">
    <p>
      <?php echo $form['q']->renderLabel() ?> <?php echo $form['q'] ?> <?php echo $form['q']->renderHelp() ?>
      <button type="submit" class="button"><?php echo __('Search') ?></button>
    </p>
  </form>
</div>