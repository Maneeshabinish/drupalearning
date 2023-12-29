<?php

namespace Drupal\employees_record;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the person entity.
 *
 * @see \Drupal\employees_record\Entity\person.
 */
class PersonAccessControlHandler extends EntityAccessControlHandler {

    
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\employees_record\Entity\PersonInterface $entity */

    switch ($operation) {

      case 'view':     
    
        return AccessResult::allowedIfHasPermission($account, 'view person entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit person entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete person entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add person entities');
  }

}
