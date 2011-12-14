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
 * Returns the Analytics integration code snippet.
 *
 * See: http://code.google.com/apis/analytics/docs/tracking/asyncTracking.html
 * 
 * @package    Reditype
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @param      string $web_property_id
 * @return     string
 */
function analytics($web_property_id = null)
{
  if(is_null($web_property_id) && !sfConfig::has('app_rt_analytics_web_property_id'))
  {
    return '';
  }

  $web_property_id = is_null($web_property_id) ? sfConfig::get('app_rt_analytics_web_property_id') : $web_property_id;

  $domain = '';

  if(sfConfig::has('app_rt_analytics_web_property_domain'))
  {
    $domain = "_gaq.push(['_setDomainName', '".sfConfig::get('app_rt_analytics_web_property_domain')."']);";
  }

  $string = <<< EOS
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '$web_property_id']);
  $domain
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

EOS;

  return $string;
}

