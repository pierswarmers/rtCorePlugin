<?php

use_helper('I18N');
$rt_site = rtSiteToolkit::getCurrentSite();

?>
<?php if (sfConfig::has('app_rt_email_signature_html')): ?>
<p><?php echo sfConfig::get('app_rt_email_signature_html', '') ?></p>
<?php elseif($rt_site): ?>
<p>Many thanks, <?php echo $rt_site->getTitle() ?></p>
<?php endif; ?>