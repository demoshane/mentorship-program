<?php

namespace drupal\mentor\Controller;

use Drupal\Core\Controller\Controllerbase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

// Implement my interface.
use Drupal\mentor\RecipeFetcherInterface;

/**
 * Provides router controller.
 */
class MentorController extends Controllerbase implements ContainerInjectionInterface {
  protected $recipeFetcher;
  public function __construct(RecipeFetcherInterface $recipeFetcher) {
    $this->recipeFetcher = $recipeFetcher;
  }

  // See reference from ContainerInjectionInterface.
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('mentor.recipe_fetcher')
    );
  }

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
  public function exampleJson($url) {
    $recipe = $this->recipeFetcher->fetchRecipeFromUrl($url);
    $parsedRecipe = $this->recipeFetcher->parseRecipeJSON($recipe);
    $contents[] = ['#markup' => 'Title here'];
    $contents[] = $parsedRecipe;
    return $contents;
  }

  /**
   * Returns my example page that uses argument.
   * @return Array
   *   Array of my contents.
   */
  public function examplePage2($name) {
    $contents = array(
      '#markup' => t("Hello, @name", array('@name' => $name)),
    );
    return $contents;
  }

}
