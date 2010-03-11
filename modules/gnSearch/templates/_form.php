<form class="gn-search-form" action="<?php echo url_for('@gn_search') ?>" method="get">
  <p>
    <?php echo $form['q']->renderLabel() ?> <?php echo $form['q'] ?> <?php echo $form['q']->renderHelp() ?>
    <button type="submit" class="button"><?php echo __('Search') ?></button>
  </p>
</form>