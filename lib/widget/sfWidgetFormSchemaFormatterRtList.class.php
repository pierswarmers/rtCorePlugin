<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormSchemaFormatterRtTable
 *
 * @package    reditype
 * @subpackage widget
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class sfWidgetFormSchemaFormatterRtList extends sfWidgetFormSchemaFormatter
{
  protected
      $rowFormat                 = '<li class="rt-form-row">%label%<div class="rt-form-field">%error%%field%%help%%hidden_fields%</div></li>',
      $helpFormat                = '<small class="rt-help">%help%</small>',
      $errorRowFormat            = '<dt class="rt-error-global">Errors:</dt><dd>%errors%</dd>',
      $errorListFormatInARow     = '<ul class="rt-error-list">%errors%</ul>',
      $errorRowFormatInARow      = '<li>%error%</li>',
      $namedErrorRowFormatInARow = '<li>%name%: %error%</li>',
      $decoratorFormat           = '<ul class=123>\n  %content%</ul>';
}