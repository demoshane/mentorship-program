<?php

namespace Drupal\mentor;

/**
 * Class RecipeFetcher.
 *
 * Fetches Recipes and parses them.
 */
class RecipeFetcher implements RecipeFetcherInterface {

  protected $weightConverter;

  public function __construct(WeightConverterInterface $weightConverter) {
    $this->weightConverter = $weightConverter; // TODO: Why the fuck this is seen as no-argument?
  }

  /**
   * {@inheritdoc}
   */
  public function fetchRecipeFromUrl($url) {
    // Setup variable. NOTE: You can right click to refactor.
    $fetchedRecipe = array();

    // Initiate Guzzle httpClient.
    $client = \Drupal::httpClient();

    try {
      $response = $client->get($url);
      // Need to typecast this. Otherwise goes bonkers.
      $json_string = (string) $response->getBody();
      $fetchedRecipe = json_decode($json_string);
    }
    catch (RequestException $e) {
      watchdog_exception('mentor', $e->getMessage());
    }

    return $fetchedRecipe;
  }

  /**
   * {@inheritdoc}
   */
  public function parseRecipeJSON($recipe) {
    if($recipe->name) {
      // Get recipe name.
      $recipeName = $recipe->name;

      // Setup variable to avoid notices.
      $ingredientMarkup = '';

      // Parse ingredients.
      foreach ($recipe->ingredients as $ingredient => $amount) {
        // Name of ingredient.
        $ingredientName = ucfirst(str_replace('_', ' ', $ingredient));
        // Cups.
        $cups = $amount . ' ' . t('cups');
        // Gram conversion using our service.
        $grams = $this->weightConverter->convertToGrams($amount) . ' ' . t('grams');
        $ingredientMarkup .= '<p>' . $ingredientName . ': ' . $cups . ' / ' . $grams . '</p>';
      }

      $header = array(
        // We make it sortable by name.
        array('data' => t('Recipe'), 'field' => 'name', 'sort' => 'asc'),
        array('data' => t('Ingredients')),
      );

      $rows[] = array(
        'data' => array(
          'name' => $recipeName,
          'content' => $ingredientMarkup,
        )
      );

      // Generate the table.
      $parsedRecipe = array(
        '#theme' => 'table',
        '#header' => $header,
        '#rows' => $rows,
      );
    }

    return $parsedRecipe;
  }
}
