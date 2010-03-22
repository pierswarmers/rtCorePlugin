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
  $options['markdown'] = isset($options['markdown']) ? $options['markdown'] : false;

  $content = '';

  if($options['markdown'])
  {
    ob_start();
    include_partial('gnSearch/ajaxForm', array('form' => new gnSearchForm(), 'targetId' => 'gn_wiki_page_en_content'));
    $content = ob_get_contents();
    ob_end_clean();
  }
  
  $is_checkbox = get_class($widget->getWidget()) === 'sfWidgetFormInputCheckbox';

  $html = '';

  if($is_checkbox)
  {
    $html = sprintf(
      '<div class="%1$s checkbox"><label>%4$s %6$s %2$s</label> %3$s %5$s</div>',
      $options['class'], // 1
       $widget->renderLabelName(),  // 2
      $widget->hasError() ? ' &rarr; '. $widget->renderError() : '',  // 3
      $widget->render(), // 4
      $widget->renderHelp(),  // 5
      $content// 6
    );
  }
  else
  {
    $html = sprintf(
      '<div class="%s standard"><label for="%s">%s <span class="error">%s</span></label> %s %s %s</div>',
      $options['class'],
      $widget->renderId(),
      $widget->renderLabelName(),
      $widget->hasError() ? ' &rarr; '. $widget->renderError() : '',
      $widget->render(),
      $widget->renderHelp(),
      $content
    );
  }

  return $html . "\n";
}

