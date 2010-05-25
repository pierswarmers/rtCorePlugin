<div class="gn-search-holder">
  <form class="gn-search-form" action="<?php echo url_for('@gn_search') ?>" method="get">
    <p>
      <input type="text" name="q" value="<?php echo $sf_request->getParameter('q', '') ?>" />
      <button type="submit" class="button"><?php echo __('Search') ?></button>
    </p>
  </form>
</div>