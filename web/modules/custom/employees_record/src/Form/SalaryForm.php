<?php

namespace Drupal\employees_record\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;



class SalaryForm extends FormBase {

  protected $database;
  protected $messenger;
 

  public function __construct(Database $database, MessengerInterface $messenger) {
    $this->database = $database;
    $this->messenger = $messenger;   

  }

  public function getFormId() {
    return 'salary_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $id = $form_state->getValue('aid');
    $operation = $form_state->getValue('operation');

    
    // If it's a delete operation and id is present, show confirmation button.
    if (!empty($id) && $operation === 'delete') {
      $form['confirm_deletion'] = [
        '#type' => 'submit',
        '#value' => t('Confirm Deletion'),
        '#submit' => ['::confirmDeletion'],
      ];

      // Create a container for the confirmation message.
      $form['confirmation_message'] = [
      '#markup' => t('Are you sure you want to delete this record?'),
      ];
    } else {

      // Common form elements
      $form['month'] = [
        '#type' => 'textfield',
        '#title' => t('Month'),
        '#required' => true,
      ];

      $form['year'] = [
        '#type' => 'number',
        '#title' => t('Year'),
      ];

      $form['salary'] = [
        '#type' => 'number',
        '#title' => t('Salary'),
      ];

      $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Submit'),
      ];

      // If it's an update operation, fetch existing data and set default values.
      if (!empty($id) && $operation === 'update') {
        $existing_data = $this->getExistingData($id);
        if ($existing_data) {
          $form['month']['#default_value'] = $existing_data->month;
          $form['year']['#default_value'] = $existing_data->year;
          $form['salary']['#default_value'] = $existing_data->salary;
        }
      }
    }
    return $form;
  }

    
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $salary = $form_state->getValue('salary');

    if (!is_numeric($salary) || $salary < 0) {
        \Drupal::messenger()->addError(t('Salary must be a positive number.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $aid = $form_state->getValue('aid');
    $month = $form_state->getValue('month');
    $year = $form_state->getValue('year');
    $salary = $form_state->getValue('salary');
    $operation = $form_state->getValue('operation');

    switch ($operation) {
      case 'add':
        $this->insertData($month, $year, $salary);
        \Drupal::messenger()->addMessage(t('Data inserted successfully.'));
        break;

      case 'update':
        $this->updateData($aid, $month, $year, $salary);
        \Drupal::messenger()->addMessage(t('Data updated successfully.'));
        break;

      case 'delete':
        $this->deleteData($aid);
        \Drupal::messenger()->addMessage(t('Data deleted successfully.'));
        break;
    }
  }

   // Helper function to insert data
   private function insertData($month, $year, $salary) {
    $data = [
      'month' => $month,
      'year' => $year,
      'salary' => $salary,
    ];

    $this->database->insert('person_salary')
      ->fields($data)
      ->execute();

    \Drupal::messenger()->addMessage(t('Data inserted successfully.'));
  }

  // Helper function to get existing data based on id
  private function getExistingData($id) {
    // Use your database query to fetch existing data based on $id
    // Adjust the query based on your database structure.
    $query = \Drupal::database()->select('person_salary', 'ps')
      ->fields('ps')
      ->condition('aid', $id)
      ->execute();

    return $query->fetchObject();
  }

  // Helper function to delete data based on aid
  private function deleteData($aid) {
    \Drupal::database()->delete('person_salary')
      ->condition('aid', $aid)
      ->execute();
  }
}