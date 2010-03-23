

/*
 * Enable the link panel.
 */
function enableLinkPanel(inputId, buttonId, updatePanel, updateUrl, targetTextField)
{
  $(inputId).keydown(function(event) {
    if (event.keyCode == '13') {
      triggerLinkPanelLookup(inputId, updatePanel, updateUrl);
      event.preventDefault();
    }
  });
  $(buttonId).click(function() {
    triggerLinkPanelLookup(inputId, updatePanel, updateUrl);
    return false;
  });
}
/*
 * Trigger the search / lookup for the link panel
 */
function triggerLinkPanelLookup(inputId, updatePanel, updateUrl)
{
  $.ajax({
    url: updateUrl,
    dataType: 'json',
    data: {q : $(inputId).attr('value')},
    success: function(data) {
      $(updatePanel).html('');
      $.each(data.items, function(index, value) {
        $('<li><a href="#" class="close" onclick="$.markItUp({openWith: \'[\',closeWith:\']('+value.link+')\',placeHolder:\''+value.title+'\' }); $(\'.gn-modal-panel\').overlay().close(); return false;">'+value.title+'</a></li>').appendTo(updatePanel);
      });
    }
  });
}