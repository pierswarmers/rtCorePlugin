<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnAdminHelper defines some base helpers used in admin.
 *
 * @package    gumnut
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 */

/**
 * Displays a pretty boolean.
 *
 * @param boolean $boolean_value
 * @return string
 */
function gn_nice_boolean($boolean_value = false, $yes = 'yes', $no = 'no')
{
  return sprintf('<span class="ui-icon ui-icon-%s">%s</span>', $boolean_value ? 'check' : 'close', $boolean_value ? $yes : $no);
}

/**
 * Displays a pretty delete button.
 *
 * @param string $target
 * @return string
 */
function gn_button_delete($target)
{
  return gn_ui_button('delete', $target, 'trash', array('method' => 'post', 'confirm' => 'Are you sure?'));
}

/**
 * Displays a pretty delete button.
 *
 * @param string $target
 * @return string
 */
function gn_button_undelete($target)
{
  return gn_ui_button('undelete', $target, 'trash', array('method' => 'post'));
}

/**
 * Displays a pretty edit button.
 *
 * @param string $target
 * @return string
 */
function gn_button_edit($target)
{
  return gn_ui_button('edit', $target, 'pencil');
}

/**
 * Displays a pretty show button.
 *
 * @param string $target
 * @return string
 */
function gn_button_show($target)
{
  return gn_ui_button('show', $target, 'search');
}

/**
 * Displays a pretty button using jQuery UI.
 *
 * @param string $label
 * @param string $target
 * @param string $icon
 * @return string
 */
function gn_ui_button($label, $target, $icon, $options = array())
{
  $options['class'] = 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon';
  $content = sprintf('<span class="ui-button-icon-primary ui-icon ui-icon-%s"></span><span class="ui-button-text">%s</span>', $icon, $label);
  return link_to($content, $target, $options);
}

/**
 * Displays a tree administration panel.
 *
 * @param string $model
 * @param string $field
 * @param string $root
 * @return string
 */
function get_tree_manager($model, $field, $root = 0)
{
  if (!sfConfig::has('app_sfJqueryTree_withContextMenu'))
  {
    sfConfig::set('app_sfJqueryTree_withContextMenu', true);
  }

  sfContext::getInstance()->getResponse()->addStylesheet('/gnCorePlugin/vendor/jsTree/themes/default/style.css');
  sfContext::getInstance()->getResponse()->addJavascript('/gnCorePlugin/vendor/jquery/js/jquery.min.js');
  sfContext::getInstance()->getResponse()->addJavascript('/gnCorePlugin/vendor/jsTree/lib/jquery.cookie.js');
  sfContext::getInstance()->getResponse()->addJavascript('/gnCorePlugin/vendor/jsTree/jquery.tree.js');
  sfContext::getInstance()->getResponse()->addJavascript('/gnCorePlugin/vendor/jsTree/plugins/jquery.tree.cookie.js');

//  if (sfConfig::get('app_sfJqueryTree_withContextMenu'))
//  {
    sfContext::getInstance()->getResponse()->addJavascript('/gnCorePlugin/vendor/jsTree/plugins/jquery.tree.contextmenu.js');
//  }

  return get_component('gnTreeAdmin', 'manager', array('model' => $model, 'field' => $field, 'root' => $root));
}