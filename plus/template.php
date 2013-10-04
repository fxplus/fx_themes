<?php 

function plus_process_page(&$variables) {
  // display suite is handling page-node titles so that I can have short/long versions
  if (isset($variables['node']) && $variables['node']->type == 'page'){
    if (isset($variables['node']->field_longtitle['und'][0]['value'])) {
      $variables['title'] = $variables['node']->field_longtitle['und'][0]['value'];
    }
    if (isset($variables['node']->book) && $variables['node']->book['depth']) {
      $variables['title'] = NULL;
    } 
  }
}
function plus_preprocess_search_result(&$variables) {
  // use long (full) version of page title if available
  if (isset($variables['result']['node']->field_longtitle)) {
    $longtitle = ($variables['result']['node']->field_longtitle['und'][0]['value']);
    $variables['title'] = $longtitle;
  }
}

/*
function plus_css_alter(&$css) {
  dpm($css);
   // List of disabled drupal default css files.
   $disabled_drupal_css = array(
      // Remove jquery.ui css files.
      'misc/ui/jquery.ui.core.css',
      'misc/ui/jquery.ui.theme.css',
      'sites/all/themes/custom/fx_themes/plus/fontawesome/css/font-awesome.min.css',
      //  'misc/ui/jquery.ui.tabs.css',
   );
  // Remove drupal default css files.
  foreach ($css as $key => $item) {
     if (in_array($key, $disabled_drupal_css)) {
        // Remove css and its altered version that can be added by jquery_update.
        unset($css[$css[$key]['data']]);
        unset($css[$key]);
     }
  }
}*/

// process_page code for institutional cookie debug
// global $user;
// drupal_set_message($_SESSION['institution']);
// watchdog('bootstrapped', $user->uid.':'. $_SESSION['institution']);
// $variables['catalog_link'] = l('Search Catalogue', 'http://voyager.falmouth.ac.uk/', _get_button_attributes());