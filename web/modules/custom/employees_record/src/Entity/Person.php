<?php

namespace Drupal\employees_record\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Person entity.
 *
 * @ingroup person
 *
 * @ContentEntityType(
 *   id = "person",
 *   label = @Translation("Person"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\employees_record\PersonListBuilder",
 *     "access" = "Drupal\employees_record\PersonAccessControlHandler",    
 *     "views_data" = "Drupal\employees_record\Entity\PersonViewsData", 
 *     "form" = {
 *       "default" = "Drupal\employees_record\Form\PersonForm",
 *       "add" = "Drupal\employees_record\Form\PersonForm",
 *       "edit" = "Drupal\employees_record\Form\PersonForm",
 *       "delete" = "Drupal\employees_record\Form\PersonDeleteForm"
 *     }, 
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider"
 *     }     
 *   },
 * links = {
 *     "canonical" = "/admin/structure/person/{person}",
 *     "add-form" = "/admin/structure/person/add",
 *     "edit-form" = "/admin/structure/person/{person}/edit",
 *     "delete-form" = "/admin/structure/person/{person}/delete",
 *     "collection" = "/admin/structure/person",
 *   },
 *   base_table = "person",
 *   translatable = FALSE, 
 *   admin_permission = "administer person entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uid" = "author_user_id",
 *   },
 *   
 * )
 */
class Person extends ContentEntityBase implements PersonInterface {

    use EntityChangedTrait;
    use EntityPublishedTrait;
  
    /**
     * {@inheritdoc}
     */
    public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
      parent::preCreate($storage_controller, $values);
      $values += [
        'author_user_id' => \Drupal::currentUser()->id(),
      ];
    }
  
    /**
     * {@inheritdoc}
     */
    public function getTitle() {
      return $this->get('title')->value;
    }
  
    /**
     * {@inheritdoc}
     */
    public function setTitle($title) {
      $this->set('title', $title);
      return $this;
    }
  
    /**
     * {@inheritdoc}
     */
    public function getCreatedTime() {
      return $this->get('created')->value;
    }
  
    /**
     * {@inheritdoc}
     */
    public function setCreatedTime($timestamp) {
      $this->set('created', $timestamp);
      return $this;
    }
  
    /**
     * {@inheritdoc}
     */
    public function getOwner() {
      return $this->get('author_user_id')->entity;
    }
  
    /**
     * {@inheritdoc}
     */
    public function getOwnerId() {
      return $this->get('author_user_id')->target_id;
    }
  
    /**
     * {@inheritdoc}
     */
    public function setOwnerId($uid) {
      $this->set('author_user_id', $uid);
      return $this;
    }
  
    /**
     * {@inheritdoc}
     */
    public function setOwner(UserInterface $account) {
      $this->set('author_user_id', $account->id());
      return $this;
    }
  
    /**
     * {@inheritdoc}
     */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);



     $fields['author_user_id'] = BaseFieldDefinition::create('entity_reference')
       ->setLabel(t('Authored by'))
       ->setDescription(t('The user ID of author of the contact.'))
       ->setRevisionable(TRUE)
       ->setSetting('target_type', 'user')
       ->setSetting('handler', 'default')
       ->setDisplayOptions('view', [
         'label' => 'above',
         'type' => 'author',
         'weight' => 0,
       ])
       ->setDisplayOptions('form', [
         'type' => 'entity_reference_autocomplete',
         'weight' => 5,
         'settings' => [
           'match_operator' => 'CONTAINS',
           'size' => '60',
           'autocomplete_type' => 'tags',
           'placeholder' => '',
         ],
       ])
       ->setDisplayConfigurable('form', TRUE)
       ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the person.'))     
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

      $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Id'))
      ->setDescription(t('The id of the person.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'integer',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'integer',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

      $fields['location'] = BaseFieldDefinition::create('string')
      ->setLabel(t('location'))
      ->setDescription(t('The location of the person.'))     
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

      $fields['age'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Age'))
      ->setDescription(t('The age of the person.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'integer',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'integer',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);  

   
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
}