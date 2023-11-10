<?php

namespace Drupal\my_custom_router\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class SignInForm extends FormBase {

 
  public function getFormId() {
    return 'signin_form';
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
        '#description' => $this->t('Retype Password'),
        '#required' => TRUE,
      ];
      $form['submit'] = [

        '#type' => 'submit',
        '#value' => $this->t('Go'),
      ];
    return $form;
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {
    
    $username = $form_state->getValue('username');
    $password = $form_state->getValue('password');
    $confirm_password = $form_state->getvalue('confirmPassword');

  
    if (empty($username)) {
      $form_state->setErrorByName('username', $this->t('Username is required.'));
    }

    if (empty($password)) {
      $form_state->setErrorByName('password', $this->t('Password is required.'));
    }
    
    if($password !== $confirm_password) {
      $form_state->setErrorByName('confirmPassword', $this->t('Password mismatch'));
    }

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $this->messenger()->addMessage($this->t('You have signed in successfully.'));
   
  }

}