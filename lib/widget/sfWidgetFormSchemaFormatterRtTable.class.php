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
class sfWidgetFormSchemaFormatterRtTable extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<tr class=\"rt-form-row\">\n  <th>%label%</th>\n  <td>%error%%field%%help%%hidden_fields%</td>\n</tr>\n",
    $errorRowFormat  = "<tr><td colspan=\"2\">\n%errors%</td></tr>\n",
    $helpFormat      = '<small class="help">( %help% )</small>',
    $decoratorFormat = "<table>\n  %content%</table>";
}

new sfWidgetFormSchemaFormatterList;