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
 * Converts a markdown string (tags removed) into HTML
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param string $string
 * @return string
 */
function markdown_to_html_safe($string, $object = null)
{
  $rt_string = new rtTypeString(strip_tags($string), array('object' => $object));
  return $rt_string->transform();
}

/**
 * Converts a markdown string into HTML
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param string $string
 * @return string
 */
function markdown_to_html($string, $object = null, $summary = false)
{
  $rt_string = new rtTypeString($string, array('object' => $object));
  return $rt_string->transform();
}