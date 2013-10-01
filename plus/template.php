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

// process_page code for institutional cookie debug
// global $user;
// drupal_set_message($_SESSION['institution']);
// watchdog('bootstrapped', $user->uid.':'. $_SESSION['institution']);
// $variables['catalog_link'] = l('Search Catalogue', 'http://voyager.falmouth.ac.uk/', _get_button_attributes());