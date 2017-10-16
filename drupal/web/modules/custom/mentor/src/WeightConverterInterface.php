<?php
namespace Drupal\mentor;

/**
 * Interface WeightConverterInterface
 * @package Drupal\mentor
 * This works as table of contents that WeightConverter.php implementing this interface must define at minimum.
 * In this case, two converter functions.
 */
interface WeightConverterInterface {
  public function convertToGrams($amount);
  public function convertToCups($amount);
}
