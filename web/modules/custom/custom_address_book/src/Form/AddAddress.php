<?php

namespace Drupal\custom_address_book\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class AddAddress extends FormBase {
  

 
  public function getFormId() {
    return 'add_address';
  }

    public function buildForm(array $form, FormStateInterface $form_state) {

      $form['name'] = [
          '#type' => 'textfield',
          '#title' => t('Name'),
          '#required' => true,
          ];
      
      $form['email'] = [
      '#type' => 'email',
      '#title' => t('Email'),
      '#required' => true,
      ];
  
      $form['phone'] = [
      '#type' => 'tel',
      '#title' => t('Phone'),
      ];
  
      $form['dob'] = [
      '#type' => 'date',
      '#title' => t('Date of Birth'),
      ];
  
      $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit'),
      ];
      
      return $form;
  }

 

   public function submitForm(array &$form, FormStateInterface $form_state) {

      // Extract the submitted values from the form state.
  $values = $form_state->getValues();

  // Create an array of data to be inserted into the custom table.
  $data = [
    'name' => $values['name'],
    'email' => $values['email'],
    'phone' => $values['phone'],
    'dob' => $values['dob'],
  ];

  // Insert the data into the custom table.
  \Drupal::database()
    ->insert('address_entry') // Use the table name without the database prefix.
    ->fields($data)
    ->execute();

    $this->messenger()->addMessage($this->t('Hi %input, your entry has beed successfully added.',
    ['%input' => $form_state->getValue('name')]));

      
  }

}