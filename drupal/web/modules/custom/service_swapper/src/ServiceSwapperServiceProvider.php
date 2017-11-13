<?php
namespace Drupal\service_swapper;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * class ServiceSwapperServiceProvider.
 *
 * Swaps Weight converter service from mentor module to new one.
 */
class ServiceSwapperServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    // Service to replace with namespace.service.
    if ($container->hasDefinition('mentor.weight_converter')) {
      $container->getDefinition('mentor.weight_converter')
        ->setClass(ServiceSwapperWeightConverter::class);
    }
  }
}