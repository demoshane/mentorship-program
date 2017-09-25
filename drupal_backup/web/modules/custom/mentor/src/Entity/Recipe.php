<?php

namespace Drupal\mentor\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the recipe entity.
 *
 * @ingroup mentor
 *
 * @ContentEntityType(
 *   id = "recipe",
 *   label = @Translation("recipe"),
 *   base_table = "recipe",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "recipe_label",
 *     "uuid" = "uuid",
 *   },
 * )
 */

class Recipe extends ContentEntityBase implements ContentEntityInterface {
  
  /**
   * Gets the value for the recipe_image field of an recipe entity.
   */
  public function getImage() {
    return $this->get('recipe_image')->value;
  }
  /**
   * Sets the value for the recipe_image field of an recipe entity.
   */
  public function setImage($recipe_image) {
    $this->get('recipe_image')->value = $recipe_image;
    return $this;
  }
  /**
   * Gets the value for the recipe_body field of an recipe entity.
   */
  public function getBody() {
    return $this->get('recipe_body')->value;
  }
  /**
   * Sets the value for the body field of an recipe entity.
   */
  public function setBody($body) {
    $this->get('recipe_body')->value = $body;
    return $this;
  }

  /**
   * Determines the schema for the base_table property defined above.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Advertiser entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Contact entity.'))
      ->setReadOnly(TRUE);

    // Name field for the recipe.
    $fields['recipe_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t("The recipe's name"))
      ->setDescription(t('The name of the recipe.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    // Body field for the recipe.
    $fields['recipe_body'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Body'))
      ->setDescription(t('A descriptive blurb for the recipe.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ));

    // Logo image field for the recipe.
    $fields['recipe_image'] = BaseFieldDefinition::create('uri')
      ->setLabel(t('Image'))
      ->setDescription(t('An image representing the feed.'))
      ->addPropertyConstraints('value', ['Image' => []]);
    return $fields;
  }
}
