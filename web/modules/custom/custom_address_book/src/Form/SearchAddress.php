<?php

namespace Drupal\custom_address_book\Form;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SearchAddress extends FormBase {

    use StringTranslationTrait;

  public function getFormId() {
    return 'search_address';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['search_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search by name:'),
      '#required' => true,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $search_name = $form_state->getValue('search_name');
           
    $url = Url::fromRoute('custom_address_book.searchresult', ['searchname'=> $search_name]);
    $response = new RedirectResponse($url->toString());
    $response->send();
  }
}
