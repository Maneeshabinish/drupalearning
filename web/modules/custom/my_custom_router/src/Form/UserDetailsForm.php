<?php

namespace Drupal\my_custom_router\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class UserDetailsForm extends FormBase {

  public function getFormId() {

    return 'user_details_form';

  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['personal_details'] = [

      '#type' => 'fieldset',
      '#title' => $this->t('Personal Details'),
      
    ];

    $form['personal_details']['salutation'] = [

      '#type' => 'select',
      '#title' => $this->t('Salutation'),
      '#options' => [

        '--None--' => '--None--',
        'Mr.' => 'Mr.',
        'Ms.' => 'Ms.',
        'Mrs.' => 'Mrs.',
        'Dr.' => 'Dr.',
        'Prof.' => 'Prof.',

      ],
    ];

    $form['personal_details']['first_name'] = [

      '#type' => 'textfield',
      '#title' => $this->t('First name'),

    ];

    $form['personal_details']['last_name'] = [

      '#type' => 'textfield',
      '#title' => $this->t('Last name'),

    ];

    $form['personal_details']['gender'] = [

      '#type' => 'radios',
      '#title' => $this->t('Gender'),
      '#options' => [
        'male' => 'Male',
        'female' => 'Female',

      ],
    ];

    $form['personal_details']['email'] = [

      '#type' => 'email',
      '#title' => $this->t('Email'),

    ];

    $form['personal_details']['birth_date'] = [

      '#type' => 'date',
      '#title' => $this->t('Date of Birth'),

    ];

    $form['personal_details']['address'] = [

      '#type' => 'textarea',
      '#title' => $this->t('Address'),
      '#cols' => 30, 
      '#rows' => 3, 

    ];

    $form['submit'] = [

      '#type' => 'submit',
      '#value' => $this->t('Submit'),

    ];

    return $form;
  }

 
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $this->messenger()->addMessage($this->t('User details updated successfully.'));
  }
}
