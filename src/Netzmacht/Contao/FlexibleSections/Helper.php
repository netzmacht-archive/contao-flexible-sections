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
 * Flexible section template helper. Instantiate it in the fe_* tempalate.
 *
 * @package Netzmacht\Contao\FlexibleSections
 */
class Helper
{
    /**
     * Page template.
     *
     * @var \FrontendTemplate
     */
    private $template;

    /**
     * Cached sections specifications.
     *
     * @var array
     */
    private $specifications;

    /**
     * Construct.
     *
     * @param \FrontendTemplate $template Page template.
     */
    public function __construct(\FrontendTemplate $template)
    {
        $this->template = $template;
    }

    /**
     * Get custom section.
     *
     * @param string $sectionId   Section id.
     * @param string $template    Section template.
     * @param bool   $renderEmpty Force section being rendered when being empty.
     *
     * @return string
     */
    public function getCustomSection($sectionId, $template = null, $renderEmpty = false)
    {
        // section specification can be passed instead of the id
        if (is_array($sectionId)) {
            $sectionSpec = $sectionId;
            $sectionId   = $sectionSpec['id'];
        } else {
            $sectionSpec = $this->getSectionSpecification($sectionId);
        }

        if (!$renderEmpty && empty($this->template->sections[$sectionId])) {
            return '';
        }

        if ($template === null) {
            if ($sectionSpec && $sectionSpec['template'] != '') {
                $template = $sectionSpec['template'];
            } else {
                $template = 'block_section_simple';
            }
        }

        $blockTemplate          = new \FrontendTemplate($template);
        $blockTemplate->id      = $sectionId;
        $blockTemplate->content = $this->template->sections[$sectionId];

        return $blockTemplate->parse();
    }

    /**
     * Get custom sections.
     *
     * @param string $position Section position.
     * @param string $template Block template.
     *
     * @return string
     */
    public function getCustomSections($position, $template = 'block_sections')
    {
        $specifications = $this->getSectionSpecifications($position);
        $sections       = array();
        $classes        = array();

        foreach ($specifications as $section) {
            $buffer = $this->getCustomSection($section);

            if ($buffer) {
                $sections[$section['id']] = $buffer;
                $classes[$section['id']]  = $section['class'];
            }
        }

        if (!$sections) {
            return '';
        }

        $template           = new \FrontendTemplate($template);
        $template->sections = $sections;
        $template->classes  = $classes;

        return $template->parse();
    }

    /**
     * Get section specification.
     *
     * @param string $sectionId Section id.
     *
     * @return array|bool
     */
    private function getSectionSpecification($sectionId)
    {
        $sections = $this->getSectionSpecifications();

        foreach ($sections as $section) {
            if ($section['id'] == $sectionId) {
                return $section;
            }
        }

        return false;
    }

    /**
     * Get section specifications for a defined position.
     *
     * @param string|null $position Output position.
     *
     * @return array
     */
    private function getSectionSpecifications($position = null)
    {
        if (!$this->specifications) {
            $layout               = static::getPageLayout();
            $this->specifications = deserialize($layout->flexible_sections, true);
        }

        if ($position === null) {
            return $this->specifications;
        }

        $sections = array_filter(
            $this->specifications,
            function ($section) use ($position) {
                return $section['position'] == $position;
            }
        );

        return $sections;
    }

    /**
     * Get Page layout.
     *
     * @return \Model|null
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private static function getPageLayout()
    {
        if (TL_MODE === 'FE' && isset($GLOBALS['objPage'])) {
            $layoutIdKey = $GLOBALS['objPage']->isMobile ? 'mobileLayout' : 'layout';

            return \LayoutModel::findByPk($GLOBALS['objPage']->$layoutIdKey);
        }

        return null;
    }
}
