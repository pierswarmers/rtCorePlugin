<?php $rand = rand(); ?>
<div class="gn-modal-panel" id="gnLinkPanel">
  <h2><?php echo __('Find a page to link to:') ?></h2>
  <div class="inner">
    <form id="gnLinkForm<?php echo $rand ?>" class="gn-search-form" action="<?php echo url_for('@gn_search_ajax?sf_format=json') ?>" method="get">
      <p>
        <input type="text" name="q" id="gnLinkFormQuery<?php echo $rand ?>" value="" />
        <button type="submit" class="button"><?php echo __('Search') ?></button>
      </p>
    </form>
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
    $("#gnLinkForm<?php echo $rand ?>").submit(function() {
      $.ajax({
        url: '<?php echo url_for('@gn_search_ajax?sf_format=json') ?>',
        dataType: 'json',
        data: { q : $('#gnLinkFormQuery<?php echo $rand ?>').attr('value') },
        success: function(data) {
          $('#gnLinkPanelResults<?php echo $rand ?>').html('');
          $.each(data.items, function(index, value) {
            $('<li><a href="#" onclick="injectTextIntoID(\'['+value.title+']('+value.link+')\', \'gn_wiki_page_en_content\'); $(\'#gnLinkPanel\').close(); return false;">'+value.title+'</a></li>').appendTo('#gnLinkPanelResults<?php echo $rand ?>');
          });
        }
      });
      return false;
    });
  });
</script>




