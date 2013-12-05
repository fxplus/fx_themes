<?php

/* we are using long/short title fields for page nodes */

/**
 * Override or insert variables into the page template.
 */
function bootstrapped_process_page(&$variables) {
  // display suite is handling page-node titles so that I can have short/long versions
  if (isset($variables['node']) && $variables['node']->type == 'page'){
    if (isset($variables['node']->field_longtitle['und'][0]['value'])) {
      $variables['title'] = $variables['node']->field_longtitle['und'][0]['value'];
    }
    if (isset($variables['node']->book) && $variables['node']->book['depth'] == 1) {
      $variables['title'] = NULL;
    } 
  }
  global $user;

  //drupal_set_message($_SESSION['institution']);
  //watchdog('bootstrapped', $user->uid.':'. $_SESSION['institution']);
  $variables['catalog_link'] = l('Search Catalogue', 'http://voyager.falmouth.ac.uk/', _get_button_attributes());

}

function bootstrapped_menu_link($variables) {
  if ($variables['element']['#original_link']['menu_name'] == 'menu-home-actions') {
    $element = $variables['element'];
    $output = l($element['#title'], $element['#href'], _get_button_attributes($variables['element']['#original_link']));
    //dpm($element);
    return $output."\n";
    // return '<li' . drupal_attributes($element['#attributes']) . '>'.$output."</li>\n";
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


// the call to action buttons on home page are just plain menu links
// they need bootstrap magic
function _get_button_attributes($menu_link = FALSE) {
  if (!$menu_link) {
    $attributes = array('attributes' => array(
      'class' => array('btn', 'btn-info', 'btn-large', 'catalog-link'),
    ));
    return $attributes;
  } else {
    // dpm($menu_link['mlid']);
    if (isset($menu_link['mlid'])) {
      // classes to apply to individual menu links
      switch($menu_link['mlid']) {
        case('854'): // Search catalog       
          $linkclass = array('btn', 'btn-info', 'btn-large');
          break;
        case('856'): // Search catalog       
          $linkclass = array('btn', 'btn-info', 'btn-large');
          break;
        case('2333'): // My Account (voyager)
          $linkclass = array();
          break;
        case('1753'): // Ask a librarian
          $linkclass = array('btn-success');
          break;
        default: 
          $linkclass = array('btn', 'btn-large', 'catalog-link');
          break;
      }
      // classes to apply to every link in a menu
      switch($menu_link['menu_name']) {
        case('menu-home-actions'):
          //$class = array('class' => array('btn', 'btn-call', 'btn-large', 'span3'));
          $menuclass = array('btn', 'btn-large', 'span2');
          break;
        default:
          $menuclass = array();
          break;
      }
      $classes = array_merge($linkclass, $menuclass);
      $attributes = array('attributes' => array('class' => $classes));
    }
  }
  return $attributes;
}

function bootstrapped_preprocess_node (&$variables) {

  /*
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
 * Template function for views_accordion style plugin
 *
 * @param array $vars
 *  Array of template variables.
 *
 * The JS file is loaded within render() in views_accordion_style_plugin.inc
 */
function bootstrapped_preprocess_views_view_accordion(&$vars) {
  // inherit the normal unformatted classes
  template_preprocess_views_view_unformatted($vars);
  $vars['use_group_header'] = $vars['options']['use-grouping-header'];
  // The template variable 'view_accordion_id' MUST be the same as $accordion_id in the render() function inside the style plugin
  // $vars['view_accordion_id'] = 'views-accordion2-'. $vars['view']->name .'-'.$vars['view']->current_display .'-header'; // Don't touch it or it will stop working
  // Add the css for fixing/preventing accordion issues
  drupal_add_css(drupal_get_path('module', 'views_accordion') .'/views-accordion.css');
}

function bootstrapped_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['search_block_form']['#title'] = t('Search website'); // Change the text on the label element
    /*
    $form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
    $form['search_block_form']['#size'] = 40;  // define size of the textfield
    $form['search_block_form']['#default_value'] = t('Search'); // Set a default value for the textfield
    $form['actions']['submit']['#value'] = t('GO!'); // Change the text on the submit button
    $form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/images/search-button.png');

    // Add extra attributes to the text box
    $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Search';}";
    $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == 'Search') {this.value = '';}";
    // Prevent user from searching the default text
    $form['#attributes']['onsubmit'] = "if(this.search_block_form.value=='Search'){ alert('Please enter a search'); return false; }";
    */
    // Alternative (HTML5) placeholder attribute instead of using the javascript
    $form['search_block_form']['#attributes']['placeholder'] = t('Search website');

  }
} 



