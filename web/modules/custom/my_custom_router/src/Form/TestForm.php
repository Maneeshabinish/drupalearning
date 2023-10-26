<?php

namespace Drupal\my_custom_router\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class TestForm extends FormBase {

 
  public function getFormId() {
    return 'custom_test_form';
  }

    public function buildForm(array $form, FormStateInterface $form_state) {
      $form['text'] = [

        '#type' => 'textfield',
        '#title' => $this->t('Enter Your Name:'),
        '#required' => TRUE,
      ];

      $options = [

        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'neutral' => $this->t('Neutral'),
    
      ];
      $form['choice'] = [

        '#type' => 'select',
        '#options' => $options,
        '#title' => $this->t('Gender:'),

      ];
     
      $form['age'] = [

        '#type' => 'number',
        '#title' => $this->t('Age:'),
        '#required' => TRUE,
        
      ];
      $form['email'] = [

        '#type' => 'email',
        '#title' => $this->t('Email:'),
        '#required' => TRUE,
        
      ];

      $form['address'] = [

        '#type' => 'textarea',
        '#title' => $this->t('Permenant Address:'),

      ];
    
      $options_radiobutton = array(
        'option1' => t('Exceptional'),
        'option2' => t('Very Good'),
        'option3' => t('Needs Improvement'),
        'option4' => t('Poor'),
      );
      $form['user_opinion'] = [

        '#type' => 'radios',
        '#title' => t('Rate the site content.'),
        '#options' => $options_radiobutton,
  
      ];
      $form['subscribe'] = [

        '#type' => 'checkbox',
        '#title' => t('Subscribe to our newsletter'),

      ];
      $form['submit'] = [

        '#type' => 'submit',
        '#value' => $this->t('Go'),
      ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->messenger()->addMessage($this->t('Hi %input, thanks for your input.',
    ['%input' => $form_state->getValue('text')]));

    $subscribe = $form_state->getValue('subscribe');

    if ($subscribe) {

      $this->messenger()->addMessage($this->t('You are subscribed to our newsletter.'));
      
    } 
  }

}