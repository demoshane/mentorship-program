<?php

namespace Drupal\mentor\Plugin\Block;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a block as training for mentorship program.
 *
 * @Block(
 *   id = "mentor_example",
 *   admin_label = @Translation("Mentor: Example block")
 * )
 */
class MentorExampleBlock extends BlockBase {

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
    return array(
      '#markup' => '<p>' . t("Hello @mentor. You're mentor of @mentee. Welcome to the mentorship program both of you!", array('@mentor' => $mentor, '@mentee' => $mentee)) .
      '</p><p>' . t('Please see some example pages:') . $pages . '</p>',
    );
  }
}
