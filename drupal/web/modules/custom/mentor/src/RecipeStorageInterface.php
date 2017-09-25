<?php

namespace Drupal\mentor;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\mentor\Entity\RecipeInterface;

/**
 * Defines the storage handler class for Recipe entities.
 *
 * This extends the base storage class, adding required special handling for
 * Recipe entities.
 *
 * @ingroup mentor
 */
interface RecipeStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Recipe revision IDs for a specific Recipe.
   *
   * @param \Drupal\mentor\Entity\RecipeInterface $entity
   *   The Recipe entity.
   *
   * @return int[]
   *   Recipe revision IDs (in ascending order).
   */
  public function revisionIds(RecipeInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Recipe author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Recipe revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\mentor\Entity\RecipeInterface $entity
   *   The Recipe entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(RecipeInterface $entity);

  /**
   * Unsets the language for all Recipe with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
