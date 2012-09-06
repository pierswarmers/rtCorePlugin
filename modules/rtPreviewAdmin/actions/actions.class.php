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
 * rtPreviewActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtPreviewAdminActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        If($request->hasParameter('object_id') && $request->hasParameter('object_class')) {
            $this->object = Doctrine::getTable($request->getParameter('object_class'))->find($request->getParameter('object_id'));
        }

        $this->setLayout(false);
    }
}
