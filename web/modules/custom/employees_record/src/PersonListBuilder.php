<?php

namespace Drupal\employees_record;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Events.
 *
 * @ingroup events
 */
class PersonListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    $header['location'] = $this->t('Location');
    $header['age'] = $this->t('Age');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\employees_record\Entity\Person $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.person.canonical',
      ['person' => $entity->id()]
    );  
    $row['location'] = $entity->location();
    $row['age'] = $entity->age();   
       
   
    return $row + parent::buildRow($entity);
  }
}