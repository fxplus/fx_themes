<?php

/**
 * Override or insert variables into the html template.
 */
function bootstriped_preprocess_html(&$variables) {
  drupal_add_css('http://fonts.googleapis.com/css?family=Quicksand|Raleway|Open+Sans:400,800', array('type' => 'external'));
}

/**
 * Override or insert variables into the page template.
 */
function bootstriped_preprocess_page(&$variables) {
  // display suite is handling page-node titles so that I can have short/long versions
  if (isset($variables['node']) && $variables['node']->type == 'page'){
    if (isset($variables['node']->field_longtitle['und'][0]['value'])) {
      $variables['title'] = $variables['node']->field_longtitle['und'][0]['value'];
    }
    if (isset($variables['node']->book) && $variables['node']->book['depth'] == 1) {
      $variables['title'] = NULL;
    } 
  }
  // add more info js to hide/reveal resources list entries
  if (arg(0) == 'resources' && arg(1) == 'list') {
    drupal_add_js(drupal_get_path('theme', 'bootstriped') .'/js/bootstriped-info.js');
  }
  drupal_add_js(drupal_get_path('theme', 'bootstriped') .'/bootstriped.js');
  global $user;
  //drupal_set_message($_SESSION['institution']);
  //watchdog('bootstriped', $user->uid.':'. $_SESSION['institution']);
  $variables['catalog_link'] = l('Search Catalogue', 'http://voyager.falmouth.ac.uk/', _get_button_attributes());
}


/* we are using long/short title fields for page nodes */

function bootstriped_menu_link($variables) {
  if ($variables['element']['#original_link']['menu_name'] == 'menu-home-actions') {
    $element = $variables['element'];
    $output = l($element['#title'], $element['#href'], _get_button_attributes($variables['element']['#original_link']));
    //$element['#attributes']['class'][] = 'pull-right';
    return '<li' . drupal_attributes($element[ '#attributes' ]) .'>'.$output."</li>\n";
  } elseif ($variables['element']['#original_link']['menu_name'] == 'book-toc-151' && $variables['element']['#original_link']['depth'] > 3) {
    /* add arrow icons to subelements of book menu (right sidebar)  */
    $element = $variables['element'];
    $sub_menu = '';
    if ($element[ '#below' ]) {
      $sub_menu = drupal_render($element[ '#below' ]);
    }
    $output = l($element[ '#title' ], $element[ '#href' ], $element[ '#localized_options' ]);
    return '<li' . drupal_attributes($element[ '#attributes' ]) . '><i class="icon-angle-right"></i>'. $output . $sub_menu . "</li>\n";
  } else {
    $element = $variables['element'];
    //dpm($element);
    return theme_menu_link($variables);
  }
}

/**
 * Overide Bootstrap theme - Adds the search form's submit button right after the input element.
 *
 * @ingroup themable
 */

/* end Overide Bootstrap theme */

function bootstriped_preprocess_node (&$variables) {
  // 'add comment' will be displayed by a views block instead
  unset($variables['content']['links']['comment']);
  $variables['content']['links']['#attributes']['class'][] = 'admin-element';

  /* maybe should use book child pages to keep structure/ordering, and just hide menu items with js?
  // if this is an FAQ style node, replace the book add child link with add/question + prepop ref
  if (isset($variables['field_tags']['und']) && is_array($variables['field_tags']['und'])) {
    // dpm($variables);
    foreach($variables['field_tags']['und'] as $term)  {
      if ($term['tid'] == '12') {
        //dpm($variables['content']['links']['book']['#links']);
        $variables['content']['links']['book']['#links']['book_add_child']['href'] = 'node/add/page';
        $variables['content']['links']['book']['#links']['book_add_child']['query']['field_parent'] = $variables['nid'];
        unset($variables['content']['links']['book']['#links']['book_add_child']['query']['parent']);
        $variables['content']['links']['book']['#links']['book_add_child']['title'] = '+Q';
      }
    }
  }
  */

}

/**
 * Preprocess variables for region.tpl.php
 *
 * @see region.tpl.php
 */
function bootstriped_preprocess_region(&$variables, $hook) {
  if ($variables['region'] == 'content') {
    $variables['theme_hook_suggestions'][] = 'region__no_wrapper';
  }
  
  // dpm($variables);
  /* remove 'well' from left sidebar (may not always be number 2!) */
  if ($variables['region'] == "sidebar_first") {
    unset($variables['classes_array'][2]);
  }
  if ($variables['region'] == "header") {
    $variables['classes_array'][] = 'row';
  }
}


  /**
 * Template function for views_accordion style plugin
 *
 * @param array $vars
 *  Array of template variables.
 *
 * The JS file is loaded within render() in views_accordion_style_plugin.inc
 */
function bootstriped_preprocess_views_view_accordion(&$vars) {
  // inherit the normal unformatted classes
  template_preprocess_views_view_unformatted($vars);
  $vars['use_group_header'] = $vars['options']['use-grouping-header'];
  // The template variable 'view_accordion_id' MUST be the same as $accordion_id in the render() function inside the style plugin
  // $vars['view_accordion_id'] = 'views-accordion2-'. $vars['view']->name .'-'.$vars['view']->current_display .'-header'; // Don't touch it or it will stop working
  // Add the css for fixing/preventing accordion issues
  drupal_add_css(drupal_get_path('module', 'views_accordion') .'/views-accordion.css');
}

// override 'nav' class added to menu - disrupted button behaviour
function bootstrap_menu_tree__menu_home_actions(&$variables) {
  return '<ul class="menu button-menu">' . $variables['tree'] . '</ul>';
}
/*
function bootstriped_node_view_alter(&$build) {
  $node = $build['#node'];
  if (!empty($node->nid)) {
    $build['#contextual_links']['node'] = array('node', array($node->nid));
  }
}
*/

/**
 * Adds the search form's submit button right after the input element.
 *
 * @ingroup themable
 */
function bootstriped_plus_search_form_wrapper(&$variables) {
  dpm('search form');
  $output = '<div class="input-append">';
  $output .= $variables['element']['#children'];
  $output .= '<button type="submit" class="btn">';
  $output .= '<i class="icon-search"></i>';
  $output .= '<span class="element-invisible">' . t('Search') . '</span>';
  $output .= '</button>';
  $output .= '</div>';
  return $output;
 }

