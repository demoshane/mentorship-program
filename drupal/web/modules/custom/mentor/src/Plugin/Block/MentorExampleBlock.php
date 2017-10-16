<?php

namespace Drupal\mentor\Plugin\Block;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;

// Needed by create: Container for the container and ContainerInterface for extracting (using) services.
use \Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;

// Implement my interface.
use Drupal\mentor\WeightConverterInterface;

/**
 * Provides a block as training for mentorship program.
 *
 * @Block(
 *   id = "mentor_example",
 *   admin_label = @Translation("Mentor: Example block")
 * )
 */
class MentorExampleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  // Add this as protected as it's used in __construct().
  protected $weightConverter;

  /**
   * Constructs a new MentorExampleBlock instance.
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
   * @param \Drupal\mentor\WeightConverterInterface $weight_converter
   *   TODO: Ask Raimonds. Is $weight_converter weight or interface here?
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, WeightConverterInterface $weight_converter) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weightConverter = $weight_converter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {

    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      // Need container to contain services. Add here service name from services.yml of my module.
      $container->get('mentor.weight_converter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['mentor'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Mentor'),
      '#description' => $this->t('Please input your name'),
      '#default_value' => !empty($this->configuration['mentor']) ? $this->configuration['mentor'] : '',
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '1',
    );
    $form['mentee'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Mentee'),
      '#description' => $this->t("Please input your mentee's name"),
      '#default_value' => !empty($this->configuration['mentee']) ? $this->configuration['mentee'] : 'no one',
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '2',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['mentee'] = $form_state->getValue('mentee');
    $this->configuration['mentor'] = $form_state->getValue('mentor');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Better way for this? F.ex. get all routes defined by module in routing?
    $mentee = !empty($this->configuration['mentee']) ? $this->configuration['mentee'] : 'no one';
    $mentor = !empty($this->configuration['mentor']) ? $this->configuration['mentor'] : '';
    $pages = '
    <ul>
        <li><a href="/mentorship/example-page">' . t('Example page') . '</a></li>
        <li><a href="/mentorship/example-page2/' . $mentor . '">' . t("Example page for mentor") . ' ' . $mentor . '</a></li>
        <li><a href="/mentorship/example-page2/' . $mentee . '">' . t("Example page for mentee") . ' ' . $mentee . '</a></li>
    </ul>';

    // Example of using conversion. I can call this now.
    $pages .= 'Conversion example: 5 cups is ' . $this->weightConverter->convertToGrams(5) . ' ' . 'grams.';
    $pages .= '<br>' . 'Conversion example: 500 grams is ' . $this->weightConverter->convertToCups(5) . ' ' . 'cups.';

    return array(
      '#markup' => '<p>' . t("Hello @mentor. You're mentor of @mentee. Welcome to the mentorship program both of you!", array('@mentor' => $mentor, '@mentee' => $mentee)) .
      '</p><p>' . t('Please see some example pages:') . $pages . '</p>',
    );
  }
}
