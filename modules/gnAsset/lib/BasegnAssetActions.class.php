<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasegnAssetActions handles search functions.
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasegnAssetActions extends sfActions
{
  /**
   * Return JSON response.
   * 
   * @param array $json_values
   * @param sfWebRequest $request
   * @return string
   */
  private function returnJSONResponse($json_values, sfWebRequest $request)
  {
    $this->getResponse()->setContent(json_encode($json_values));
    sfConfig::set('sf_web_debug', false);
    return sfView::NONE;
  }

  /**
   * Deliver a file back to the browser.
   *
   * @param sfWebRequest $request
   */
  public function executeDelivery(sfWebRequest $request)
  {

  }

  /**
   * Execute a delete of an asset, communicating the success or failure via an ajax response.
   *
   * @param sfWebRequest $request
   * @return <type>
   */
  public function executeDelete(sfWebRequest $request)
  {
    $asset = Doctrine::getTable('gnAsset')->findOneById($request->getParameter('id'));
    $asset->delete();
    $json_values = array('status' => 'success', 'id' => $request->getParameter('id'));
    return $this->returnJSONResponse($json_values, $request);
  }

  /**
   * Execute a reorder of assets, communicating the success or failure via an ajax response.
   * 
   * @param sfWebRequest $request
   * @return <type>
   */
  public function executeReorder(sfWebRequest $request)
  {
    $ids = $request->getParameter('order');
    $position = 1;
    
    foreach($ids as $id)
    {
      $asset = Doctrine::getTable('gnAsset')->findOneById($id);
      if($asset)
      {
        $asset->setPosition($position);
        $asset->save();
        $position++;
      }
    }
    
    $json_values = array('status' => 'success');
    return $this->returnJSONResponse($json_values, $request);
  }

  /**
   * Execute a file upload, communicating the success or failure via an ajax response.
   *
   * Note: This response is set as plain/text since application/json responses were causing
   * issues. When calling this action, please use:
   *
   * <code>
   * url_for('@gn_asset_upload?sf_format=json')
   * </code>
   *
   * @param sfWebRequest $request
   */
  public function executeUpload(sfWebRequest $request)
  {
    $form = new gnAssetUploadForm();
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    $json_values = array();
    
    if ($form->isValid())
    {
      try
      {
        $file = $request->getFiles('gn_asset');
        $form->getObject()->setOriginalFilename(gnAssetToolkit::cleanFilename($file['filename']['name']));
        $form->getObject()->setFilesize($file['filename']['size']);
        $form->getObject()->setMimeType($file['filename']['type']);
        $form->save();
        $json_values['status'] = 'success';
        $json_values['message'] = 'File uploaded!';
        $json_values['asset_id'] = $form->getObject()->getId();
        $this->logMessage($form->getObject()->getSystemPath() . ' return thumnail path ' . gnAssetToolkit::getThumbnailPath($form->getObject()->getSystemPath(), array('maxWidth' => 50, 'maxHeight' => 50)));
        $json_values['location'] = gnAssetToolkit::getThumbnailPath($form->getObject()->getSystemPath(), array('maxWidth' => 150, 'maxHeight' => 50, 'minHeight' => 50, 'minWidth' => 50));
      }
      catch(Exception $e)
      {
        $json_values['status'] = 'error';
        $json_values['message'] = $e->getMessage();
        $this->logMessage($e->getMessage(), 'err');
      }
    }
    else
    {
      $json_values['status'] = 'error';
      $json_values['message'] = $form['filename']->getError()->getMessage();
    }

    return $this->returnJSONResponse($json_values, $request);
  }
}