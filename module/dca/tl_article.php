<?php

/**
 * @package    contao-flexible-sections
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

$GLOBALS['TL_DCA']['tl_article']['fields']['inColumn']['load_callback'][] = array(
    'Netzmacht\Contao\FlexibleSections\Dca\Article',
    'loadSectionLabels'
);
