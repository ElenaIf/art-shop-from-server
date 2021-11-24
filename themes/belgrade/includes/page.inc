<?php

/**
 * @file
 * Theme and preprocess functions for pages.
 */

/**
 * Adds theme path alias suggestion for use in system pages bundle.
 */

use Drupal\Component\Utility\Html;
use Drupal\node\NodeInterface;
use Drupal\taxonomy\Entity\Term;

/**
 * Implements hook_preprocess_HOOK() for page templates.
 */
function belgrade_preprocess_page(&$variables) {
  // Main container
  if (theme_get_setting('main_container_class')) {
    $main_container_class = explode(' ', theme_get_setting('main_container_class'));
    foreach ($main_container_class as $class) {
      $variables['attributes']['class'][] = Html::cleanCssIdentifier($class);
    }
  }

  if (theme_get_setting('main_container')) {
    $main_container = theme_get_setting('main_container');
    $variables['main_container'] = $main_container;
  }
}


function belgrade_theme_suggestions_page_alter(array &$suggestions, array $variables) {
  $current_path = \Drupal::service('path.current')->getPath();
  $result = \Drupal::service('path_alias.manager')->getAliasByPath($current_path);

  $path_alias = trim($result, '/');
  $path_alias = str_replace('/', '-', $path_alias);
  $path_alias = str_replace('-', '_', $path_alias);

  $suggestions[] = 'page__path__' . $path_alias;

  // Defines custom theme suggestions based on the route.
  $route_name = \Drupal::request()->attributes->get('_route');
  if ('system.404' === $route_name) {
    $suggestions[] = 'page__404';
  }
  if ('system.403' === $route_name) {
    $suggestions[] = 'page__403';
  }

  // * Adds page node type theme suggestion.
  if ($node = \Drupal::routeMatch()->getParameter('node')) {
    if ($node_revision = \Drupal::routeMatch()->getParameter('node_revision')) {
      if ($node_revision = \Drupal::entityTypeManager()->getStorage('node')->loadRevision($node_revision)) {
        $node = $node_revision;
      }
    }
    if ($node instanceof NodeInterface) {
      $suggestions[] = 'page__node__' . $node->getType();
    }
  }

  // * Add view mode theme suggestions based on the vocabulary
  if (\Drupal::routeMatch()->getRouteName() == 'entity.taxonomy_term.canonical' && $tid = \Drupal::routeMatch()->getRawParameter('taxonomy_term')) {
    $term = Term::load($tid);
    $suggestions[] = 'page__taxonomy__' . $term->getVocabularyId();
  }
}


/**
 * Implements hook_page_attachments_alter().
 */
function belgrade_page_attachments_alter(array &$page) {
  $activeThemeName = \Drupal::theme()->getActiveTheme()->getName();

  // Font libraries attachments
  $font = theme_get_setting('font_set');
  if ($font) {
    $page['#attached']['library'][] = $activeThemeName . '/font.' . $font;
  }

  // Belgrade icons.
  if (theme_get_setting('belgrade_icons') === 1) {
    $page['#attached']['library'][] = $activeThemeName . '/icons';
  }

  // Add Breakpoints to drupalSettings
  $breakpoints = \Drupal::service('breakpoint.manager')->getBreakpointsByGroup('bootstrap');

  if (!empty($breakpoints)) {
    $media_queries = [];
    foreach ($breakpoints as $id => $breakpoint) {
      $media_queries[$id] = $breakpoint->getMediaQuery();
    }
    $page['#attached']['drupalSettings']['responsive']['breakpoints'] = $media_queries;
  }
}
