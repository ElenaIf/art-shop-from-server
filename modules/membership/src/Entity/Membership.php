<?php

namespace Drupal\membership\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\entity\Revision\RevisionableContentEntityBase;
use Drupal\membership\Exception\MembershipFeatureNotImplementedException;
use Drupal\user\UserInterface;

/**
 * Defines the Membership entity.
 *
 * @ingroup membership
 *
 * @ContentEntityType(
 *   id = "membership",
 *   label = @Translation("Membership"),
 *   label_singular = @Translation("Membership"),
 *   label_plural = @Translation("Memberships"),
 *   label_count = @PluralTranslation(
 *     singular = "@count membership",
 *     plural = "@count memberships",
 *   ),
 *   bundle_label = @Translation("Membership type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\membership\MembershipListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\membership\Form\MembershipForm",
 *       "add" = "Drupal\membership\Form\MembershipForm",
 *       "edit" = "Drupal\membership\Form\MembershipForm",
 *       "delete" = "Drupal\membership\Form\MembershipDeleteForm",
 *     },
 *     "access" = "Drupal\entity\EntityAccessControlHandler",
 *     "permission_provider" = "Drupal\entity\EntityPermissionProvider",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *       "revision" = "Drupal\entity\Routing\RevisionRouteProvider",
 *     },
 *   },
 *   base_table = "membership",
 *   revision_table = "membership_revision",
 *   data_table = "membership_field_data",
 *   revision_data_table = "membership_field_revision",
 *   admin_permission = "administer membership entities",
 *   field_ui_base_route = "entity.membership_type.edit_form",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "revision" = "vid",
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_user",
 *     "revision_created" = "revision_created",
 *     "revision_log_message" = "revision_log_message"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/membership/{membership}",
 *     "add-form" = "/admin/structure/membership/add/{membership_type}",
 *     "edit-form" = "/admin/structure/membership/{membership}/edit",
 *     "delete-form" = "/admin/structure/membership/{membership}/delete",
 *     "collection" = "/admin/structure/membership",
 *     "revision" = "/admin/structure/membership/{membership}/revisions/{membership_revision}/view",
 *     "version-history" = "/admin/structure/membership/{membership}/revisions",
 *   },
 *   bundle_entity_type = "membership_type"
 * )
 */
class Membership extends RevisionableContentEntityBase implements MembershipInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    if (empty($values['user_id'])) {
      $values['user_id'] = \Drupal::currentUser()->id();

    }
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->bundle();
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['type'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Type'))
      ->setDescription(t('The Membership type/bundle.'))
      ->setSetting('target_type', 'membership_type')
      ->setRequired(TRUE);
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The owner of the Membership entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\node\Entity\Node::getCurrentUserId')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    $fields['data'] = BaseFieldDefinition::create('map')
      ->setLabel(t('Data'))
      ->setReadOnly(TRUE)
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayConfigurable('view', FALSE);
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['state'] = BaseFieldDefinition::create('state')
      ->setLabel(t('State'))
      ->setDescription(t('The membership\'s state.'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'list_default',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRevisionable(TRUE)
      ->setSetting('workflow_callback', ['\Drupal\membership\Entity\Membership', 'getWorkflowId']);
    $fields['provider'] = BaseFieldDefinition::create('membership_provider_id')
      ->setLabel('Provider plugin/remote ID')
      ->setDisplayConfigurable('form', false)
      ->setDisplayConfigurable('view', false);

    return $fields;
  }

  /**
   * @inheritDoc
   */
  public function cancel() {
    // TODO: Implement cancel() method.
    throw new MembershipFeatureNotImplementedException('Membership Cancel method not implemented.');
  }

  /**
   * @inheritDoc
   */
  public function expireNotice() {
    // TODO: Implement expireNotice() method.
    throw new MembershipFeatureNotImplementedException('Membership Expire Notice method not implemented.');
  }

  /**
   * @inheritDoc
   */
  public function extend() {
    // TODO: Implement extend() method.
    throw new MembershipFeatureNotImplementedException('Membership Extend method not implemented.');
  }

  /**
   * @inheritDoc
   */
  public function isActive() {
    // TODO: Implement isActive() method.
    throw new MembershipFeatureNotImplementedException('Membership isActive method not implemented.');
  }


  /**
   * @inheritdoc
   */
  static public function getWorkflowId(MembershipInterface $membership) {
    $workflow = MembershipType::load($membership->bundle())->getWorkflowId();
    return $workflow;
  }

  /**
   * @inheritDoc
   */
  public function getProviderPlugin() {
    /** @var \Drupal\membership\Plugin\MembershipProviderManager $manager */
    $manager = \Drupal::service('plugin.manager.membership_provider');
    return $manager->getInstance($this->get('provider')->first()->getValue());
  }

}
