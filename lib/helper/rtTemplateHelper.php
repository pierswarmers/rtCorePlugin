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
 * Return status if string is empty
 * Can be used for snippets, partials, components, etc.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 * @param      string $string String to check
 * @return     boolean
 */
function rt_is_string_empty($string)
{
  return in_array(trim(strip_tags($string)), array('', 'Edit', null));
}

/**
 * Include a snippet by a given $name value - this will be global.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $name     Collection and cache name
 * @param      string $default  Default text
 * @return     string
 */
function rt_get_snippet($name, $default = '')
{
  return include_component('rtSnippet','snippetPanel', array('collection' => $name, 'sf_cache_key' => $name, 'default' => $default));
}

/**
 * Proxy method for: rt_get_snippet()
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $name     Collection and cache name
 * @param      string $default  Default text
 * @return     string
 */
function rt_get_global_snippet($name, $default = '')
{
  return rt_get_snippet($name, $default);
}

/**
 * Include a snippet by a given $name value - will be set to the specific module and all actions within it.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $name     Collection and cache name
 * @param      string $default  Default text
 * @return     string
 */
function rt_get_module_snippet_for_module($name, $default = '')
{
  $name .= '-' . sfContext::getInstance()->getRequest()->getParameter('module');
  return rt_get_snippet($name, $default);
}

/**
 * Include a snippet by a given $name value - will be set to a specific module and action.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $name     Collection and cache name
 * @param      string $default  Default text
 * @return     string
 */
function rt_get_snippet_for_action($name, $default = '')
{
  $name .= '-' . sfContext::getInstance()->getRequest()->getParameter('module');
  $name .= '-' . sfContext::getInstance()->getRequest()->getParameter('action');
  return rt_get_snippet($name, $default);
}

/**
 * Include a search form with and input field and an button
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 * @return     string
 */
function rt_get_search_form()
{
  return include_partial('rtSearch/form', array('form' => new rtSearchForm()));
}

/**
 * Include a tag cloud
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 * @return     string
 */
function rt_get_tag_cloud()
{
  return include_component('rtTag', 'cloud');
}

/**
 * Include a list of the latest blog posts (news)
 * Default $number is 5
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 * @param      integer $number Number of posts shown
 * @return     string
 */
function rt_get_blog_latest($number = 5)
{
  return include_component('rtBlogPage', 'latest', array('limit' => $number));
}

/**
 * Include a list of archived blog posts
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 * @return     string
 */
function rt_get_blog_archive()
{
  return include_component('rtBlogPage', 'archive');
}

/**
 * Include a site navigation
 * $contextual Decides if the navigation reacts to the current URI or not.
 *             Defaults to false, so that reacts to URI.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 * @param      boolean $contextual True or false. If true, current URI alters the navigation
 * @return     string
 */
function rt_get_nav_full($contextual = true)
{
  $options = array('render_full' => !$contextual);

  $nav = include_component('rtSitePage', 'navigation', array('options' => $options));

  return $nav;
}

/**
 * Include a site navigation: First level elements only
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 * @return     string
 */
function rt_get_nav_primary()
{
  $options = array('render_full' => true,
                   'limit_upper' => 1);

  $nav = include_component('rtSitePage', 'navigation', array('options' => $options));
  
  return $nav;
}

/**
 * Include a site navigation: Second level elements only
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 * @return     string
 */
function rt_get_nav_secondary()
{
  $options = array('render_full' => false,
                   'include_root' => false,
                   'limit_lower' => 2,
                   'limit_upper' => 2);

  $nav = include_component('rtSitePage', 'navigation', array('options' => $options));

  return $nav;
}

/**
 * Include a site navigation: Defined range of levels
 *
 * If only $lover defined then everthing of that level and lower is shown
 * If $lower and $upper are defined then only the items in that range are shown
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 * @param      integer $lower Min. lower level to display
 * @param      boolean $contextual True or false. If true, current URI alters the navigation
 * @param      integer $upper Max. upper level to display
 * @return     string
 */
function rt_get_nav_range($lower, $contextual = true, $upper = null)
{
  $options = array('render_full' => !$contextual,
                   'include_root' => ($lower <= 1) ? true : false,
                   'limit_lower' => $lower,
                   'limit_upper' => $upper);

  // Unset upper if not used
  if(is_null($upper))
  {
    unset($options['limit_upper']);
  }

  $nav = include_component('rtSitePage', 'navigation', array('options' => $options));

  return $nav;
}