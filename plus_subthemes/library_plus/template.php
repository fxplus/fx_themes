<?php 

// // add template for fx_searchblock
// function library_plus_theme() {
//   dpm('library_plus_theme');
//   return array( 
//     'fx_searchblock_block_form' => array(
//       'render element' => 'form',
//       // 'path' => drupal_get_path('theme', 'library_plus') . '/templates',
//       'template' => 'templates/fx-searchblock-block-form',
//       ),
//     );
// }

// add theme function for fx_searchblock
function library_plus_theme() {
  dpm('library_plus_theme');
  return array( 
    'fx_searchblock_block_form' => array(
      'render element' => 'form',
    ),
  );
}
function library_plus_fx_searchblock_block_form($variables) {
  dpm('library_plus_fx_searchblock_block_form');
  return drupal_render_children($variables['form']);
}

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
  if ((arg(0) == 'resources' || arg(0) == 'journals') && arg(1) == 'list') {
    drupal_add_js(drupal_get_path('theme', 'library_plus') .'/js/resource-list-info.js');
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
          $menuclass = array('btn', 'btn-large', 'span12', 'pull-right');
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

/* Search Form Block (taken from open_framework) */
// function library_plus_preprocess_block(&$variables) {
//   if ($variables['block']->module == 'fx_searchblock') {
//     $variables['attributes_array']['role'] = 'search';
//   }
// }

// function library_plus_form_alter(&$form, &$form_state, $form_id) {
//   if ($form_id == 'fx_searchblock_block_form') {
//     $form['fx_searchblock_block_form']['#title_display'] = 'invisible';
//     $form['fx_searchblock_block_form']['#attributes']['class'][] = 'input-medium search-query';
//     $form['fx_searchblock_block_form']['#attributes']['placeholder'] = t('Search this site...');
//     $form['actions']['submit']['#attributes']['class'][] = 'btn-search';
//     $form['actions']['submit']['#attributes']['alt'] = t('Search button');
//     unset($form['actions']['submit']['#value']);    
//     $form['actions']['submit']['#type'] = 'image_button';
//     $form['actions']['submit']['#src'] = drupal_get_path('theme', 'open_framework') . '/images/searchbutton.png';
//   }
// }


/*
 * Apply classes to blocks dynamically so that contexts/theme-settings can be altered
 * by admin to change layout disabled because contrib module
 * cbc will this, [dev] admin of multiple blocks could be a pain through ui
 * see cbc_set_block_classes to alter through code
 * (https://www.drupal.org/project/cbc)
 */
// function plus_preprocess_block(&$variables) {
  // dpm($variables['block']->bid);
  // dpm($variables);
  // $blockclasses = array(
  //   'fx_searchblock-form' => 'span4',
  //   'menu-menu-quick-links' => 'span4',
  //   'menu-menu-home-actions' => 'span4',
  //   );
  // $classblocks = array_flip($blockclasses);
  // if ($variables['block']->bid === 'fx_searchblock-form') {
  //   // dpm($variables);
  //   $variables['classes_array'][] = 'span4';
  //   // dpm($variables);
  //   // do something for this block
  // }
// }