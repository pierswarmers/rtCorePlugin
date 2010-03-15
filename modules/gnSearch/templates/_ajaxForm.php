<?php $rand = rand(); ?>
<a href="#" id="gnLinkPanelTrigger<?php $rand = rand(); ?>" rel="#gnLinkPanel<?php $rand = rand(); ?>">Insert Link</a>
<div class="gn-modal-panel" id="gnLinkPanel<?php $rand = rand(); ?>">
  <h2><?php echo __('Find a page to link to:') ?></h2>
  <div class="inner">
    <p>
      <input type="text" name="q" id="gnLinkPanelQuery<?php echo $rand ?>" value="" />
      <button type="submit" class="button" id="gnLinkPanelId<?php echo $rand ?>"><?php echo __('Search') ?></button>
    </p>
    <ul id="gnLinkPanelResults<?php echo $rand ?>" class="inner-panel">&nbsp;</ul>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("a[rel]").overlay({
      expose: {
        color: '#000',
        opacity: 0.4
      }
    });
    enableLinkPanel(
      '#gnLinkPanelQuery<?php echo $rand ?>',
      '#gnLinkPanelId<?php echo $rand ?>',
      '#gnLinkPanelResults<?php echo $rand ?>',
      '<?php echo url_for('@gn_search_ajax?sf_format=json') ?>',
      '<?php echo $targetId ?>'
    );
  });
</script>