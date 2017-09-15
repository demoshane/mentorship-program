<?php

namespace Drupal\mentor\Plugin\Block;

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
  public function build() {
    return array(
      '#markup' => t("Hello Mr. Raimonds."),
    );
  }
}
