<?php 

function search_plus_process_page(&$variables) {
  // display suite is handling page-node titles so that I can have short/long versions
  if (isset($variables['node']) && $variables['node']->type == 'page'){
    if (isset($variables['node']->field_longtitle['und'][0]['value'])) {
      $variables['title'] = $variables['node']->field_longtitle['und'][0]['value'];
    }
          // if this is the main book (ie the website not the referencing guide) 
    if ($variables['node']->book['menu_name'] == 'book-toc-1') {
      if (isset($variables['node']->book) && $variables['node']->book['depth'] < 3) {
        $variables['title'] = NULL;
      }
    } else {
      // do not display book title on top level page, as duplicates block title
      if (isset($variables['node']->book) && $variables['node']->book['depth'] < 2) {
        $variables['title'] = NULL;
      }
    }
  }
}

function search_plus_menu_link($variables) {
  if ($variables['element']['#original_link']['menu_name'] == 'menu-home-actions') {
    $element = $variables['element'];
    $output = l($element['#title'], $element['#href'], _search_plus_button_attributes($variables['element']['#original_link']));
    return $output."\n";
    // return '<li' . drupal_attributes($element['#attributes']) . '>'.$output."</li>\n";
  } else {
    $element = $variables['element'];
    return theme_menu_link($variables);
  }
}

function _search_plus_button_attributes($menu_link = FALSE) {
  if (!$menu_link) {
    $attributes = array('attributes' => array(
      'class' => array('btn', 'btn-info', 'btn-large', 'catalog-link'),
    ));
    return $attributes;
  } else {
    if (isset($menu_link['mlid'])) {
      // classes to apply to individual menu links
      switch($menu_link['mlid']) {
        case '595':
          $linkclass = array('btn', 'btn-large', 'btn-fxblue', 'catalog-link');
          break;
        case '1172':
          $linkclass = array('btn', 'btn-large', 'btn-fxolive', 'catalog-link');
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