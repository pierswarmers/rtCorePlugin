<?php

require_once(dirname(__FILE__).'/../../rtContact/lib/BasertContactActions.class.php');


/*
 * This file is part of the Reditype package.
 *
 * (c) 2009-2010 digital Wranglers <info@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertDefaultActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertDefaultActions extends BasertContactActions
{
    public function preExecute()
    {
        sfConfig::set('app_rt_node_title', 'Error');
        rtTemplateToolkit::setFrontendTemplateDir();
        parent::preExecute();
    }

    public function executeError404(sfWebRequest $request)
    {

    }

    public function executeNotify404(sfWebRequest $request)
    {
        $site = rtSiteToolkit::getCurrentSite();
        $target_email = $site->getAdminEmailAddress();

        $title = '404: Missing page was found by a site visitor';

        $message  = '<p>A visitor to your site found a missing page (know as a "404 error") and opted to let you know.</p>';
        $message .= '<p>The missing page had the following URL:</p>';
        $message .= sprintf('<p>%s</p>', $request->getGetParameter('url'));

        if($request->hasParameter('referer') && $request->getParameter('referer') !== '')
        {
            $message .= '<p>They appear to have been directed to that page from:</p>';
            $message .= sprintf('<p>%s</p>', $request->getGetParameter('referer'));
        } else {
            $message .= '<p>Unfortunately it was\'t possible for Reditype to detect how that visitor picked up that location.</p>';
        }

        $url = rtSiteToolkit::getCurrentDomain(null, true) . '/rtSiteAdmin/edit/id/' . $site->getId();

        $message .= <<<EOS

<p><strong>What can be done?<strong></p>
<p>Broken links should be corrected if you have control of the referring page</p>
<p>Pages that have been moved can have redirects configured in Site Administration > Edit > Advanced > HTTP Redirects (YAML)</p>
<p>For example:</p>
<p style="font-family: 'Courier New', Courier, monospace; display: block; padding: 10px; border: 1px solid #ccc;">- /broken-url, /the-correct-url, 301</p>

<p>See here: $url</p>
EOS;

        $message = Swift_Message::newInstance()
            ->setFrom('no-reply@reditype.com')
            ->setTo($target_email)
            ->setSubject($title)
            ->setBody($message, 'text/html')
            ->addPart(strip_tags($message), 'text/plain');

        $this->getMailer()->send($message);



    }
}