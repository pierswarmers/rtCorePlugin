<?php
$site =  Doctrine::getTable('rtSite')->find($id);
if($site)
{
  echo sprintf('<span class="rt-site-badge rt-site-badge-%s">%s</span>', $site->getReferenceKey(),$site->getTitle());
}