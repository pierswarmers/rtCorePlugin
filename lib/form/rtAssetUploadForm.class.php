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
 * rtAssetUploadForm handles the asset attachment form used in the admin area.
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtAssetUploadForm extends PluginrtAssetForm
{
  public function setup()
  {
    parent::setup();

    $this->useFields(array('model', 'model_id', 'filename'));

    $this->setWidgets(array(
      'model_id'   => new sfWidgetFormInputHidden(),
      'model'      => new sfWidgetFormInputHidden(),
      'filename'   => new sfWidgetFormInputFile(),
    ));

    $this->setValidators(array(
      'model_id'   => new sfValidatorInteger(array('required' => false)),
      'model'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'filename'   => new sfValidatorFile(array(
      'path' => sfConfig::get('sf_upload_dir'),
      'mime_types' => $this->getAllowedMimeTypes(),
      'mime_type_guessers' => array('guessFromFileinfo')
    )),
    ));

    $this->enableCSRFProtection();
    $this->widgetSchema->setNameFormat('rt_asset[%s]');
  }

  /**
   * Return a list of allowed mime-types allowed for upload.
   *
   * @return array
   */
  public function getAllowedMimeTypes()
  {
    if($this->getOption('allowed_mime_types'))
    {
      return $this->getOption('allowed_mime_types');
    }
    return sfConfig::get('app_rt_asset_allowed_mime_types', rtAssetToolkit::getCommonMimeTypes());
  }
}