<?php

/**
 * A simple toolkit to enable a few hooks into Google Maps Api
 *
 * @author    Piers Warmers <piers@wranglers.com.au>
 * @copyright Copyright (c) 2011, digital Wranglers <info@wranglers.com.au>
 * @license   This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.
 */
class GoogleMaps
{
  /**
   * Returns the longitude and latitude of a given address in either string or array format.
   * 
   * @static
   * @param  array|string $address
   * @return array|false Coordinates as an array on success or false if an Api failure has been picked up.
   */
  public static function getCoords($address)
  {
    if(is_array($address))
    {
      $address = implode(',+', $address);
    }

    $address = str_replace(' ', '+', $address);

    $query = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=' . $address;

    $values = json_decode(file_get_contents($query));

    if($values->status == 'OK' && isset($values->results[0]))
    {
      return array(
        'latitude'  => $values->results[0]->geometry->location->lat,
        'longitude' => $values->results[0]->geometry->location->lng
      );
    }

    return false;
  }
}
