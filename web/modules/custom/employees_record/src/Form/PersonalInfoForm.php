<?php

namespace Drupal\employees_record\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a form to filter person information.
 */
class PersonalInfoForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'personal_info_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Add a dropdown with options for 'Location' and 'Age'.
    $form['filter_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Filter by'),
      '#options' => [
        'location' => $this->t('Location'),
        'age' => $this->t('Age'),
      ],
      '#required' => TRUE,
    ];

    // Add a textfield for the filter value.
    $form['filter_value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Filter Value'),
      '#required' => TRUE,
    ];

    // Add a submit button.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    ];

    // Add a container to display the filtered results.
    $form['filtered_results'] = [
      '#markup' => '<div id="filtered-results"></div>',
    ];

    // Attach the necessary libraries for Ajax.
    $form['#attached']['library'][] = 'core/drupal.ajax';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get the submitted values.
    $filter_type = $form_state->getValue('filter_type');
    $filter_value = $form_state->getValue('filter_value');

    // Fetch and display the filtered results.
    $filtered_results = $this->getFilteredResults($filter_type, $filter_value);

    // Set the Ajax response to update the 'filtered-results' container.
    $form_state->setResponse(new AjaxResponse([
      'command' => 'replace',
      'selector' => '#filtered-results',
      'data' => $filtered_results,
    ]));
  }

  /**
   * Helper function to fetch filtered results based on the selected filter type and value.
   */
  protected function getFilteredResults($filter_type, $filter_value) {
   
    // fetch and display records from the 'person' table based on the filters.
    $query = \Drupal::database()->select('person', 'p')
      ->fields('p')
      ->condition($filter_type, $filter_value, '=')
      ->execute()
      ->fetchAll();

    $output = '<ul>';
    foreach ($query as $record) {
      // Display each record.
      $output .= '<li>' . $record->name . ' - ' . $record->id . ' - ' . $record->location . ' - ' . $record->age . '</li>';
    }
    $output .= '</ul>';

    return $output;
  }

}
