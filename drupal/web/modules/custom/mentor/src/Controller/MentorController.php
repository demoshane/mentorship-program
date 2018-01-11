<?php

namespace drupal\mentor\Controller;

use Drupal\Core\Controller\Controllerbase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\mentor\RecipeEvent;

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

  /**
   * Returns my example page that uses argument.
   * @return Array
   *   Array of my contents.
   */
  public function recipeAPI($call, $url) {
    $recipe = $this->recipeFetcher->fetchRecipeFromUrl($url);
    $parsedRecipe = $this->recipeFetcher->parseRecipeJSON($recipe);

    // Dispatch event.
    $dispatcher = \Drupal::service('event_dispatcher');

    // For testing purposes I want to do some actual alteration too.
    $config = array('name' => 'test', 'url' => $url, 'call' => $call);

    // Create new RecipeEvent object.
    $recipe = new RecipeEvent($config);

    $event = $dispatcher->dispatch('recipeapi.fetch', $recipe);

    $newData = $event->getConfig();

    if($call == 'first') {
      $contents['title'] = ['#markup' => 'First recipe'];
      $contents['recipe'] = $parsedRecipe;
      if(!empty($newData['name']) && $newData['name'] != $config['name']) {
        $contents['name'] = ['#markup' => t('Altered name via dispatcher / listener. New name') . ': ' . $newData['name']];
      }
    }
    elseif ($call == 'last') {
      $contents['title'] = ['#markup' => 'Last recipe'];
      $contents['recipe'] = $parsedRecipe;
    }
    return $contents;
  }
}
