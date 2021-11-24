<?php

/**
 * @file
 * Custom theme hooks.
 */

/**
 * Implements hook_theme_suggestions_HOOK_alter().
 */
function belgrade_theme_suggestions_commerce_product_alter(array &$suggestions, array $variables) {
  // View mode and theme settings
  $view_mode = $variables['elements']['#view_mode'];
  $display = theme_get_setting('product_teaser');

  // Limiting to catalog display mode
  if ($display) {
    switch($view_mode) {
      case 'catalog':
        $suggestions[] = 'commerce_product__' . $view_mode . '__' . $display;
        break;
    }
  }
}
