<?php

$GLOBALS['TL_DCA']['tl_article']['fields']['inColumn']['load_callback'][] = array(
    'Netzmacht\Contao\FlexibleSections\Dca\Article',
    'loadSectionLabels'
);
