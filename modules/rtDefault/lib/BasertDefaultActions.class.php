<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertSearchActions handles search functions.
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertDefaultActions extends sfActions
{
  public function preExecute()
  {
    parent::preExecute();
    sfConfig::set('app_rt_node_title', 'Error');
  }
  
  public function executeError404(sfWebRequest $request)
  {

  }

  public function executeNotify404(sfWebRequest $request)
  {
    if(sfConfig::has('app_rt_admin_email'))
    {
      $mailer = $this->getMailer();

      $title = '404: Missing page found by user';
      $message = 'A visitor to your site found a missing page';

      if(sfConfig::get('sf_i18n', false))
      {
        $title = sfContext::getInstance()->getI18N()->__($title);
        $message = sfContext::getInstance()->getI18N()->__($message);
      }
      
      $message = sprintf('%s: %s', $message, $request->getGetParameter('url'));

      $referer_message = '';

      if($request->hasParameter('referer') && $request->getParameter('referer') !== '')
      {
        $referer_message = 'They appear to have been directed to that page from';

        if(sfConfig::get('sf_i18n', false))
        {
          $referer_message = sfContext::getInstance()->getI18N()->__($referer_message);
        }
        $message = $message . "\n" . $referer_message . ': ' . $request->getGetParameter('referer');
      }

      $mailer->composeAndSend(
        'no-reply@reditype.com',
        sfConfig::get('app_rt_admin_email'),
        $title,
        $message
      );
    }
  }
}