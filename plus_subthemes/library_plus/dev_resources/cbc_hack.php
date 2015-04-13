<?php

// set classes for blocks within contexts
// slightly simpler than clicking through ui

$context_block_classes = array(
    'homepage_content' => array(
        'fx_searchblock-form' => array(
            'span6',
        ),
        'menu-menu-quick-links' => array(
            'span3',
        ),
        'menu-menu-home-actions' => array(
            'span3',
        ),
    ),
);

cbc_set_block_classes($context_block_classes);