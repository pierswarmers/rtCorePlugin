<?php use_javascript('/rtCorePlugin/js/main.js?id=234234') ?>
<?php $rand = rand(); ?>
<ul class="rt-markdown-tools">
  <li><a href="#" id="rtLinkPanelTrigger<?php $rand = rand(); ?>"  class="button" onclick="setReplacementToken('#<?php echo $targetId ?>');return false;" rel="#rtLinkPanel<?php $rand = rand(); ?>">Insert Link</a></li>
  <li><a href="#" class="button" onclick="injectTextIntoCurrent('[gallery]');return false;">Insert Gallery</a></li>
  <li><a href="#" class="button" onclick="injectTextIntoCurrent('[docs]');return false;">Insert Docs</a></li>
</ul>
<div class="rt-modal-panel" id="rtLinkPanel<?php $rand = rand(); ?>">
  <h2><?php echo __('Find a page to link to:') ?></h2>
  <div class="inner">
    <p>
      <input type="text" name="q" id="rtLinkPanelQuery<?php echo $rand ?>" value="" />
      <button type="submit" class="button" id="rtLinkPanelId<?php echo $rand ?>"><?php echo __('Search') ?></button>
    </p>
    <ul id="rtLinkPanelResults<?php echo $rand ?>" class="inner-panel">&nbsp;</ul>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("a[rel]").overlay({
      expose: {
        color: '#000',
        opacity: 0.4,
        onClose: function(event) {
            updateReplacementToken('','#<?php echo $targetId ?>');
        }
      }
    });
    enableLinkPanel(
      '#rtLinkPanelQuery<?php echo $rand ?>',
      '#rtLinkPanelId<?php echo $rand ?>',
      '#rtLinkPanelResults<?php echo $rand ?>',
      '<?php echo url_for('@rt_search_ajax?sf_format=json') ?>',
      '#<?php echo $targetId ?>'
    );
  });
</script>