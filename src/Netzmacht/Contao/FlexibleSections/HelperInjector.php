<?php

/**
 * @package    contao-flexible-sections
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FlexibleSections;

/**
 * This class hooks into Contao to inject the helper class.
 *
 * @package Netzmacht\Contao\FlexibleSections
 */
class HelperInjector
{
    /**
     * Inject the helper for the frontend templates.
     *
     * @param \Template $template The template being parsed.
     *
     * @return void
     */
    public function hookParseTemplate(\Template $template)
    {
        if (substr($template->getName(), 0, 3) === 'fe_') {
            $helper = new Helper($template);

            $template->flexibleSections = function ($position, $template = 'block_sections') use ($helper) {
                echo $helper->getCustomSections($position, $template);
            };

            $template->getFlexibleSectionsHelper = function () use ($helper) {
                return $helper;
            };
        }
    }
}
