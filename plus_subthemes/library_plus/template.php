<?php 

function library_plus_menu_link($variables) {
  if ($variables['element']['#original_link']['menu_name'] == 'menu-home-actions') {
    $element = $variables['element'];
    $output = l($element['#title'], $element['#href'], _library_plus_button_attributes($variables['element']['#original_link']));
    //dpm($element);
    return $output."\n";
    // return '<li' . drupal_attributes($element['#attributes']) . '>'.$output."</li>\n";
  } else {
    $element = $variables['element'];
    //dpm($element);
    return theme_menu_link($variables);
  }
}

function library_plus_process_page(&$variables) {
  if (arg(0) == 'resources' && arg(1) == 'list') {
    drupal_add_js(drupal_get_path('theme', 'plus') .'/js/resource-list-info.js');
  }
}

function _library_plus_button_attributes($menu_link = FALSE) {
  if (!$menu_link) {
    $attributes = array('attributes' => array(
      'class' => array('btn', 'btn-info', 'btn-large', 'catalog-link'),
    ));
    return $attributes;
  } else {
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
          $menuclass = array('btn', 'btn-large', 'span9', 'pull-right');
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