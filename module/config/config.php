<?php

/**
 * @package    contao-flexible-sections
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

$GLOBALS['TL_HOOKS']['parseTemplate'][] = array(
    'Netzmacht\Contao\FlexibleSections\HelperInjector',
    'hookParseTemplate'
);
