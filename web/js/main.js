/*
 * Based on code by Scott Klarr
 *
 * http://www.scottklarr.com
 */


//inputCursorPositionStore = new Array();

function injectTextIntoCurrent(text) {injectTextIntoID(text, document.getElementById($("textarea").attr("id")))}

function injectTextIntoID(text, itemId) {
  if(document.selection) { // for ie
    if($("#gnLinkPanel").css("display") == "none") {
      $(itemId).focus();
    } else {
      var docId = document.getElementById(itemId);
      $(docId).focus();
    }
    var sel   = document.selection.createRange();
    sel.text  = text;
  } else if(itemId.selectionStart || itemId.selectionStart == '0') { 
    getItemPositions(itemId, text);
  } else {
    if(itemId.value == undefined) {
      itemId = document.getElementById($("textarea").attr("id"));
      $(itemId).focus();
      getItemPositions(itemId, text);
    } else {
      itemId.value  += text;
    }
  }
}

function getItemPositions(id, txt) {
  var startPos  = id.selectionStart;
  var endPos    = id.selectionEnd;
  id.value      = id.value.substring(0, startPos) + txt + id.value.substring(endPos, id.value.length);
}


/*
 * Inject a replacement token into a given dom element.
 */
setReplacementToken = function(itemId)
{
  injectTextIntoID('[-[-]-]', itemId);
}

/*
 * Inject some text over a token.
 */
updateReplacementToken = function(title,link, itemId)
{
  if(title == '' && link == '')
  {
    $(itemId).val($(itemId).val().replace(/\[\-\[/g, ''));
    $(itemId).val($(itemId).val().replace(/[\-]+\]\-\]/g, ''));
  }
  else
  {
    $(itemId).val($(itemId).val().replace(/\[\-\[/g, '['));
    $(itemId).val($(itemId).val().replace(/[\-]+\]\-\]/g, title+']('+link+')'));
    $(itemId).val($(itemId).val().replace(/\]\-\]/g, ']('+link+')'));
  }
}

/*
 * Enable the link panel.
 */
function enableLinkPanel(inputId, buttonId, updatePanel, updateUrl, targetTextField)
{
  $(inputId).keydown(function(event) {
    if (event.keyCode == '13') {
      triggerLinkPanelLookup(inputId, updatePanel, updateUrl, targetTextField);
      event.preventDefault();
    }
  });
  $(buttonId).click(function() {
    triggerLinkPanelLookup(inputId, updatePanel, updateUrl, targetTextField);
  });
}
/*
 * Trigger the search / lookup for the link panel
 */
function triggerLinkPanelLookup(inputId, updatePanel, updateUrl, targetTextField)
{
  $.ajax({
    url: updateUrl,
    dataType: 'json',
    data: {q : $(inputId).attr('value')},
    success: function(data) {
      $(updatePanel).html('');
      $.each(data.items, function(index, value) {
        //$('<li><a href="#" onclick="updateReplacementToken(\'['+value.title+']('+value.link+')\', \''+targetTextField+'\'); return false;">'+value.title+'</a></li>').appendTo(updatePanel);
        $('<li><a href="#" onclick="updateReplacementToken(\''+value.title+'\',\''+value.link+'\', \''+targetTextField+'\'); return false;">'+value.title+'</a></li>').appendTo(updatePanel);
      });
    }
  });
}