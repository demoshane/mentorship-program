<?php
namespace Drupal\mentor;

/**
 * Interface RecipeFetcherInterface.
 * @package Drupal\mentor
 * This works as table of contents that RecipeFetcher.php implementing this interface must define at minimum.
 */
interface RecipeFetcherInterface {
  public function fetchRecipeFromUrl($url);
  public function parseRecipeJSON($recipe);
}
