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
 * rtWidgetFormSelectCountry
 *
 * @package    rtCorePlugin
 * @subpackage widget
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtWidgetFormSelectCountry extends sfWidgetFormSelect
{
  protected $countries = array();
  
  /**
   * @param array $options
   * @param array $attributes
   */
  public function __construct($options = array(), $attributes = array())
  {
    $options['choices'] = new sfCallable(array($this, 'getChoices'));

    $this->setCountriesFromCultureInfo();

    parent::__construct($options, $attributes);
  }

  /**
   * @param array $options
   * @param array $attributes
   * @return void
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('add_empty', false);

    parent::configure($options, $attributes);
  }

  /**
   * Returns choices for the current widget.
   *
   * @return array
   */
  public function getChoices()
  {
    $choices = array();
    if (false !== $this->getOption('add_empty'))
    {
      $choices[''] = true === $this->getOption('add_empty') ? '' : $this->getOption('add_empty');
    }

    $choices = array_merge($choices, self::getCountries());

    return $choices;
  }

  /**
   * Returns an associative array of US states.
   *
   * @return array
   */
  protected function getCountries()
  {
    return $this->countries;
  }

  /**
   * Sets the array of countries.
   *
   * @param array $countries
   */
  protected function setCountries(array $countries)
  {
    $this->countries = $countries;
  }

  /**
   * Set the country list via the sfCultureInfo system.
   * @return void
   */
  protected function setCountriesFromCultureInfo()
  {
    $c = new sfCultureInfo(sfContext::getInstance()->getUser()->getCulture());

    $countries = $c->getCountries();

    foreach($countries as $key => $value)
    {
      if(is_int($key))
      {
        unset($countries[$key]);
      }
    }

    unset($countries['ZZ']);

    $countries = array('' => '--') + $countries;
    
    $this->setCountries($countries);
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
    $string = parent::render($name, $value, $attributes, $errors);

    $country_id = str_replace('[', '_', $name);
    $country_id = str_replace(']', '', $country_id);

    $state_id = str_replace('country', 'state', $country_id);

    $state_name = str_replace('country', 'state', $name);

    $route = sfContext::getInstance()->getController()->genUrl('rtAdmin/stateInput');

  

    $js = <<<EOS

<script type="text/javascript">
  $(function() {
    $('#$country_id').change(function() {

      var holder =  $('#$state_id').parent();

      holder.html('<span class="loading">Loading states...</span>');
      $('#$state_id').remove();
      $.ajax({
        type: "POST",
        url: '$route',
        data: ({
          country : $(this).find('option:selected').attr('value'),
          id      : '$state_id',
          name    : '$state_name'
        }),
        dataType: "html",
        success: function(data) {
          holder.html(data);
        }
      });
    });
  });
</script>

EOS;

    return $js.$string;
  }
}
