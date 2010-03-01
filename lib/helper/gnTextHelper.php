<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnTextHelper defines some base helpers.
 *
 * @package    gumnut
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 */

/**
 * Converts a mardown string into HTML
 *
 * @see gnMarkdown::toHTML()
 * @param strinf $markdown
 * @return string
 */
function markdown_to_html($markdown)
{
  return gnMarkdown::toHTML($markdown);
}
