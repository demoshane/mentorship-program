<?php

namespace Drupal\mentor;
// use Drupal\mentor\WeightConverterInterface; <-- Not needed due read below.

/**
 * Why interface is not in use definition:
 * You don't need to add `use Drupal\Something` if your classes are in the same namespace.
 * Basically it means that if they are in the same folder (your class and your interface),
 * then you don't need to add `use ClassInterface` to your class.
 */

/**
 * Class WeightConverter.
 *
 * Converts units.
 */
class WeightConverter implements WeightConverterInterface {

  // No need to declare properties used below here as service should not store them. (Or anywhere).

  /**
   * {@inheritdoc}
   */
  public function convertToGrams($amount) {
    $convertedAmount = $amount * 340;
      return $convertedAmount;
  }

  /**
   * {@inheritdoc}
   */
  public function convertToCups($amount) {
    $convertedAmount = round((($amount / 340) * 100), 2);
    return $convertedAmount;
  }
}
