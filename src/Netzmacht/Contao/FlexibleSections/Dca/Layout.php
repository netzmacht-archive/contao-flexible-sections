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

class Layout
{
    /**
     * Get all templates for the sections block
     * @return array
     */
    public function getSectionTemplates()
    {
        $templates = \Controller::getTemplateGroup('block_section');

        $key = array_search('block_section', $templates);
        if ($key !== false) {
            unset($templates[$key]);
        }

        $key = array_search('block_sections', $templates);
        if ($key !== false) {
            unset($templates[$key]);
        }

        return array_values($templates);
    }

    /**
     * Load section values as language var
     *
     * @param $value
     * @param $dc
     * @return mixed
     */
    public function loadSectionLabels($value, $dc)
    {
        $sections = deserialize($dc->activeRecord->flexible_sections, true);

        foreach ($sections as $section) {
            if (!isset($GLOBALS['TL_LANG']['tl_article'][$section['id']])) {
                $GLOBALS['TL_LANG']['tl_article'][$section['id']] = $section['label'] ?: $section['id'];
            }
        }

        return $value;
    }

    /**
     * @param $value
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
     * Store sections in legacy section column
     *
     * @param $value
     * @param $dc
     * @return mixed
     */
    public function updateLegacySections($value, $dc)
    {
        $sections = array();
        $value    = deserialize($value, true);

        foreach ($value as $section) {
            if ($section['id']) {
                $sections[] = $section['id'];
            }
        }

        $sections                   = implode(',', $sections);
        $dc->activeRecord->sections = $sections;

        \Database::getInstance()
            ->prepare('UPDATE tl_layout %s WHERE id=?')
            ->set(array('sections' => $sections))
            ->execute($dc->id);

        return $value;
    }
}
