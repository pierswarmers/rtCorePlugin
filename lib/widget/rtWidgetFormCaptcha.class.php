<?php

/*
 * This file is part of the rtShopPlugin package.
 *
 * (c) 2006-2011 digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtWidgetFormCaptcha
 *
 * @package    rtCorePlugin
 * @subpackage widgets
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtWidgetFormCaptcha extends sfWidgetForm
{
  /**
   * Configures the current widget
   *
   * Available options:
   *
   *  * captcha_passphrase:   Array with questions
   *
   * <code>
   * # Example YAML for app.yml
   * rt:
   *   captcha_passphrase_options:
   *    #- ["prefix",                                  "answer",         "suffix"]
   *     - ["How many days in a week",                 "7,seven",        ""]
   *     - ["Which do you prefer: blue, green or red", "blue,green,red", ""]
   * </code>
   *
   * @param array $options
   * @param array $attributes
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    // Default questions, captcha_passphrase_options not configured
    $captcha_passphrase   = array();
    $captcha_passphrase[] = array('What is 1 + 4', '5,five','');
    $captcha_passphrase[] = array('What is 1 + 2','3,three','');
    $captcha_passphrase[] = array('What is 6 - 2','4,four','');
    $captcha_passphrase[] = array('What is 4 &divide; 2','2,two','');
    $captcha_passphrase[] = array('','monday','is the first day of the working week.');
    $captcha_passphrase[] = array('Which do you prefer: blue, green or red','blue,green,red','');
    $captcha_passphrase[] = array('How many days in a week','7,seven','');
    $captcha_passphrase[] = array('What color is the sky: blue, red or orange','blue','');
    $captcha_passphrase[] = array('Is ice hot or cold','cold','');
    $captcha_passphrase[] = array('What is the opposite of cold','hot,warm','');
    $captcha_passphrase[] = array('Which is a colour: boat, bank or purple','purple','');
    $captcha_passphrase[] = array('Which is a colour: bird, house or orange','orange','');
    $captcha_passphrase[] = array('Which is a colour: car, pink or horse','pink','');
    $captcha_passphrase[] = array('Which is a colour: yellow, fork or dog','yellow','');
    $captcha_passphrase[] = array('What comes next in this series: a, b, c , d ...','e','');
    $captcha_passphrase[] = array('Cars drive on','road,roads,street,streets,lane,highway','');
    $captcha_passphrase[] = array('Fish live in','water,sea,seas,ocean,oceans,river,rivers,tank,tanks,fish tank','');
    $captcha_passphrase[] = array('Cows and horses like eating','grass','');
    $captcha_passphrase[] = array('Which is bigger, a mouse or an elephant','elephant,elephants','');

    // Use default questions when not overwritten in configuration
    $captcha_passphrase = sfConfig::get('app_rt_captcha_passphrase_options', $captcha_passphrase);

    $this->addRequiredOption('captcha_passphrase');
    $this->setOption('captcha_passphrase', $captcha_passphrase);
  }

  /**
   * Render function
   *
   * @param string $name
   * @param string $value
   * @param array $attributes
   * @param array $errors
   * @return mixed
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $display = $this->getOption('captcha_passphrase');
    shuffle($display);

    sfContext::getInstance()->getUser()->setAttribute('rt_captcha_passphrase', $display[0][1]);

    $prefix = $display[0][0];
    $field  = $this->renderTag('input', array_merge(array('type' => 'text', 'name' => $name, 'value' => '', 'autocomplete' => 'off'), $attributes));
    $suffix = $display[0][2];

    return sprintf('<div class="rt-captcha">%s %s %s</div>',$prefix,$field,$suffix);
  }
}