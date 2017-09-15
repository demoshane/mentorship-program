<?php

namespace drupal\mentor\Controller;

use Drupal\Core\Controller\Controllerbase;

/**
 * Provides router controller.
 */
class MentorController extends Controllerbase {

  /**
   * Returns my example page.
   * @return Array
   *   Array of my contents.
   */
  public function examplePage() {
    $contents = array(
      '#markup' => "Naaahhhh...",
    );
    return $contents;
  }

  /**
   * Returns my example page.
   * @return Array
   *   Array of my contents.
   */
  public function examplePage2() {
    $contents = array(
      '#markup' => "Added another page as a tes within same controller..",
    );
    return $contents;
  }

}
