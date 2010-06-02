<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtFormHelper defines some base helpers to construct gumnut specific forms.
 *
 * @package    gumnut
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 */

/**
 * Converts a mardown string into HTML
 *
 * sfWidgetFormTextarea
 * sfWidgetFormInput
 * sfWidgetFormInputCheckbox
 *
 * @see rtMarkdown::toHTML()
 * @param strinf $markdown
 * @return string
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
  
  $is_checkbox = get_class($widget->getWidget()) === 'sfWidgetFormInputCheckbox';

  $html = '';

  $widget->renderHelp();

  if($is_checkbox)
  {
    $html = sprintf(
      '<tr class="%1$s checkbox"><th><label for="%6$s">%2$s</label></th><td><label>%4$s %5$s</label> %3$s</td></tr>',
      $options['class'], // 1
      $widget->renderLabelName(),  // 2
      $widget->hasError() ? $widget->renderError() : '',  // 3
      $widget->render(), // 4
      $widget->getParent()->getWidget()->getHelp($widget->getName()), // 5
      $widget->renderId() // 6
    );
  }
  else
  {
    $html = sprintf(
      '<tr class="%1$s standard"><th><label for="%2$s">%3$s</label></th><td>%4$s %5$s %6$s %7$s</td></tr>',
      $options['class'], // 1
      $widget->renderId(), // 2
      $widget->renderLabelName(), // 3
      $widget->hasError() ? '<span class="error">' . $widget->renderError() . '</span>' : '', // 4
      $widget->render(), // 5
      $widget->renderHelp(), // 6
      $content // 7
    );
  }

  return $html . "\n";
}

