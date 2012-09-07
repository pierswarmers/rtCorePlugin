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
 * Converts a mardown string into HTML
 *
 * sfWidgetFormTextarea
 * sfWidgetFormInput
 * sfWidgetFormInputCheckbox
 * 
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      sfFormField $widget
 * @param      array $options
 * @return     string
 */
function render_form_row(sfFormField $widget, $options = array())
{
  $options['wide'] = isset($options['wide']) ? $options['wide'] : true;
  $options['space'] = isset($options['space']) ? $options['wide'] : false;
  $options['class'] = isset($options['class']) ? $options['class'] : 'rt-form-row';
  $options['markdown'] = isset($options['markdown']) ? $options['markdown'] : false;

  $content = '';

  if($options['markdown'])
  {
    ob_start();
    include_partial('rtSearch/ajaxForm', array('form' => new rtSearchForm(), 'targetId' => 'rt_wiki_page_en_content'));
    $content = ob_get_contents();
    ob_end_clean();
  }

  $html = '';

  $widget->renderHelp();
  $help = $widget->getParent()->getWidget()->getHelp($widget->getName());

  if(get_class($widget->getWidget()) === 'sfWidgetFormInputCheckbox')
  {
    $html = sprintf(
      '<tr class="%1$s checkbox"><th><label for="%6$s">%2$s</label></th><td>%4$s <div class="help">%5$s</div> %3$s</td></tr>',
      $options['class'], // 1
      $widget->renderLabelName(),  // 2
      $widget->hasError() ? $widget->renderError() : '',  // 3
      $widget->render(), // 4
      $help, // 5
      $widget->renderId() // 6
    );
  }
  elseif(get_class($widget->getWidget()) === 'sfWidgetFormChoice')
  {
    $html = sprintf(
      '<tr class="%1$s checkbox"><th><label>%2$s</label></th><td>%4$s <div class="help">%5$s</div> %3$s</td></tr>',
      $options['class'], // 1
      $widget->renderLabelName(),  // 2
      $widget->hasError() ? $widget->renderError() : '',  // 3
      $widget->render(), // 4
      $help // 5
    );
  }
  else
  {
    
    $html = sprintf(
      '<tr class="%1$s standard"><th><label for="%2$s">%3$s</label></th><td>%4$s %5$s <div class="help">%6$s</div>%7$s</tr>',
      $options['class'], // 1
      $widget->renderId(), // 2
      $widget->renderLabelName() . get_class($widget->getWidget()), // 3
      $widget->hasError() ? '<span class="error">' . $widget->renderError() . '</span>' : '', // 4
      $widget->render(), // 5
      $help, // 6
      $content // 7
    );
  }

  return $html . "\n";
}

