<?php

namespace Drupal\membership\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for adding memberships with optional selection of type.
 *
 * @package Drupal\membership\Controller
 */
class MembershipAddController extends ControllerBase {

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   Membership storage.
   * @param \Drupal\Core\Entity\EntityStorageInterface $type_storage
   *   Membership Type storage.
   */
    public function __construct(EntityStorageInterface $storage, EntityStorageInterface $type_storage) {
      $this->storage = $storage;
      $this->typeStorage = $type_storage;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
      /** @var EntityTypeManagerInterface $entity_type_manager */
      $entity_type_manager = $container->get('entity_type.manager');
      return new static(
        $entity_type_manager->getStorage('membership'),
        $entity_type_manager->getStorage('membership_type')
      );
    }

    /**
     * Displays add links for available bundles/types for entity membership.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The current request object.
     *
     * @return array
     *   A render array for a list of the membership bundles/types that can be added or
     *   if there is only one type/bunlde defined for the site, the function returns the add page for that bundle/type.
     */
    public function add(Request $request) {
      $types = $this->typeStorage->loadMultiple();
      if ($types && count($types) == 1) {
        $type = reset($types);
        return $this->addForm($type, $request);
      }
      if (count($types) === 0) {
        return array(
          '#markup' => $this->t('You have not created any %bundle types yet. @link to add a new type.', [
            '%bundle' => 'Membership',
            '@link' => new Link($this->t('Go to the type creation page'), Url::fromRoute('entity.membership_type.add_form')),
          ]),
        );
      }
      // @todo Just make this a list.
      /*
  foreach ($variables['content'] as $type) {
    $variables['types'][$type->id()] = array(
      'link' => Link::fromTextAndUrl($type->label(), new Url('entity.membership.add_form', array(
        'membership_type' => $type->id()
      ), array('query' => $query))),
      'description' => array(
      '#markup' => $type->label(),
      ),
      'title' => $type->label(),
      'localized_options' => array(
      'query' => $query,
      ),
    );
  }
       */
    }

    /**
     * Presents the creation form for membership entities of given bundle/type.
     *
     * @param EntityInterface $membership_type
     *   The custom bundle to add.
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The current request object.
     *
     * @return array
     *   A form array as expected by drupal_render().
     */
    public function addForm(EntityInterface $membership_type, Request $request) {
      $entity = $this->storage->create(array(
        'type' => $membership_type->id()
      ));
      return $this->entityFormBuilder()->getForm($entity);
    }

    /**
     * Provides the page title for this controller.
     *
     * @param EntityInterface $membership_type
     *   The custom bundle/type being added.
     *
     * @return string
     *   The page title.
     */
    public function getAddFormTitle(EntityInterface $membership_type) {
      return t('Create of bundle @label',
        array('@label' => $membership_type->label())
      );
    }

}
