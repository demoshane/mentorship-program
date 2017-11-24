<?php

namespace Drupal\service_swapper;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeAccessControlHandler;

/**
 * Defines the custom access control handler for the node entity type.
 */
class ServiceSwapperAccessControlHandler extends NodeAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $node, $operation, AccountInterface $account) {
    $status = $node->isPublished();
    $uid = $node->getOwnerId();
    $hour = date("H");

    // Allow users to view nodes only during odd hours, what and odd logic.
    if($operation === 'view' && ($hour % 2) != 1) {
      return AccessResult::forbidden();
    }

    // Check if authors can view their own unpublished nodes.
    if ($operation === 'view' && !$status && $account->hasPermission('view own unpublished content') && $account->isAuthenticated() && $account->id() == $uid) {
      return AccessResult::allowed()->cachePerPermissions()->cachePerUser()->addCacheableDependency($node);
    }

    // Evaluate node grants.
    return $this->grantStorage->access($node, $operation, $account);
  }
}
