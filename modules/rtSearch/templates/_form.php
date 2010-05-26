<div class="rt-search-holder">
  <form class="rt-search-form" action="<?php echo url_for('@rt_search') ?>" method="get">
    <p>
      <input type="text" name="q" value="<?php echo $sf_request->getParameter('q', '') ?>" />
      <button type="submit" class="button"><?php echo __('Search') ?></button>
    </p>
  </form>
</div>