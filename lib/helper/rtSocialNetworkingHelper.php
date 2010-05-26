<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtSocialNetworkingHelper defines some integration helpers for some common social networking tools.
 *
 * @package    gumnut
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 */

function get_social_networking_badge($options = null)
{
  if(sfConfig::get('app_rt_social_networking_service') === 'tweetmeme')
  {
    return get_tweetmeme_badge($options);
  }

  if(!sfConfig::has('app_rt_social_networking_service') || !sfConfig::has('app_rt_social_networking_service_username'))
  {
    return '';
  }

  if(sfConfig::get('app_rt_social_networking_service') === 'addthis')
  {
    return get_addthis_badge($options);
  }

  if(sfConfig::get('app_rt_social_networking_service') === 'sharethis')
  {
    return get_sharethis_badge($options);
  }
}

/**
 * Returns the AddThis integration code snippet.
 *
 * See: http://www.addthis.com
 * 
 * @param string $username
 * @return string
 */
function get_addthis_badge($options = null)
{
  $string = '';
  $username = sfConfig::get('app_rt_social_networking_service_username');
  $option_string = '';
  
  if(!is_null($options))
  {
    $options['url'] = isset($options['url']) ? $options['url'] : '';
    $options['title'] = isset($options['title']) ? $options['title'] : '';
    $options['description'] = isset($options['description']) ? $options['description'] : '';
    $option_string = sprintf(' addthis:url="%s" addthis:title="%s" addthis:description="%s" ', $options['url'], $options['title'], $options['description']);
  }

  $string = <<< EOS
<a class="addthis_button" $option_string href="http://www.addthis.com/bookmark.php?v=250&amp;username=$username"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0; float:left; margin-right:10px;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=$username"></script>
EOS;

  return $string;
}

/**
 * Returns the ShareThis integration code snippet.
 *
 * See: http://www.sharethis.com
 *
 * @return string
 */
function get_sharethis_badge($options = null)
{
  $string = '';
  $username = sfConfig::get('app_rt_social_networking_service_username');
  $option_string = '';
  use_javascript('http://w.sharethis.com/button/sharethis.js#publisher='.$username);
  
  if(!is_null($options))
  {
    $options['url'] = isset($options['url']) ? $options['url'] : '';
    $options['title'] = isset($options['title']) ? $options['title'] : '';
    $options['description'] = isset($options['description']) ? $options['description'] : '';
    $option_string = sprintf(' url="%s", title="%s", summary="%s" ', $options['url'], $options['title'], $options['description']);
    $option_string = sprintf('{ url: "%s", title: "%s", summary: "%s" }', $options['url'], $options['title'], $options['description']);
  }

  $string = <<< EOS
<script language="javascript" type="text/javascript">
	SHARETHIS.addEntry($option_string, {button:true} );
</script>
EOS;

  return $string;
}

/**
 * Returns the TweetMeme integration code snippet.
 *
 * Currently under development, will always return an empty string.
 * 
 * See: http://www.tweetmeme.com
 *
 * @return string
 */
function get_tweetmeme_badge($options = null)
{
  return '';
  
  $option_string = '';

  $string = '';

  if(isset($options['url']))
  {
    $url = $options['url'];
    $string = <<< EOS
<script type="text/javascript">
tweetmeme_url = '$url';
tweetmeme_style = 'compact';
</script>
EOS;
  }

  $string .= <<< EOS
<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
EOS;

  return $string;
}

