<?php

namespace Drupal\mentor\Plugin\Block;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;
// Allows to use services.
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
// Needed for account proxy current user.
use Drupal\Core\Session\AccountProxyInterface;
// Needed by create.
use \Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block as training for mentorship program.
 * Lists roles
 * @Block(
 *   id = "mentor_roles",
 *   admin_label = @Translation("Mentor: Roles block")
 * )
 */
class MentorRolesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /** @var \Drupal\Core\Session\AccountProxyInterface $currentUser */
  // Protected as we don't want to allow change.
  protected $currentUser;


  /**
   * Constructs a new UserLoginBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user object.
   */
  // I must pass here everything that create has inside the container. Refer to UserLoginBlock.php
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $currentUser) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    // Here we assign AccountProxyInterface $currentUser to protected variable.
    $this->currentUser = $currentUser;
  }

  /**
   * {@inheritdoc}
   */
  // `create` defines menu what constructor eats. Refer to UserLoginBlock.php
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    // These are passed to __construct.
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      // How do I know what I can get?
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // I can use this as it's constructed in __construct.
    $roles = $this->currentUser->getRoles();
    $currentRoles = '';

    foreach($roles as $role) {
      $currentRoles .= $role . ', ';
    }
    
    $currentRoles = substr($currentRoles, 0, -2);

    $block = array(
      '#markup' => t("My Roles are: @roles", array('@roles' => $currentRoles)),
    );

    return $block;
  }
}
