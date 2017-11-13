<?php

namespace Drupal\service_swapper;
use Drupal\mentor\WeightConverterInterface;

/**
 * Class ServiceSwapperWeightConverter.
 *
 * Converts units. Replacement service. Dummy functionality to prove work.
 */
class ServiceSwapperWeightConverter implements WeightConverterInterface {

  /**
   * {@inheritdoc}
   */
  public function convertToGrams($amount) {
    $convertedAmount = $amount * 1000;
    return $convertedAmount;
  }

  /**
   * {@inheritdoc}
   */
  public function convertToCups($amount) {
    $convertedAmount = round((($amount / 1000) * 100), 2);
    return $convertedAmount;
  }
}
