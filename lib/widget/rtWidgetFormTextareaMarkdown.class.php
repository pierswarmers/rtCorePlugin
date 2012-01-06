<?php
/*
 * This file is part of the Reditype package.
 *
 * (c) 2009-2010 digital Wranglers <info@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtWidgetFormTextareaMarkdown
 *
 * @package    rtCorePlugin
 * @subpackage widget
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtWidgetFormTextareaMarkdown extends sfWidgetFormTextarea
{
  /**
   * Constructor
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('config', '');
  }

  /**
   * Return the required javascripts for this widget.
   *
   * @return array
   */
  public function getJavaScripts()
  {
    return array(
      '/rtCorePlugin/vendor/jquery/js/jquery.min.js',
      '/rtCorePlugin/js/admin-main.js',
      '/rtCorePlugin/vendor/markitup/jquery.markitup.pack.js',
      '/rtCorePlugin/js/admin-markitup.js'
    );
  }

  /**
   * Return the required stylesheets for this widget.
   *
   * @return array
   */
  public function getStylesheets()
  {
    return array(
      '/rtCorePlugin/css/admin-markitup.css' => 'screen'
    );
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $textarea = parent::render($name, $value, $attributes, $errors);

    if (!isset($attributes['id']))
    {
      $attributes['id'] = $this->generateId($name, isset($attributes['value']) ? $attributes['value'] : null);
    }

    $rand = rand();
    $id = $attributes['id'];
    $uri = sfContext::getInstance()->getController()->genUrl('@rt_search_ajax?sf_format=json');
    $uri_snippet = sfContext::getInstance()->getController()->genUrl('@rt_search_ajax?models=rtSnippet&sf_format=json');

    $js = sprintf(<<<EOF
<div id="rtLinkPanel$rand" class="rt-modal-panel $id-link rtLinkPanel"  title="Create a new link">

  <fieldset><legend>Build your own link to any URL</legend>
  <p class="inline-text-form-row inline-text-form-row-simple">
    [ <input type="text" name="linkText" id="linkText$rand" value="Your links text" /> ]
    ( <input type="text" name="linkUrl" id="linkUrl$rand" value="http://example.com/" /> )
    <button class="rtLinkPanelInsertButton">Insert Link</button>
  </p>
  </fieldset>
  <fieldset style="margin-bottom:none;"><legend>Or, find an existing page to link to</legend>
  <p class="inline-text-form-row"><strong>Enter search Terms:</strong>
      <input type="text" name="q" id="rtLinkPanelQuery$rand" value="" />
      <button type="submit" class="rtPanelSearchButton" id="rtLinkPanelId$rand">Search</button>
  </p>
  <ul id="rtLinkPanelResults$rand" class="inner-panel results-panel">&nbsp;</ul>
  </fieldset>
</div>

<div id="rtSnippetPanel$rand" class="rt-modal-panel $id-snippet rtSnippetPanel"  title="Create a snippet include">
  <fieldset style="margin-bottom:none;"><legend>Find a snippet to include in your content</legend>
  <p class="inline-text-form-row"><strong>Enter search Terms:</strong>
      <input type="text" name="q" id="rtSnippetPanelQuery$rand" value="" />
      <button type="submit" class="rtPanelSearchButton" id="rtSnippetPanelId$rand">Search</button>
  </p>
  <ul id="rtSnippetPanelResults$rand" class="inner-panel results-panel">&nbsp;</ul>
  </fieldset>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    $('.rtLinkPanelInsertButton').button({
      icons: {
        primary: 'ui-icon-link'
      }
    });

    $('.rtLinkPanelInsertButton').click(function(){
      $.markItUp({openWith: '[',closeWith:']('+ $("#linkUrl$rand").val() +')',placeHolder:''+ $("#linkText$rand").attr('value') +'' });
      $('.rt-modal-panel').dialog('close');
      return false;
    });

    $('.rtPanelSearchButton').button({
      icons: {
        primary: 'ui-icon-search'
      }
    });

    enableLinkPanel(
      '#rtLinkPanelQuery$rand',
      '#rtLinkPanelId$rand',
      '#rtLinkPanelResults$rand',
      '$uri',
      '#$id'
    );
    
    enableLinkPanel(
      '#rtSnippetPanelQuery$rand',
      '#rtSnippetPanelId$rand',
      '#rtSnippetPanelResults$rand',
      '$uri_snippet',
      '#$id'
    );

    $('#%s').markItUp(rtMarkdownSettings);
  });
</script>
EOF
    ,
      $attributes['id']
    );
    
    return $js.$textarea;
  }
}
