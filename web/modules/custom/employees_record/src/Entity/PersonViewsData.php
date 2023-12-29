<?php

namespace Drupal\employees_record\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Faq entities.
 */
class PersonViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}