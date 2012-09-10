<?php

/**
 * Abstract controller.
 *
 * @author    Piers Warmers <piers@wranglers.com.au>
 * @copyright Copyright (c) 2011, digital Wranglers <info@wranglers.com.au>
 * @license   This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.
 */
abstract class rtController extends sfActions
{
    private $_rt_site;

    /**
     * Executes an application defined process prior to execution of this sfAction object.
     *
     * By default, this method is empty.
     */
    public function preExecute()
    {
        sfConfig::set('app_rt_node_title', 'Site');
        rtTemplateToolkit::setFrontendTemplateDir();

        if(!$this->getRtSite()) {
            $this->forward404('Failed to retrieve site.');
        }
    }

    /**
     * @return rtSite
     */
    protected function getRtSite()
    {
        if(is_null($this->_rt_site)) {
            $this->_rt_site = rtSiteToolkit::getCurrentSite();
        }

        return $this->_rt_site;
    }
}
