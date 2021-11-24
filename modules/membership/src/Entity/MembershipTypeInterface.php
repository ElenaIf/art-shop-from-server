<?php

namespace Drupal\membership\Entity;

use Drupal\Core\Entity\EntityWithPluginCollectionInterface;
use Drupal\Core\Entity\RevisionableEntityBundleInterface;

/**
 * Provides an interface for defining Membership type entities.
 */
interface MembershipTypeInterface extends RevisionableEntityBundleInterface, EntityWithPluginCollectionInterface {

  /**
   * @return string
   */
  public function getWorkflowId();

  /**
   * Getter for the plugin ID.
   *
   * @return string
   *   Plugin ID.
   */
  public function getPluginId(): ?string;

  /**
   * Set the plugin.
   *
   * @param string $plugin_id
   *   The plugin ID.
   *
   * @return $this
   */
  public function setPluginId(string $plugin_id);

  /**
   * Gets the payment gateway plugin configuration.
   *
   * @return array
   *   The membership provider plugin configuration.
   */
  public function getPluginConfiguration();

  /**
   * Sets the payment gateway plugin configuration.
   *
   * @param array $configuration
   *   The payment gateway plugin configuration.
   *
   * @return $this
   */
  public function setPluginConfiguration(array $configuration);

}
