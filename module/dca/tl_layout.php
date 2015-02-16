<?php

/**
 * @package    contao-flexible-sections
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

\MetaPalettes::appendFields('tl_layout', 'sections', array('flexible_sections'));
\MetaPalettes::removeFields('tl_layout', array('sections', 'sposition'));


$GLOBALS['TL_DCA']['tl_layout']['fields']['flexible_sections'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['flexible_sections'],
    'exclude'                 => true,
    'inputType'               => 'multiColumnWizard',
    'save_callback'           => array(
        array('Netzmacht\Contao\FlexibleSections\Dca\Layout', 'autoCompleteSectionIds'),
        array('Netzmacht\Contao\FlexibleSections\Dca\Layout', 'updateLegacySections'),
    ),
    'eval'                    => array(
        'tl_class' => 'clr long',
        'columnFields' => array(
            'label' => array(
                'label'     => &$GLOBALS['TL_LANG']['tl_layout']['flexible_sections_label'],
                'inputType' => 'text',
                'eval'      => array(
                    'style' => 'width: 130px',
                ),
            ),
            'id' => array(
                'label'     => &$GLOBALS['TL_LANG']['tl_layout']['flexible_sections_id'],
                'inputType' => 'text',
                'eval'      => array(
                    'style' => 'width: 100px',
                ),
            ),
            'class' => array(
                'label'     => &$GLOBALS['TL_LANG']['tl_layout']['flexible_sections_class'],
                'inputType' => 'text',
                'eval'      => array(
                    'style' => 'width: 100px',
                ),
            ),
            'template' => array(
                'label'     => &$GLOBALS['TL_LANG']['tl_layout']['flexible_sections_template'],
                'inputType' => 'select',
                'options_callback' => array('Netzmacht\Contao\FlexibleSections\Dca\Layout', 'getSectionTemplates'),
                'eval'      => array(
                    'style'              => 'width: 100px',
                    'chosen'             => true,
                    'mandatory'          => true,
                ),
            ),
            'position' => array(
                'label'     => &$GLOBALS['TL_LANG']['tl_layout']['flexible_sections_position'],
                'inputType' => 'select',
                'options'   => array('top', 'before', 'after', 'bottom', 'custom'),
                'reference' => &$GLOBALS['TL_LANG']['tl_layout'],
                'eval'      => array(
                    'style'              => 'width: 150px',
                    'chosen'             => true,
                    'mandatory'          => true,
                ),
            )
        )
    ),
    'sql'                     => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['modules']['load_callback'][] = array(
    'Netzmacht\Contao\FlexibleSections\Dca\Layout',
    'loadSectionLabels'
);
