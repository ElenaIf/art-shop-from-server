<?php

namespace Drupal\membership\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\search_api\Plugin\ConfigurablePluginInterface;

/**
 * Defines an interface for Membership provider plugins.
 */
interface MembershipProviderInterface extends PluginInspectionInterface, ConfigurablePluginInterface {

  /**
   * Get the workflow ID for memberships controlled by this provider.
   *
   * @return string
   */
  public function getWorkflowId(): string;

}
