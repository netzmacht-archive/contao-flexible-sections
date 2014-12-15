<?php

/**
 * @package    contao-flexible-sections
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FlexibleSections;

class Helper
{
    /**
     * Page template.
     *
     * @var \FrontendTemplate
     */
    private $template;

    /**
     * @var
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
     * @param string $id          Section id.
     * @param string $template    Section template.
     * @param bool   $renderEmpty Force section being rendered when being empty.
     *
     * @return string
     */
    public function getCustomSection($id, $template=null, $renderEmpty=false)
    {
        // section specification can be passed instead of the id
        if (is_array($id)) {
            $sectionSpec = $id;
            $id          = $sectionSpec['id'];
        } else {
            $sectionSpec = $this->getSectionSpecification($id);
        }

        if (!$renderEmpty && !empty($this->template->sections[$id])) {
            return '';
        }

        if ($template === null) {
            if ($sectionSpec && $sectionSpec['template'] != '') {
                $template = $sectionSpec['template'];
            } else {
                $template = 'block_section';
            }
        }

        $blockTemplate          = new \FrontendTemplate($template);
        $blockTemplate->id      = $id;
        $blockTemplate->content = $this->template->sections[$id];

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
    public function getCustomSections($position, $template='block_sections')
    {
        $specifications = $this->getSectionSpecifications($position);
        $sections       = array();

        foreach ($specifications as $section) {
            $buffer = $this->getCustomSection($section);

            if ($buffer) {
                $sections[$section['id']] = $buffer;
            }
        }

        if (!$sections) {
            return '';
        }

        $template = new \FrontendTemplate($template);
        $template->sections = $sections;

        return $template->parse();
    }

    /**
     *
     * @param $id
     * @return bool
     */
    private function getSectionSpecification($id)
    {
        $sections = $this->getSectionSpecifications();

        foreach ($sections as $section) {
            if ($section['id'] == $id) {
                return $section;
            }
        }

        return false;
    }

    /**
     * @param string|null $position
     * @return mixed
     */
    private function getSectionSpecifications($position=null)
    {
        if (!$this->specifications) {
            $layout   = static::getPageLayout();
            $sections = deserialize($layout->bootstrap_sections, true);

            $this->specifications = $sections;
        }

        if ($position === null) {
            return $this->specifications;
        }

        return array_filter(
            $this->specifications,
            function ($section) use ($position) {
                return $section['position'] == $position;
            }
        );
    }

    /**
     * Get Page layout
     * @return \Model|null
     */
    private static function getPageLayout()
    {
        if (TL_MODE === 'FE' && isset($GLOBALS['objPage'])) {
            return \LayoutModel::findByPk($GLOBALS['objPage']->layout);
        }

        return null;
    }
}
