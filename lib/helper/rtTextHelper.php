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
 * Converts a markdown string (tags removed) into HTML
 *
 * @package Reditype
 * @subpackage helper
 * @param string $string
 * @param rtPage $object
 * @return string
 */
function markdown_to_html_safe($string, $object = null)
{
  $rt_string = new rtTypeString(strip_tags($string), array('object' => $object));
  return strip_tags($rt_string->transform());
}

/**
 * Converts a markdown string into HTML
 *
 * @package Reditype
 * @subpackage helper
 * @param string $string
 * @param rtPage $object
 * @param bool $summary
 * @return string
 */
function markdown_to_html($string, $object = null, $summary = false)
{
  $section = $summary ? 'head' : 'all';
  $rt_string = new rtTypeString($string, array('object' => $object, 'section' => $section));
  return $rt_string->transform();
}

/**
 * Converts a markdown string into HTML, then returns it with the editable area.
 *
 * @package Reditype
 * @subpackage helper
 * @param string $string
 * @param rtPage $object
 * @param bool $summary
 * @return string
 */
function editable_section($string, $object = null, $summary = false)
{
    return editable_link($object) . markdown_to_html($string, $object, $summary);
}

function editable_link($object, $title = 'Page') {
    $link = '';

    if($object) {

        if(!isset($options['admin_class'])) {
            if($object instanceof sfOutputEscaperObjectDecorator) {
                $admin_class = get_class($object->getRawValue());
            } else {
                $admin_class = get_class($object);
            }
        }

        $link = '<!--RTAS';
        $link .= '<div class="rt-section-tools-header rt-admin-tools">';
        $link .= link_to('Edit ' . $title, $admin_class.'Admin/edit?id='.$object->getId(), array('class' => 'rt-admin-edit-tools-trigger'));
        $link .= '</div>';
        $link .= 'RTAS-->';

        return $link;
    }
}