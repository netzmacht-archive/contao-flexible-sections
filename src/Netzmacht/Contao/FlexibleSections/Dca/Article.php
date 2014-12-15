<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FlexibleSections\Dca;

/**
 * DCA helper class for tl_article.
 *
 * @package Netzmacht\Contao\FlexibleSections\Dca
 */
class Article
{
    /**
     * Load all section label from used page layout.
     *
     * @param string         $value         Active used column.
     * @param \DataContainer $dataContainer Data container driver.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function loadSectionLabels($value, $dataContainer)
    {
        // Show only active sections
        if ($dataContainer->activeRecord->pid) {
            $page = \PageModel::findWithDetails($dataContainer->activeRecord->pid);

            // Get the layout sections
            foreach (array('layout', 'mobileLayout') as $key) {
                if (!$page->$key) {
                    continue;
                }

                $objLayout = \LayoutModel::findByPk($page->$key);
                if ($objLayout === null) {
                    continue;
                }

                $sections = deserialize($objLayout->flexible_sections, true);

                foreach ($sections as $section) {
                    if (!isset($GLOBALS['TL_LANG']['tl_article'][$section['id']])) {
                        $GLOBALS['TL_LANG']['tl_article'][$section['id']] = $section['label'] ?: $section['id'];
                    }
                }
            }
        }

        return $value;
    }
}
