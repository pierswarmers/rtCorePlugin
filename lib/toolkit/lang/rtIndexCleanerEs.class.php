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
 * rtIndexCleanerEs defines Spanish stopwords.
 *
 * @package    rtCorePlugin
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtIndexCleanerEs implements rtIndexCleaner
{
  /**
   * Defines a list of Spanish stop words to be removed from indexed text.
   *
   * @var array $_stopwords
   */
  protected static $_stopwords = array(
    'un','una','unas','unos','uno','sobre','todo','tambi�n','tras','otro',
    'alg�n','alguno','alguna','algunos','algunas','ser','es','soy','eres',
    'somos','sois','estoy','esta','estamos','estais','estan','como','en','para',
    'atras','porque','por qu�','estado','estaba','ante','antes','siendo','ambos',
    'pero','por','poder','puede','puedo','podemos','podeis','pueden','fui','fue',
    'fuimos','fueron','hacer','hago','hace','hacemos','haceis','hacen','cada',
    'fin','incluso','primero	desde','conseguir','consigo','consigue',
    'consigues','conseguimos','consiguen','ir','voy','va','vamos','vais','van',
    'vaya','gueno','ha','tener','tengo','tiene','tenemos','teneis','tienen','el',
    'la','lo','las','los','su','aqui','mio','tuyo','ellos','ellas','nos',
    'nosotros','vosotros','vosotras','si','dentro','solo','solamente','saber',
    'sabes','sabe','sabemos','sabeis','saben','ultimo','largo','bastante','haces',
    'muchos','aquellos','aquellas','sus','entonces','tiempo','verdad',
    'verdadero','verdadera	cierto','ciertos','cierta','ciertas','intentar',
    'intento','intenta','intentas','intentamos','intentais','intentan','dos',
    'bajo','arriba','encima','usar','uso','usas','usa','usamos','usais','usan',
    'emplear','empleo','empleas','emplean','ampleamos','empleais','valor','muy',
    'era','eras','eramos','eran','modo','bien','cual','cuando','donde','mientras',
    'quien','con','entre','sin','trabajo','trabajar','trabajas','trabaja',
    'trabajamos','trabajais','trabajan','podria','podrias','podriamos','podrian',
    'podriais','yo','aquel'
  );

  /**
   * Return a list of Spanish stopwords.
   *
   * @return array
   */
  static public function getStopwords()
  {
    return self::$_stopwords;
  }

  /**
   * Apply Spanish normalizing logic to string.
   *
   * @param array $words
   * @return array
   */
  static public function stemWord($string)
  {
    if(extension_loaded('stem'))
    {
      return stem_spanish($string);
    }
    return $string;
  }
}