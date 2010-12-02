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
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $email The email address
 * @param      string $s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param      string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param      string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param      boolean $img True to return a complete IMG tag False for just the URL
 * @param      array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return     string containing either just a URL or a complete image tag
 * @source     http://gravatar.com/site/implement/images/php/
 */
use_helper('Tag');

function gravatar_for( $email, $s = 80, $d = 'mm', $r = 'g', $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";

	return image_tag($url, array('height' => $s, 'width' => $s));
}