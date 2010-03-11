<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnFormHelper defines some base helpers to construct gumnut specific forms.
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
 * @see gnMarkdown::toHTML()
 * @param strinf $markdown
 * @return string
 */
function render_form_row(sfFormField $widget, $options = array())
{
  $options['wide'] = isset($options['wide']) ? $options['wide'] : true;
  $options['space'] = isset($options['space']) ? $options['wide'] : false;
  $options['class'] = isset($options['class']) ? $options['class'] : 'gn-form-row';

  $is_checkbox = get_class($widget->getWidget()) === 'sfWidgetFormInputCheckbox';

  $label = $widget->renderLabel();

  if(!isset($options['format']))
  {
    if($is_checkbox)
    {
      $options['format'] = '<div class="%1$s checkbox"><label>%4$s %2$s</label> %3$s %5$s</div>';
      $label = $widget->renderLabelName();
    }
    else
    {
      $options['format'] = '<div class="%1$s standard">%2$s %3$s %4$s %5$s</div>';
    }
  }

  if($options['wide'] && !$is_checkbox)
  {
    $options['class'] .= ' gn-form-wide';
  }

  if($widget->hasError())
  {
    $options['class'] .= ' gn-error';
  }

  $html = sprintf(
    $options['format'],
    $options['class'], // 1
    $label,  // 2
    $widget->hasError() ? ' &rarr; '. $widget->renderError() : '',  // 3
    $widget->render(), // 4
    $widget->renderHelp()  // 5
  ) . "\n";

  return $html;
}

