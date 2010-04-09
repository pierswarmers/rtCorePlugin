<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnSocialNetworkingHelper defines some integration helpers for some common social networking tools.
 *
 * @package    gumnut
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 */

/**
 * Returns the AddThis integration code snippet.
 *
 * See: http://www.addthis.com
 * 
 * @param string $username
 * @return string
 */
function add_this_badge($options = null)
{
  if(!sfConfig::has('app_gn_addthis_username'))
  {
    return '';
  }
  
  $string = '';
  $username = sfConfig::get('app_gn_addthis_username');
  $option_string = '';
  
  if(!is_null($options))
  {
    $options['url'] = isset($options['url']) ? $options['url'] : '';
    $options['title'] = isset($options['title']) ? $options['title'] : '';
    $options['description'] = isset($options['description']) ? $options['description'] : '';
    $option_string = sprintf(' addthis:url="%s" addthis:title="%s" addthis:description="%s" ', $options['url'], $options['title'], $options['description']);
  }

  if(sfConfig::get('app_gn_addthis_as_button', true))
  {
    $string = <<< EOS
<a class="addthis_button" $option_string href="http://www.addthis.com/bookmark.php?v=250&amp;username=$username"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0; float:left; margin-right:10px;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=$username"></script>
EOS;
  }
  else
  {
    $string = <<< EOS
<div class="addthis_toolbox addthis_default_style">
<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=$username" style="text-decoration: none;" class="addthis_button_compact"$option_string>Share</a>
<span class="addthis_separator">|</span>
<a class="addthis_button_facebook"></a>
<a class="addthis_button_myspace"></a>
<a class="addthis_button_google"></a>
<a class="addthis_button_twitter"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=$username"></script>
EOS;
  }

  return $string;
}

