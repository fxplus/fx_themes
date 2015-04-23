<?php 

/**
 * Implements theme_form_element.
 *
 * This is done to remove some cruft from search form that gets in the way 
 * of bootstap search button append
 */
function search_plus_form_element($variables) {
  $element = &$variables['element'];
  $element += array(
    '#title_display' => 'before',
  );
  // REMOVED WRAPPER DIV AND ALL form- CLASSES
  $output = '';
  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;
    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }
  if (!empty($element['#description'])) {
    $output .= '<div class="description">' . $element['#description'] . "</div>\n";
  }
  // REMOVED WRAPPER DIV
  return $output;
}
/**
 * Implements theme_button.
 *
 * This is done to make submit a button rather than input
 */
function search_plus_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));
  $element['#attributes']['class'][] = 'btn';
  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  if ($element['#value'] != 'Search') {
    $button = '<input' . drupal_attributes($element['#attributes']) . ' />';
  } else {
    $button = '<button' . drupal_attributes($element['#attributes']) . '><i class="icon-search"></i></button>';
  }
  return $button;
}
