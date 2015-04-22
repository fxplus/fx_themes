<?php 

// // add template (file) for fx_searchblock
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
  return array( 
    'fx_searchblock_block_form' => array(
      'render element' => 'form',
    ),
  );
}
/* 
 * theme function to customise display of the catalog/search box
 * (could equally be done via template+preprocess, or via hook_form_alter)
 */
function library_plus_fx_searchblock_block_form($variables) { 
  // removes wrapper div from search query textfield (req for bootstrap or OF)
  unset($variables['form']['fx_searchblock_form']['#theme_wrappers']);
  // open framework search block styling
  $variables['form']['fx_searchblock_form']['#title_display'] = 'invisible';
  $variables['form']['fx_searchblock_form']['#attributes']['class'][] = 'input-medium search-query';
  $variables['form']['fx_searchblock_form']['#attributes']['placeholder'] = t('Search the catalogue');
  $variables['form']['submit']['#attributes']['class'][] = 'btn-search';
  $variables['form']['submit']['#attributes']['alt'] = t('Search button');
  // unset($variables['form']['submit']['#value']);    
  $variables['form']['submit']['#type'] = 'image_button';
      // $form['submit']['#type'] = 'image_button';
  $variables['form']['submit']['#src'] = drupal_get_path('theme', 'open_framework') . '/images/searchbutton.png';
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
function library_plus_preprocess_block(&$variables) {
  if ($variables['block']->module == 'fx_searchblock') {
    $variables['attributes_array']['role'] = 'search';
  }
}

function library_plus_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'fx_searchblock_block_form') {
    // for some reason this will not take effect from the theme function (library_plus_fx_searchblock_block_form)
    $form['submit']['#type'] = 'image_button';
    // unset($form['fx_searchblock_block_form']['#theme_wrappers']);
    // $form['fx_searchblock_block_form']['#title_display'] = 'invisible';
    // $form['fx_searchblock_block_form']['#attributes']['class'][] = 'input-medium search-query';
    // $form['fx_searchblock_block_form']['#attributes']['placeholder'] = t('Search this site...');
    // $form['submit']['#attributes']['class'][] = 'btn-search';
    // $form['submit']['#attributes']['alt'] = t('Search button');
    // unset($form['actions']['submit']['#value']);    
    // $form['submit']['#src'] = drupal_get_path('theme', 'open_framework') . '/images/searchbutton.png';
  }
}


/*
 * Apply classes to blocks dynamically so that contexts/theme-settings
 * altered by admin will change layout 
 * cbc/block_class would do this, but theme and homepage specific
 */
function plus_preprocess_block(&$variables) {
  //dpm($variables['block']->bid);
  // dpm($variables['block']);
  $contexts = context_active_contexts();
  // dpm($contexts);
  if (module_exists('context')){
    if (isset($contexts['homepage_content'])) {
      switch ($variables['block']->bid) {
        case 'fx_searchblock-form':
          // Search the library
          $variables['classes_array'][] = 'span4';
          // $variables['classes_array'][] = 'well'; 
          break;
        case 'menu-menu-quick-links':
          // Quick Links
          $variables['classes_array'][] = 'span4';
          $variables['classes_array'][] = 'pull-left'; 
          break;
        case 'menu-menu-home-actions':
          // Calls to Action (account etc)
          $variables['classes_array'][] = 'span3';
          $variables['classes_array'][] = 'pull-right'; 
          break;
        case 'views-news_feed-block_4':
          // News and social media links
          $variables['classes_array'][] = 'span3'; 
          // $variables['classes_array'][] = 'well'; 
          $variables['classes_array'][] = 'pull-right'; 
          // $variables['classes_array'][] = 'well'; 
          break;
        case 'views-front_page_features-block_1':
          // featured content
          $variables['classes_array'][] = 'span4'; 
          // $variables['classes_array'][] = 'pull-right';
          break;
        case 'views-front_page_features-block_2':
          // long-term featured content
          $variables['classes_array'][] = 'span4'; 
          // $variables['classes_array'][] = 'pull-right';
          break;  
      }
    }
  }
}

/**
 * Implements hook_preprocess()
 */
function library_plus_preprocess_user_alert(&$vars) {
  $node = $vars['node'];
  $vars['importance'] = 'ua-'. $node->field_importance['und'][0]['value'];
  $vars['alert_label'] = variable_get('user_alert_label', 'User Alert');
  $vars['nid'] = $vars['node']->nid;
  // $vars['body'] = $vars['node']->body[$vars['node']->language][0]['value'];
  $vars['body'] = $vars['node']->field_message['und'][0]['value'];
  $vars['is_closeable'] = user_alert_cookie_is_valid();
  drupal_add_js(data, options);
}
