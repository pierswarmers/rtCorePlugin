<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnIndexCleanerEs defines Spanish stopwords.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnIndexCleanerEs implements GnIndexCleaner
{
  /**
   * Defines a list of Spanish stop words to be removed from indexed text.
   *
   * @var array $_stopwords
   */
  protected static $_stopwords = array(
    'un','una','unas','unos','uno','sobre','todo','también','tras','otro',
    'algún','alguno','alguna','algunos','algunas','ser','es','soy','eres',
    'somos','sois','estoy','esta','estamos','estais','estan','como','en','para',
    'atras','porque','por qué','estado','estaba','ante','antes','siendo','ambos',
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