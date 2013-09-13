<?php 

function plus_menu_link($variables) {
  if ($variables['element']['#original_link']['menu_name'] == 'menu-home-actions') {
    $element = $variables['element'];
    $output = l($element['#title'], $element['#href'], _get_button_attributes($variables['element']['#original_link']));
    //dpm($element);
    return $output."\n";
    // return '<li' . drupal_attributes($element['#attributes']) . '>'.$output."</li>\n";
  } else {
    $element = $variables['element'];
    //dpm($element);
    return theme_menu_link($variables);
  }
}

function plus_process_page(&$variables) {
  // display suite is handling page-node titles so that I can have short/long versions
  if (isset($variables['node']) && $variables['node']->type == 'page'){
    if (isset($variables['node']->field_longtitle['und'][0]['value'])) {
      $variables['title'] = $variables['node']->field_longtitle['und'][0]['value'];
    }
    if (isset($variables['node']->book) && $variables['node']->book['depth'] < 3) {
      $variables['title'] = NULL;
    } 
  }
  global $user;

  //drupal_set_message($_SESSION['institution']);
  //watchdog('bootstrapped', $user->uid.':'. $_SESSION['institution']);
  //$variables['catalog_link'] = l('Search Catalogue', 'http://voyager.falmouth.ac.uk/', _get_button_attributes());

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