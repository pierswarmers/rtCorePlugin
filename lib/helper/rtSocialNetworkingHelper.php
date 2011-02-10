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
 * Return a badge
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      array $options
 * @return     string
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
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      array $options
 * @return     string
 */
function get_addthis_badge($options = null)
{
  $string = '';
  $username = sfConfig::get('app_rt_social_networking_service_username');
  $option_string = '';

  use_dynamic_javascript('http://s7.addthis.com/js/250/addthis_widget.js#username=$username');

  if(!is_null($options))
  {
    $options['url'] = isset($options['url']) ? $options['url'] : '';
    $options['title'] = isset($options['title']) ? $options['title'] : '';
    $options['description'] = isset($options['description']) ? $options['description'] : '';
    $option_string = sprintf(' addthis:url="%s" addthis:title="%s" addthis:description="%s" ', $options['url'], $options['title'], $options['description']);
  }

  $string = <<< EOS
<a class="addthis_button" $option_string href="http://www.addthis.com/bookmark.php?v=250&amp;username=$username">Share</a>
EOS;

  return $string;
}


/**
 * Returns the ShareThis integration code snippet.
 *
 * See: http://www.sharethis.com
 *
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      array $options
 * @return     string
 */
function get_sharethis_badge($options = null)
{
  $string = '';
  $username = sfConfig::get('app_rt_social_networking_service_username','');
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
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      array $options
 * @return     string
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

/**
 * Returns the share by email code snippet
 * 
 * @param  Array $options
 * @return Mixed
 */
function get_share_badge($object)
{
  $enabled = sfConfig::get('app_rt_share_email',true);
  if($enabled)
  {
    $object = $object->getRawValue() ? $object->getRawValue() : $object;

    // Tags
    $div_start = '<div id="share-button">';
    $div_end   = '</div>';

    $link  = link_to('Share', url_for('rt_social_email',array('model' => get_class($object),'model_id' => $object->getId())));
    $share = $div_start.$link.$div_end;

    return $share;
  }
  return;
}

/**
 * Return Facebook:Like code snippet
 *
 * @see    http://developers.facebook.com/docs/reference/plugins/like
 * @return Mixed
 */
function get_facebook_like_badge()
{
  $enabled = sfConfig::get('app_rt_share_facebook_like',true);
  if($enabled)
  {
    // Facebook like parameters
    $fb_script_url  = 'http://connect.facebook.net/en_US/all.js#xfbml=1';  // Facebook like script URL
    $fb_layout      = 'button_count';                                      // Parameters: standard, button_count or box_count
    $fb_faces       = 'false';                                             // True or false
    $fb_width       = '100';
    $fb_colorscheme = 'light';                                             // Parameters: light or dark

    // Site specific parameters
    $site_url      = rtSiteToolkit::getCurrentDomain(null, true) . rtSiteToolkit::getRequestUri();   // Page URL

    // Tags
    $script_start   = sprintf('<script src="%s">',$fb_script_url);
    $script_end     = '</script>';
    $fb_tag_start   = sprintf('<fb:like href="%s" layout="%s" show_faces="%s" width="%s" colorscheme="%s">',$site_url,$fb_layout,$fb_faces,$fb_width,$fb_colorscheme);
    $fb_tag_end     = '</fb:like>';

    return $script_start.$script_end.$fb_tag_start.$fb_tag_end;
  }
  return;
}

/**
 * Return Twitter:Tweet code snippet
 *
 * @see    http://twitter.com/about/resources/tweetbutton
 * @return Mixed
 */
function get_tweet_badge()
{
  $enabled = sfConfig::get('app_rt_share_tweet',true);
  if($enabled)
  {
    // Twitter url parameters
    $twitter_url           = 'http://twitter.com/share';     // Twitter share URL
    $twitter_widget_js_url = 'http://platform.twitter.com/widgets.js';

    // Site url and configuration parameters
    $data_url      = rtSiteToolkit::getCurrentDomain(null, true) . rtSiteToolkit::getRequestUri();   // Page URL
    $data_count    = 'horizontal';                   // Parameters: none, vertical or horizontal
    $tweet_text    = 'Tweet';
    $link_class    = 'twitter-share-button';

    // Tags
    $script_start  = sprintf('<script type="text/javascript" src="%s">',$twitter_widget_js_url);
    $script_end    = '</script>';
    $link_start    = sprintf('<a href="%s" class="%s" data-url="%s" data-count="%s">',$twitter_url,$link_class,$data_url,$data_count);
    $link_end      = '</a>';

    return $link_start.$tweet_text.$link_end.$script_start.$script_end;
  }
  return;
}