<?php

namespace Drupal\mentor\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteSubscriber.
 *
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Change path '/admin/content' to '/content'.
    if ($route = $collection->get('system.admin_content')) {
      $route->setPath('/content');
    }
  }
}
