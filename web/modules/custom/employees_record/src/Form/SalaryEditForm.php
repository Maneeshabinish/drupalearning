<?php

namespace Drupal\employees_record\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class SalaryEditForm extends FormBase {
     
  public function getFormId() {
    return 'salary_edit_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {

    // Load the salary entry from the database based on the $aid parameter.
    
    $salary_entry = $this->loadSalaryEntry($id);

    // Load the name from the person table.

    $name = $this->loadPersonName($id);
    
    // Add form elements and prepopulate with data from $salary_entry.
    
    $form['id'] = [
      '#type' => 'textfield',
      '#title' => t('Id'),
      '#default_value' => $id,
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#default_value' => $name,
    ];    
    
    $form['month'] = [
      '#type' => 'textfield',
      '#title' => t('Month'),
      '#default_value' => $salary_entry->month,
    ];

    $form['year'] = [
      '#type' => 'number',
      '#title' => t('Year'),
      '#default_value' => $salary_entry->year,
    ];

    $form['salary'] = [
      '#type' => 'number',
      '#title' => t('Salary'),
      '#default_value' => $salary_entry->salary,
    ];   

    // Store the salary entry ID in a hidden field.
    $form['aid'] = [
      '#type' => 'hidden',
      '#value' => $id,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];
    
    return $form;
    
  }

  
  public function validateForm(array &$form, FormStateInterface $form_state) {

    // Validate the salary entry form fields.
    // Validate that the month is a valid month name.

    $month = $form_state->getValue('month');
    $valid_month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    if (!in_array($month, $valid_month_names)) {
      $form_state->setErrorByName('month', $this->t('Please enter a valid month name.'));
    }

    // Validate that the year is a valid year.
    $year = $form_state->getValue('year');
    if (!is_numeric($year) || $year < 1900 || $year>date('Y')) {
      $form_state->setErrorByName('year', $this->t('Please enter a valid year.'));
    }

    // Validate that the salary is a positive number.
    $salary = $form_state->getValue('salary');
    if (!is_numeric($salary) || $salary <= 0) {
      $form_state->setErrorByName('salary', $this->t('Please enter a valid positive salary amount.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Update the salary entry in the database based on the submitted values.
    $this->updateSalaryEntry($form_state->getValue('aid'), $form_state->getValues());

    // Redirect the user after saving.
    $form_state->setRedirect('employees_record.salarylist');
  }

  protected function loadSalaryEntry($id) {
 
    // Load the salary entry from the database and return it.
    $query = \Drupal::database()->select('person_salary', 'ps')
      ->fields('ps')
      ->condition('ps.aid', $id)
      ->execute();
    $result = $query->fetchObject(); 

    // Check if the query returned any results.
    if ($result ) {

      // Salary entry found.
      return $result;
    } else {

      // Salary entry not found.
      \Drupal::messenger()->addError(t('Salary entry not found.'));
      return null;
    }
  }

  
  protected function loadPersonName($id) {
    // Load the name from the person table based on the person ID.
    $query = \Drupal::database()->select('person', 'p')
      ->fields('p', ['name'])
      ->condition('p.id', $id)
      ->execute();
    $person = $query->fetchObject();

    return $person->name;
  }
  protected function updateSalaryEntry($id, array $values) {

    // Update the person_salary in the database based on the submitted values.
    $fields = [
    'aid' => $values['id'],
    'month' => $values['month'],
    'year' => $values['year'],
    'salary' => $values['salary'],
    ];

    \Drupal::database()->update('person_salary')
    ->fields($fields)
    ->condition('aid', $id)
    ->execute();

    // Update the person table with the new name.
    $person_fields = [
      'name' => $values['name'],
    ];

    \Drupal::database()->update('person')
      ->fields($person_fields)
      ->condition('id', $values['id'])
      ->execute();

    $this->messenger()->addMessage($this->t('Your entry has beed successfully updated.'));

  }
}
