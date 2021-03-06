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
 * BasertSnippetComponents
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSnippetComponents extends sfComponents
{
    public function executeSnippetPanel(sfWebRequest $request)
    {
        $this->snippets = $this->getSnippets($request);
    }

    public function executeSnippetPrimaryImage(sfWebRequest $request)
    {
        sfConfig::set('sf_web_debug', false);
        $this->snippets = $this->getSnippets($request);
    }

    /**
     * @param sfWebRequest $request
     * @return Doctrine_Collection|rtSnippet[]
     */
    private function getSnippets(sfWebRequest $request)
    {
        $this->limit = isset($this->limit) ? $this->limit : 1;
        return Doctrine::getTable('rtSnippet')->findAllPublishedByCollection($this->collection, $this->limit);
    }
}