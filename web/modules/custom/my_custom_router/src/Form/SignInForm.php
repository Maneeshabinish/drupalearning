<?php

namespace Drupal\my_custom_router\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class SignInForm extends FormBase {

 
  public function getFormId() {
    return 'custom_test_form';
  }

    public function buildForm(array $form, FormStateInterface $form_state) {
      $form['username'] = [

        '#type' => 'textfield',
        '#title' => $this->t('Username:'),
        '#required' => TRUE,
      ];
      $form['password'] = [

        '#type' => 'password',
        '#title' => $this->t('Password:'),
        '#required' => TRUE,
      ];
      $form['confirmPassword'] = [

        '#type' => 'password',
        '#title' => $this->t('Confirm Password:'),
        '#required' => TRUE,
      ];
      $form['submit'] = [

        '#type' => 'submit',
        '#value' => $this->t('Go'),
      ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $this->messenger()->addMessage($this->t('You have signed in successfully.'));
   
  }

}