<?php

namespace Drupal\membership\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Plugin\DefaultSingleLazyPluginCollection;
use Drupal\membership\Plugin\MembershipProviderInterface;

/**
 * Defines the Membership type entity.
 *
 * @ConfigEntityType(
 *   id = "membership_type",
 *   label = @Translation("Membership type"),
 *   handlers = {
 *     "list_builder" = "Drupal\membership\MembershipTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\membership\Form\MembershipTypeForm",
 *       "edit" = "Drupal\membership\Form\MembershipTypeForm",
 *       "delete" = "Drupal\membership\Form\MembershipTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "\Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "membership_type",
 *   bundle_of = "membership",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "label",
 *     "id",
 *     "plugin",
 *     "configuration",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/membership_type/{membership_type}",
 *     "add-form" = "/admin/structure/membership_type/add",
 *     "edit-form" = "/admin/structure/membership_type/{membership_type}/edit",
 *     "delete-form" = "/admin/structure/membership_type/{membership_type}/delete",
 *     "collection" = "/admin/structure/membership_type"
 *   }
 * )
 */
class MembershipType extends ConfigEntityBase implements MembershipTypeInterface {

  /**
   * The Membership type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Membership type label.
   *
   * @var string
   */
  protected $label;

  /**
   * Plugin configuration.
   *
   * @var array
   */
  protected array $configuration = [];

  /**
   * The plugin ID.
   *
   * @var string
   */
  protected $plugin;

  /**
   * Plugin collection.
   *
   * @var \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection|null
   */
  protected ?DefaultSingleLazyPluginCollection $pluginCollection = NULL;

  /**
   * Gets the plugin collection that holds the membership provider plugin.
   *
   * Ensures the plugin collection is initialized before returning it.
   *
   * @return \Drupal\Core\Plugin\DefaultSingleLazyPluginCollection
   *   The plugin collection.
   */
  protected function getPluginCollection() {
    if (!$this->pluginCollection) {
      $plugin_manager = \Drupal::service('plugin.manager.membership_provider');
      $this->pluginCollection = new DefaultSingleLazyPluginCollection($plugin_manager, $this->plugin, $this->configuration);
    }
    return $this->pluginCollection;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginId(): ?string {
    return $this->plugin;
  }

  /**
   * The object's dependencies.
   *
   * @var array
   */
  protected $dependencies = [
    'membership',
  ];

  /**
   * {@inheritDoc}
   */
  public function setPluginId(string $plugin_id) {
    $this->plugin = $plugin_id;
    $this->configuration = [];
    $this->pluginCollection = NULL;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setPluginConfiguration(array $configuration) {
    $this->configuration = $configuration;
    $this->pluginCollection = NULL;
    return $this;
  }

  /**
   * Get the plugin.
   *
   * @return \Drupal\membership\Plugin\MembershipProviderInterface
   *   The config entity's backing plugin.
   */
  public function getPlugin(): MembershipProviderInterface {
    return $this->getPluginCollection()->get($this->plugin);
  }

  /**
   * {@inheritdoc}
   */
  public function getWorkflowId() {
    return $this->getPlugin()->getWorkflowId();
  }

  /**
   * {@inheritdoc}
   */
  public function setWorkflowId($workflow_id) {
    $this->workflow = $workflow_id;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginCollections() {
    return [
      'configuration' => $this->getPluginCollection(),
    ];
  }

  /**
   * @inheritDoc
   */
  public function shouldCreateNewRevision() {
    return TRUE;
  }

}
