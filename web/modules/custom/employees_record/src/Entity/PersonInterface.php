<?php

namespace Drupal\employees_record\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Person entities.
 *
 * @ingroup person
 */
interface PersonInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Person Title.
   *
   * @return string
   *   Title of the Person.
   */
  public function getTitle();

  /**
   * Sets the person.
   *
   * @param string $title
   *   The person title.
   *
   * @return \Drupal\employees_record\Entity\PersonInterface
   *   The called person entity.
   */
  public function setTitle($title);

  /**
   * Gets the Person creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Event.
   */
  public function getCreatedTime();

  /**
   * Sets the Person creation timestamp.
   *
   * @param int $timestamp
   *   The Person creation timestamp.
   *
   * @return \Drupal\employees_record\Entity\PersonInterface
   *   The called Person entity.
   */
  public function setCreatedTime($timestamp);

}