<?php

namespace Drupal\employees_record\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a CSV import form.
 */
class CsvImportForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'csv_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Add file upload field.
    $form['file_upload'] = [
      '#type' => 'file',
      '#title' => $this->t('Choose a CSV file to upload'),
      '#description' => $this->t('Supported file type: CSV'),
      '#required' => TRUE,
    ];

    // Add submit button.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Import CSV'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validate file upload if needed.
    $file = file_save_upload('file_upload', [
      'file_validate_extensions' => ['csv'],
    ]);

    if ($file === FALSE) {
      $form_state->setErrorByName('file_upload', $this->t('Invalid file format. Please upload a CSV file.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Start the batch process to import CSV data.
    $batch = array(
      'title' => t('CSV Import'),
      'operations' => array(
        array(array($this, 'processCsvBatch'), [$form_state->getValue('file_upload')]),
      ),
      'finished' => array($this, 'finishedCsvBatch'),
      'file' => 'mymodule.batch.inc',
    );
    batch_set($batch);
  }

  /**
   * Batch operation to process CSV data.
   */
  public function processCsvBatch($file_upload, &$context) {
    // Reading CSV file contents.
    $csv_data = $this->readCsv($file_upload);

    // Get the total number of rows for progress calculation.
    $total_rows = count($csv_data);

    // Process each row and import into the Person entity.
    foreach ($csv_data as $current_row => $row) {
      // Replace this with your entity creation logic.
      $this->createPersonEntity($row);

      // Example: Update progress.
      $context['message'] = t('Processed @current out of @total rows.', [
        '@current' => $current_row + 1,
        '@total' => $total_rows,
      ]);
      $context['finished'] = $this->calculateProgress($current_row, $total_rows);
    }
  }

  /**
   * Batch operation to be executed after CSV processing is finished.
   */
  public function finishedCsvBatch($success, $results, $operations) {
    if ($success) {
      drupal_set_message(t('CSV import completed successfully.'));
    }
    else {
      drupal_set_message(t('CSV import failed.'), 'error');
    }
  }

  /**
   * Helper function to read CSV data.
   * Replace this with your actual CSV reading logic.
   */
  protected function readCsv($file_upload) {
    $file_path = \Drupal::service('file_system')->realpath($file_upload->getFileUri());

    // Initialize an empty array to store CSV data.
    $csv_data = [];

    if (($handle = fopen($file_path, 'r')) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        // Add each row to the CSV data array.
        $csv_data[] = $data;
      }
      fclose($handle);
    }

    return $csv_data;
  }

  /**
   * Helper function to create a Person entity.
   * Replace this with your actual entity creation logic.
   */
  protected function createPersonEntity($row) {
    //The Person entity is defined with fields: name, id, location, and age.
    $person = \Drupal::entityTypeManager()->getStorage('person')->create([
      'name' => $row[0],  // Assuming name is in the first column.
      'id' => $row[1],    // Assuming id is in the second column.
      'location' => $row[2],  // Assuming location is in the third column.
      'age' => $row[3],   // Assuming age is in the fourth column.
    ]);

    $person->save();
  }

  /**
   * Helper function to calculate progress for the batch.
   */
  protected function calculateProgress($current_row, $total_rows) {
    // Calculate the progress percentage.
    return round(($current_row + 1) / $total_rows, 2) * 100;
  }
}

