<?php

namespace Drupal\mentor\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Recipe type entity.
 *
 * @ConfigEntityType(
 *   id = "recipe_type",
 *   label = @Translation("Recipe type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\mentor\RecipeTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\mentor\Form\RecipeTypeForm",
 *       "edit" = "Drupal\mentor\Form\RecipeTypeForm",
 *       "delete" = "Drupal\mentor\Form\RecipeTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\mentor\RecipeTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "recipe_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "recipe",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/recipe_type/{recipe_type}",
 *     "add-form" = "/admin/structure/recipe_type/add",
 *     "edit-form" = "/admin/structure/recipe_type/{recipe_type}/edit",
 *     "delete-form" = "/admin/structure/recipe_type/{recipe_type}/delete",
 *     "collection" = "/admin/structure/recipe_type"
 *   }
 * )
 */
class RecipeType extends ConfigEntityBundleBase implements RecipeTypeInterface {

  /**
   * The Recipe type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Recipe type label.
   *
   * @var string
   */
  protected $label;

}
