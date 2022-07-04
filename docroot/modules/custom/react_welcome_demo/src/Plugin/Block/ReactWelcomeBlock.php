<?php

namespace Drupal\react_welcome_demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides Welcome block coming from React.
 *
 * @Block(
 *   id = "react_welcome",
 *   admin_label = @Translation("React Welcome")
 * )
 */
class ReactWelcomeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Current Active User.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * ReactWelcomeBlock constructor.
   *
   * @param array $configuration
   *   Configuration array.
   * @param string $plugin_id
   *   Plugin id.
   * @param mixed $plugin_definition
   *   Plugin definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   Current Active User.
   */
  public function __construct(array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              AccountProxyInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container,
                                array $configuration,
                                $plugin_id,
                                $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
    );
  }
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'show_login' => 'yes',
      'show_register' => 'yes',
      'show_my_account' => 'yes',
      'show_logout' => 'yes',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $configurable_links = [
      'show_login' => $this->t('Show Logout Link'),
      'show_register' => $this->t('Show Logout Link'),
      'show_my_account' => $this->t('Show Logout Link'),
      'show_logout' => $this->t('Show Logout Link'),
    ];

    foreach ($configurable_links as $key => $title) {
      $form[$key] = [
        '#type' => 'select',
        '#required' => TRUE,
        '#options' => [
          'yes' => $this->t('Yes'),
          'no' => $this->t('No'),
        ],
        '#title' => $title,
        '#default_value' => $config[$key],
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    foreach (array_keys($this->defaultConfiguration()) as $key) {
      $this->configuration[$key] = $values[$key];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $configuration = $this->getConfiguration();

    return [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['react-welcome-wrapper'],
        'data-userName' => $this->currentUser->getDisplayName(),
        'data-showlogin' => $configuration['show_login'],
        'data-showregister' => $configuration['show_register'],
        'data-showmyaccount' => $configuration['show_my_account'],
        'data-showlogout' => $configuration['show_logout'],
      ],
      '#attached' => [
        'library' => [
          'react_welcome_demo/react_welcome',
        ],
      ],
    ];
  }

  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), [
      'user',
    ]);
  }



}
