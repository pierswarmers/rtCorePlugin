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
 * BasertAssetActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertAssetActions extends sfActions
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
    $asset = Doctrine::getTable('rtAsset')->findOneById($request->getParameter('id'));
    $asset->delete();
    $json_values = array('status' => 'success', 'id' => $request->getParameter('id'));
    return $this->returnJSONResponse($json_values, $request);
  }

  /**
   * Execute edit of an asset
   *
   * @param sfWebRequest $request
   */
  public function executeEdit(sfWebRequest $request)
  {
    sfConfig::set('sf_web_debug',false);
    $this->forward404Unless($asset = Doctrine::getTable('rtAsset')->findOneById($request->getParameter('id')));
    $this->asset = $asset;
    $this->setLayout(false);
  }

  /**
   * Execute update of an asset
   *
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    sfConfig::set('sf_web_debug',false);
    $this->forward404Unless($asset = Doctrine::getTable('rtAsset')->findOneById($request->getParameter('id')));
    $asset->setTitle($request->getParameter('title'));
    $asset->setDescription($request->getParameter('description'));
    $asset->setOriginalFilename($request->getParameter('filename'));
    
    if($asset->isTextEditable())
    {
      $asset->setFileContent($request->getParameter('content'));
      $asset->setFilesize(filesize($asset->getSystemPath()));
    }
    //$asset->setCopyright($request->getParameter('copyright'));
    //$asset->setAuthor($request->getParameter('author'));
    $asset->save();

    $this->setLayout(false);
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

    // Clean the IDs
    for($i = 0; $i < count($ids); $i++)
    {
      $ids[$i] = str_replace('rtAttachedAsset', '', $ids[$i]);
    }

    $position = 1;
    
    foreach($ids as $id)
    {
      $asset = Doctrine::getTable('rtAsset')->findOneById($id);
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
   * url_for('@rt_asset_upload?sf_format=json')
   * </code>
   *
   * @param sfWebRequest $request
   */
  public function executeUpload(sfWebRequest $request)
  {
    $form = $this->getForm();
    $request_params = $request->getParameter($form->getName());
    $form->bind($request_params, $request->getFiles($form->getName()));

    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);
    $error = '';
    
    if ($form->isValid())
    {
      try
      {
        $file = $request->getFiles('rt_asset');
        $form->getObject()->setOriginalFilename(rtAssetToolkit::cleanFilename($file['filename']['name']));
        $form->getObject()->setFilesize($file['filename']['size']);
        $form->getObject()->setMimeType($file['filename']['type']);

        $assets = Doctrine::getTable('rtAsset')->getAssetsForModelAndId($request_params['model'], $request_params['model_id']);

        $position = 1;
        
        if($assets->count() > 0)
        {
          $position = $assets->getLast()->getPosition() + 1;
        }
        
        $form->getObject()->setPosition($position);
        $form->save();

        $this->asset = $form->getObject();
        return sfView::SUCCESS;
      }
      catch(Exception $e)
      {
        $error = $e->getMessage();
        $this->logMessage($e->getMessage(), 'err');
      }
    }
    else
    {
      $error =  $form['filename']->getError()->getMessage();
    }

    $this->error = $error;
    return sfView::ERROR;
  }


  /**
   * Execute a file upload, communicating the success or failure via an ajax response.
   *
   * Note: This response is set as plain/text since application/json responses were causing
   * issues. When calling this action, please use:
   *
   * <code>
   * url_for('@rt_asset_upload?sf_format=json')
   * </code>
   *
   * @param sfWebRequest $request
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);

    $this->setTemplate('upload');

    $object = Doctrine::getTable($request->getParameter('model'))->findOneById($request->getParameter('model_id'));


    if(!$request->hasParameter('model_id') || !$request->hasParameter('model'))
    {
      $this->error = 'Model or Model ID were not sent with request.';
      return sfView::ERROR;
    }

    $asset = new rtAsset();
    $asset->setOriginalFilename('segment.html');
    $asset->setTitle('HTML');
    $asset->setFilename(sha1($asset->getOriginalFilename().rand(11111, 99999)).'.'.$asset->getExtension());
    $asset->setMimeType('text/html');
    $asset->setModelId($request->getParameter('model_id'));
    $asset->setModel($request->getParameter('model'));
    $asset->setPosition(count($object->getAssets()) + 1);
    $asset->setFileContent('<!-- your HTML here -->');
    $asset->setFilesize(filesize($asset->getSystemPath()));
    $asset->save();
    $this->asset = $asset;
    return sfView::SUCCESS;
  }


  /**
   * Returns a form object.
   *
   * @return rtAssetUploadForm
   */
  protected function getForm()
  {
    return new rtAssetUploadForm();
  }
}