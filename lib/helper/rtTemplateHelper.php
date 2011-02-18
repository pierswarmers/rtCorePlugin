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
 * Include a snippet by a given $name value - this will be global.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param  string $name
 * @return string
 */
function rt_get_snippet($name)
{
  return include_component('rtSnippet','snippetPanel', array('collection' => $name,'sf_cache_key' => $name));
}

/**
 * Proxy method for: rt_get_snippet()
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param  string $name
 * @return string
 */
function rt_get_global_snippet($name)
{
  return rt_get_snippet($name);
}

/**
 * Include a snippet by a given $name value - will be set to the specific module and all actions within it.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param  string $name
 * @return string
 */
function rt_get_module_snippet_for_module($name)
{
  $name .= '-' . sfContext::getInstance()->getRequest()->getParameter('module');
  return rt_get_snippet($name);
}

/**
 * Include a snippet by a given $name value - will be set to a specific module and action.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param  string $name
 * @return string
 */
function rt_get_snippet_for_action($name)
{
  $name .= '-' . sfContext::getInstance()->getRequest()->getParameter('module');
  $name .= '-' . sfContext::getInstance()->getRequest()->getParameter('action');
  return rt_get_snippet($name);
}

