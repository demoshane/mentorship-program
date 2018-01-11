<?php

/**
 * @file
 * Contains Drupal\mentor\RecipeEvent.
 */

namespace Drupal\mentor;

use Symfony\Component\EventDispatcher\Event;

class RecipeEvent extends Event {

  protected $config;

  /**
   * Constructor.
   *
   * @param $config
   */
  public function __construct($config) {
    $this->config = $config;
  }

  /**
   * Getter for the config object.
   *
   * @return Config
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * Setter for the config object.
   *
   * @param $config
   */
  public function setConfig($config) {
    $this->config = $config;
  }

}