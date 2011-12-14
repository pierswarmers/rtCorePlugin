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
 * Displays a pretty boolean.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      boolean $boolean_value
 * @return     string
 */
function rt_nice_boolean($boolean_value = false, $yes = 'yes', $no = 'no')
{
  return sprintf('<span class="ui-icon ui-icon-%s">%s</span>', $boolean_value ? 'check' : 'close', $boolean_value ? $yes : $no);
}

/**
 * Displays a pretty delete button.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $target
 * @return     string
 */
function rt_button_delete($target)
{
  return rt_ui_button('delete', $target, 'trash', array('method' => 'post', 'confirm' => 'Are you sure?'));
}

/**
 * Displays a pretty delete button.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $target
 * @return     string
 */
function rt_button_undelete($target)
{
  return rt_ui_button('undelete', $target, 'trash', array('method' => 'post'));
}

/**
 * Displays a pretty edit button.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $target
 * @return     string
 */
function rt_button_edit($target)
{
  return rt_ui_button('edit', $target, 'pencil');
}

/**
 * Displays a pretty boolean button.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $target
 * @return     string
 */
function rt_button_boolean($target,$title = 'enable')
{
  return rt_ui_button($title, $target, 'check');
}

/**
 * Displays a pretty show button.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $target
 * @return     string
 */
function rt_button_show($target)
{
  return rt_ui_button('show', $target, 'search');
}

/**
 * Displays a pretty button using jQuery UI.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $label
 * @param      string $target
 * @param      string $icon
 * @return     string
 */
function rt_ui_button($label, $target, $icon, $options = array())
{
  $options['class'] = 'new ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary';
  $content = sprintf('<span class="ui-button-icon-primary ui-icon ui-icon-%s"></span><span class="ui-button-text">%s</span>', $icon, $label);
  return link_to($content, $target, $options);
}

/**
 * Displays a tree administration panel.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $model
 * @param      string $field
 * @param      string $root
 * @return     string
 */
function get_tree_manager($model, $field, $root = 0)
{
  if (!sfConfig::has('app_sfJqueryTree_withContextMenu'))
  {
    sfConfig::set('app_sfJqueryTree_withContextMenu', true);
  }

  sfContext::getInstance()->getResponse()->addStylesheet('/rtCorePlugin/vendor/jsTree/themes/default/style.css');
  sfContext::getInstance()->getResponse()->addJavascript('/rtCorePlugin/vendor/jquery/js/jquery.min.js');
  sfContext::getInstance()->getResponse()->addJavascript('/rtCorePlugin/vendor/jsTree/lib/jquery.cookie.js');
  sfContext::getInstance()->getResponse()->addJavascript('/rtCorePlugin/vendor/jsTree/jquery.tree.js');
  sfContext::getInstance()->getResponse()->addJavascript('/rtCorePlugin/vendor/jsTree/plugins/jquery.tree.cookie.js');
  sfContext::getInstance()->getResponse()->addJavascript('/rtCorePlugin/vendor/jsTree/plugins/jquery.tree.contextmenu.js');

  return get_component('rtTreeAdmin', 'manager', array('model' => $model, 'field' => $field, 'root' => $root));
}