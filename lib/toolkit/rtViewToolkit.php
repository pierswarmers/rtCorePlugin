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
 * rtUserToolkit
 *
 * A set of tools for response to view level interaction.
 *
 * @package    rtCorePlugin
 * @author     Piers Warmers <piers@wranglers.com.au>
 */

class rtViewToolkit
{
    const ENV_DEV = 'frontend_dev.php';

    const INSTANCE_TOKEN = 'rt_view_toolkit';


    /**
     * @var sfContext
     */
    private $sf_context;

    /**
     * @param string $class
     * @return rtViewToolkit
     */

    static public function getInstance($class = __CLASS__)
    {
        $c = sfContext::getInstance();

        if(!$c->has(self::INSTANCE_TOKEN)) {
            $vt = new $class();
            $c->set(self::INSTANCE_TOKEN, $vt);
        }

        return $c->get(self::INSTANCE_TOKEN);
    }


    private function initialize()
    {
        $this->enhanceMetaKeywords();
    }

    private function enhanceMetaKeywords()
    {
        $metas = $this->getContext()->getResponse()->getMetas();

        if(array_key_exists('keywords', $metas) && '' !== trim($metas['keywords'])) {
            $this->getContext()->getResponse()->addMeta('keywords', $metas['keywords'] . ', ' . $this->getSite()->getMetaKeywordSuffix());
            return;
        }

        $this->getContext()->getResponse()->addMeta('keywords', $this->getSite()->getMetaKeywordSuffix());
    }

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @return sfContext
     */
    private function getContext()
    {
        return sfContext::getInstance();
    }

    /**
     * Is the current request for the homepage?
     *
     * @return bool
     */
    public function isHomepage()
    {
        return $this->getRequestedModuleName() === 'rtSite' && $this->getRequestedActionName() === 'index';
    }

    /**
     * Return a list of all routes available.
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->getContext()->getRouting()->getRoutes();
    }

    /**
     * Retrieve the request object from sfContext.
     *
     * @return sfRequest
     */
    public function getRequest()
    {
        return $this->getContext()->getRequest();
    }

    /**
     * Retrieve the response object from sfContext.
     * @return sfResponse
     */
    public function getResponse()
    {
        return $this->getContext()->getResponse();
    }

    /**
     * @return mixed
     */
    public function getRequestedModuleName()
    {
        return $this->getRequest()->getParameter('module');
    }

    /**
     * @return mixed
     */
    public function getRequestedActionName()
    {
        return $this->getRequest()->getParameter('action');
    }

    /**
     * Get the requested URI.
     *
     * @return mixed
     */
    public function getUri()
    {
        return $this->cleanDevToken($_SERVER['PATH_INFO']);
    }

    /**
     * Get a normalized URI token.
     *
     * @return string
     */
    public function getUriNormalized() {
        return $this->urlize($this->cleanDevToken($this->getUri()));
    }

    /**
     * The site reference key to be used in theme and layout identification.
     *
     * @return string
     */
    public function getSiteReferenceKey()
    {
        return $this->getSite() ? $this->getSite()->getReferenceKey() : 'global';
    }

    /**
     * Get the current site object.
     *
     * @return rtSite
     */
    public function getSite()
    {
        return rtSiteToolkit::getCurrentSite();
    }

    /**
     * Get an area token which is built from module and action names. The return value is encoded for
     * URI usage and can also be a valid class name.
     *
     * @return string
     */
    public function getAreaToken()
    {
        return $this->urlize($this->tableize($this->getRequestedModuleName()) . '-' . $this->tableize($this->getRequestedActionName()));
    }

    /**
     * Get the title from a mix of response and site.
     *
     * @return string
     */
    public function getResponseTitle()
    {
        if($this->getSite()) {

            if('' === $this->getResponse()->getTitle()) {
                return $this->getSite()->getMetaTitleSuffix();
            }

            return $this->getResponse()->getTitle() . ' | ' . $this->getSite()->getMetaTitleSuffix();
        }

        return $this->getResponse()->getTitle();
    }

    /**
     * Camel case to underscored.
     *
     * @param $string
     * @return string
     */
    private function tableize($string)
    {
        return sfInflector::tableize($string);
    }

    /**
     * Clean for usage in URLs
     *
     * @param $string
     * @return string
     */
    private function urlize($string)
    {
        return Doctrine_Inflector::urlize($string);
    }

    /**
     * @param $string
     * @return mixed
     */
    private function cleanDevToken($string)
    {
        return str_replace(array(self::ENV_DEV, '//'), array('', '/'), $string);
    }

    /**
     * Is this the development environment.
     *
     * @return bool
     */
    private function isDev()
    {
        return 'dev' === $this->getContext()->getConfiguration()->getEnvironment();
    }
}