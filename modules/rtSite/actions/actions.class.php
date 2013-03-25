<?php

class rtSiteActions extends rtController
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->rt_site_page = Doctrine::getTable('rtSitePage')->findRoot();

        if($this->rt_site_page) {
            $this->updateResponse($this->rt_site_page);
        }
    }

    public function executeShow(sfWebRequest $request)
    {
        $this->rt_site = Doctrine::getTable('rtSite')->findOneBy('reference_key', $request->getParameter('reference_key'));
        $this->forward404Unless($this->rt_site);
        $site = rtSiteToolkit::getCurrentSite();
        if(rtSiteToolkit::getCurrentSite()->getReferenceKey() !== sfConfig::get('app_rt_booking_site_ref_key')) {
            $site = Doctrine::getTable('rtSite')->findOneBy('reference_key', sfConfig::get('app_rt_booking_site_ref_key'));
            if(!$site) {
                $this->forward404();
            }
            $this->redirect('http://'.$site->getDomain(). $request->getPathInfo());
        }
    }

    public function executeShowSimple(sfWebRequest $request)
    {
        $this->rt_site = Doctrine::getTable('rtSite')->findOneBy('reference_key', $request->getParameter('reference_key'));
        $this->forward404Unless($this->rt_site);
    }


    public function executeMap(sfWebRequest $request)
    {
        $this->rt_sites = Doctrine::getTable('rtSite')->findAll();
    }

    private function updateResponse(rtSitePage $page)
    {
        rtResponseToolkit::setCommonMetasFromPage($page, $this->getUser(), $this->getResponse());
    }
}