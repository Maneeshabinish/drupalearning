<?php

namespace Drupal\employees_record\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class SalaryAddForm extends FormBase {

 
  public function getFormId() {
    return 'salary_add_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['id'] = [
        '#type' => 'textfield',
        '#title' => t('Id'),
        '#required' => true,
        ];
    
    $form['month'] = [
    '#type' => 'textfield',
    '#title' => t('month'),
    '#required' => true,
    ];

    $form['year'] = [
    '#type' => 'number',
    '#title' => t('Year'),
    '#required' => true,
    ];

    $form['salary'] = [
    '#type' => 'number',
    '#title' => t('Salary'),
    '#required' => true,
    ];

    $form['submit'] = [
    '#type' => 'submit',
    '#value' => t('Submit'),
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

    // Extract the submitted values from the form state.
    $values = $form_state->getValues();

    // Create an array of data to be inserted into the custom table.
    $data = [
      'aid' => $values['id'],
      'month' => $values['month'],
      'year' => $values['year'],
      'salary' => $values['salary'],
    ];

    // Insert the data into the custom table.
    \Drupal::database()
      ->insert('person_salary') // Use the table name without the database prefix.
      ->fields($data)
      ->execute();

    $this->messenger()->addMessage($this->t('Your entry has beed successfully added.'));
    $form_state->setRedirect('employees_record.salarylist');
    
  }

}