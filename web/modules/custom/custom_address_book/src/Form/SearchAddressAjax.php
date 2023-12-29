<?php

namespace Drupal\custom_address_book\Form;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AfterCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SearchAddressAjax extends FormBase {

    use StringTranslationTrait;

  public function getFormId() {
    return 'search_address_ajax';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    // $form['#theme'] = 'custom_form';
   
    $form['search_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search by name:'),
      '#required' => true,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Search'),
      '#ajax' => [
        'callback' => '::submitFormAjaxCallback',
        'event' => 'click',
        'wrapper' => 'search-result-wrapper', // The HTML ID of the element to be replaced.
      ]    
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle form submission if needed.
  }

  public function submitFormAjaxCallback(array &$form, FormStateInterface $form_state) {

 
   
      $response = new AjaxResponse();
  
      // Add a command to place a message after the form.
      $response->addCommand(new AfterCommand('search-result-wrapper', $this->t('Address Entry added successfully.')));
  
      return $response;
  
    }
  }

