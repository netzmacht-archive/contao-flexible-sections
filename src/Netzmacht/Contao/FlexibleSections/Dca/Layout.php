<?php

/**
 * @package    contao-flexible-sections
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FlexibleSections\Dca;

/**
 * DCA helper class for tl_layout.
 *
 * @package Netzmacht\Contao\FlexibleSections\Dca
 */
class Layout
{
    /**
     * Get all templates for the sections block.
     *
     * @return array
     */
    public function getSectionTemplates()
    {
        $templates = \Controller::getTemplateGroup('block_section');

        unset($templates['block_section']);
        unset($templates['block_sections']);

        return $templates;
    }

    /**
     * Load section values as language var.
     *
     * @param mixed          $value         Value of the field.
     * @param \DataContainer $dataContainer DCA driver.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function loadSectionLabels($value, $dataContainer)
    {
        $sections = deserialize($dataContainer->activeRecord->flexible_sections, true);

        foreach ($sections as $section) {
            if (!isset($GLOBALS['TL_LANG']['tl_article'][$section['id']])) {
                $GLOBALS['TL_LANG']['tl_article'][$section['id']] = $section['label'] ?: $section['id'];
            }
        }

        return $value;
    }

    /**
     * Autocomplee section ids.
     *
     * @param string|array $value Sections configuration.
     *
     * @return array
     */
    public function autoCompleteSectionIds($value)
    {
        $sections = array();
        $value    = deserialize($value, true);

        foreach ($value as $section) {
            if (!$section['id']) {
                if (!$section['label']) {
                    continue;
                }

                $section['id'] = standardize($section['label']);
            }

            $sections[] = $section;
        }

        return $sections;
    }

    /**
     * Store sections in legacy section column.
     *
     * @param string|array   $value         Section configuration.
     * @param \DataContainer $dataContainer DataContainer.
     *
     * @return mixed
     */
    public function updateLegacySections($value, $dataContainer)
    {
        $sections = array();
        $value    = deserialize($value, true);

        foreach ($value as $section) {
            if ($section['id']) {
                $sections[] = $section['id'];
            }
        }

        $sections = implode(',', $sections);

        $dataContainer->activeRecord->sections = $sections;

        \Database::getInstance()
            ->prepare('UPDATE tl_layout %s WHERE id=?')
            ->set(array('sections' => $sections))
            ->execute($dataContainer->id);

        return $value;
    }
}
