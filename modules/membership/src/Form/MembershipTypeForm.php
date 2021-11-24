<?php

namespace Drupal\membership\Form;

use Drupal\commerce\InlineFormManager;
use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\membership\Plugin\MembershipProviderManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Membership type form.
 */
class MembershipTypeForm extends EntityForm {

  /**
   * Membership provider manager.
   *
   * @var \Drupal\membership\Plugin\MembershipProviderManager
   */
  protected $pluginManager;

  /**
   * The inline form manager.
   *
   * @var \Drupal\commerce\InlineFormManager
   */
  protected $inlineFormManager;

  /**
   * Constructor.
   *
   * @param \Drupal\membership\Plugin\MembershipProviderManager $plugin_manager
   *   Membership provider manager.
   * @param \Drupal\commerce\InlineFormManager $inline_form_manager
   *   The inline form manager.
   */
  public function __construct(MembershipProviderManager $plugin_manager, InlineFormManager $inline_form_manager) {
    $this->pluginManager = $plugin_manager;
    $this->inlineFormManager = $inline_form_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.membership_provider'),
      $container->get('plugin.manager.commerce_inline_form')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    if (empty($this->pluginManager->getDefinitions())) {
      $form['warning'] = [
        '#markup' => $this->t('No membership provider plugins found. Please install a module which provides one.'),
      ];
      return $form;
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    /** @var \Drupal\membership\Entity\MembershipTypeInterface $membershipType */
    $membershipType = $this->entity;
    $plugins = array_column($this->pluginManager->getDefinitions(), 'label', 'id');
    asort($plugins);

    // Use the first available plugin as the default value.
    if (!$membershipType->getPluginId()) {
      $plugin_ids = array_keys($plugins);
      $plugin = reset($plugin_ids);
      $membershipType->setPluginId($plugin);
    }
    // The form state will have a plugin value if #ajax was used.
    $plugin = $form_state->getValue('plugin', $membershipType->getPluginId());
    // Pass the plugin configuration only if the plugin hasn't been changed via #ajax.
    $plugin_configuration = $membershipType->getPluginId() == $plugin ? $membershipType->getPluginConfiguration() : [];

    $wrapper_id = Html::getUniqueId('membership-type-form');
    $form['#prefix'] = '<div id="' . $wrapper_id . '">';
    $form['#suffix'] = '</div>';
    $form['#tree'] = TRUE;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#maxlength' => 255,
      '#default_value' => $membershipType->label(),
      '#required' => TRUE,
    ];
    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $membershipType->id(),
      '#machine_name' => [
        'exists' => '\Drupal\commerce_payment\Entity\PaymentGateway::load',
      ],
      '#disabled' => !$membershipType->isNew(),
    ];
    $form['plugin'] = [
      '#type' => 'radios',
      '#title' => $this->t('Plugin'),
      '#options' => $plugins,
      '#default_value' => $plugin,
      '#required' => TRUE,
      '#disabled' => !$membershipType->isNew(),
      '#ajax' => [
        'callback' => '::ajaxRefresh',
        'wrapper' => $wrapper_id,
      ],
    ];

    $inline_form = $this->inlineFormManager->createInstance('plugin_configuration', [
      'plugin_type' => 'membership_provider',
      'plugin_id' => $plugin,
      'plugin_configuration' => $plugin_configuration,
    ]);
    $form['configuration']['#inline_form'] = $inline_form;
    $form['configuration']['#parents'] = ['configuration'];
    $form['configuration'] = $inline_form->buildInlineForm($form['configuration'], $form_state);

    return $form;
  }

  /**
   * Ajax callback.
   */
  public static function ajaxRefresh(array $form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    /** @var \Drupal\membership\Entity\MembershipTypeInterface $membershipType */
    $membershipType = $this->entity;
    $membershipType->setPluginConfiguration($form_state->getValue(['configuration']));
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $this->entity->save();
    $this->messenger()->addMessage($this->t('Saved the %label membership type.', ['%label' => $this->entity->label()]));
    $form_state->setRedirect('entity.membership_type.collection');
  }

}
