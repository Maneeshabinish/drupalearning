<?php

namespace Drupal\employees_record\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Messenger\MessengerInterface;

class SalaryDeleteForm extends FormBase {
 
  public function getFormId() {
    return 'salary_delete_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {

    $form['id'] = [
      '#type' => 'hidden',
      '#value' => $id,
    ];

    $form['confirm'] = [
      '#type' => 'submit',
      '#value' => $this->t('Confirm Deletion'),
    ];

    $form['cancel'] = [
      '#type' => 'submit',
      '#value' => $this->t('Cancel'),
      '#submit' => ['::cancelForm'],
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Confirm Deletion button was clicked.
    $aid = $form_state->getValue('id');
    $this->deleteSalaryEntry($aid);

     // Display a success message.
     \Drupal::messenger()->addMessage($this->t('Salary entry deleted successfully.'));

    $form_state->setRedirect('employees_record.salarylist');
  }

  public function cancelForm(array &$form, FormStateInterface $form_state) {
    
    // Cancel button was clicked.
    $form_state->setRedirect('employees_record.salarylist');
  }

  protected function deleteSalaryEntry($aid) {
    
    // Delete the salary entry from the database.
    \Drupal::database()->delete('person_salary')
      ->condition('aid', $aid)
      ->execute();
  }
}
