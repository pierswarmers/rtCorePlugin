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
class rtWidgetFormRating extends sfWidgetFormChoice
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
    parent::configure($options, $attributes);
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
      '/rtCorePlugin/vendor/jquery/js/jquery.ui.min.js'
    );
  }

  /**
   * Return the required stylesheets for this widget.
   *
   * @return array
   */
  public function getStylesheets()
  {
    return array('/rtCorePlugin/vendor/jquery/css/ui/jquery.ui.css' => 'screen');
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
    $script = <<<EOS
	<script>
	$(function() {
		var select = $( "select[name='rt_comment[rating]']" ).hide();
		var slider = $( "<div id='rating' style='display:inline-block; width:200px'></div>" ).insertAfter( select ).slider({
			min: 1,
			max: 11,
			range: "min",
			value: select[ 0 ].selectedIndex + 1,
			slide: function( event, ui ) {
              $("#ratingSelection").html(ui.value - 1);
              select[ 0 ].selectedIndex = ui.value - 1;
			}
		});
		select.change(function() {
          slider.slider( "value", this.selectedIndex + 1 );
		});
	});
	</script>
EOS;
    
    return '0/10 '. parent::render($name, $value, $attributes, $errors) . ' <span id="ratingSelection">10</span>/10' . $script;
  }
}
