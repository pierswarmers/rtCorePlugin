/*
 *
 *
 */
function enablePublishToggle(url)
{
    var enableTxt = 'enable';
    var disableTxt = 'disable';

    $("td.rt-admin-publish-toggle span").click(function(){
      if($(this).hasClass('loading')) {
        return;
      }

      $(this).removeClass('ui-icon-check');
      $(this).removeClass('ui-icon-close');

      $(this).addClass('loading');

      // ajax call to toggle action
      var commentId = $(this).next('div').html();
      var spanElement = $(this);

      $.ajax({
        url: url,
        data: { id: commentId },
        success: function(data) {
          spanElement.removeClass('loading');
          if(data == 'activated') {
            spanElement.addClass('ui-icon-check');
          } else {
            spanElement.addClass('ui-icon-close');
          }
        }
      });
    });
}






function enableTogglePanels()
{
  $('.rt-admin-toggle-panel h2').click(function(){
    $(this).next('.rt-admin-toggle-panel-content').toggle('blind');
  }).next('.rt-admin-toggle-panel-content').find('.error_list').parents('.rt-admin-toggle-panel-content').toggle();
}

// rt-admin-toggle-panel



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
            $(updatePanel).show();
            $(updatePanel).html('');
            $.each(data.items, function(index, value) {
                if(value.placeholder == ''){
                  $('<li><a href="#" class="close" onclick="$.markItUp({openWith: \'[\',closeWith:\']('+value.link+')\',placeHolder:\''+value.title.replace(/\'/g, "&rsquo;")+'\' }); $(\'.rt-modal-panel\').dialog(\'close\'); return false;">'+value.title+'</a></li>').appendTo(updatePanel);
                }
                else
                {
                  $('<li><a href="#" class="close" onclick="$.markItUp({openWith: \'\',placeHolder:\''+value.placeholder+'\' }); $(\'.rt-modal-panel\').dialog(\'close\'); return false;">'+value.title+'</a></li>').appendTo(updatePanel);
                }
            });
        }
    });
}

/*
 * Run global methods.
 */
$(function() {
  enableTogglePanels();
});