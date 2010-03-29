<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnDateHelper provides some display logic for handling date representations.
 *
 * @package    gumnut
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 */

use_helper('I18N', 'Date');

/**
 * Creates a nicer date display using an abbreviation tag.
 *
 * @param string $date_string
 * @param string $culture
 * @return string
 */

function time_ago_in_words_abbr($date_string, $culture = 'en')
{
  return sprintf('<abbr title="%s">%s %s</abbr>', format_date($date_string, 'U', $culture), time_ago_in_words(strtotime($date_string)), __('ago'));
}