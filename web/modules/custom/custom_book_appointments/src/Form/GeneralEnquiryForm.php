<?php

namespace Drupal\custom_book_appointments\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

Class GeneralEnquiryForm extends FormBase {

    public function getFormId() {

        return "general_enquiry_form";
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

        $form['decription'] = [
            '#type' => 'textfield',
            '#title' => t('Description'),
            '#required' => true,
            
        ];

        

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('Add Address'),
        ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {

        $this->messenger()->addStatus($this->t('Form submitted successfully'));

    }
}