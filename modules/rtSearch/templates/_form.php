<form class="rt-search" action="<?php echo url_for('@rt_search') ?>" method="get">
  <p>
    <input type="text" name="q" value="<?php echo $sf_request->getParameter('q', '') ?>" placeholder="<?php echo __('Enter your search terms') ?>..." />
    <button type="submit" class="button"><?php echo __('Search') ?></button>
  </p>
</form>