<?php

/**
 * @file
 * Contains Drupal\service_swapper\EventSubscriber\RecipeapiEventSubscriber.
 */

namespace Drupal\service_swapper\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RecipeapiEventSubscriber implements EventSubscriberInterface {

  static function getSubscribedEvents() {
    $events['recipeapi.fetch'][] = array('onRecipeFetch', 0);
    return $events;
  }

  public function onRecipeFetch($event) {
    // Get current conf for alteration and handling.
    $conf = $event->getConfig();

    // Switch name to banana.
    $conf['name'] = 'banana';

    // Logs a notice of Recipe API use.
    $message = t('Recipe API was called via call' . ': ' . $conf['call']);
    \Drupal::logger('service_swapper')->notice($message);

    $event->setConfig($conf);
  }

}