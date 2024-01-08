<?php

namespace Drupal\employees_record\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\Core\Form\FormBase;
use Drupal\file\FileInterface;

/**
 * Implements a CSV import form.
 */
class CsvImportForm extends FormBase {

  /**
   * {@inheritdoc}
   */

   protected $entityTypeManager;
   protected $formBuilder;

   /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, FormBuilderInterface $form_builder) {
    $this->entityTypeManager = $entity_type_manager;
    $this->formBuilder = $form_builder;
  } 
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('form_builder')
    );
  }

  
  public function getFormId() {
    return 'csv_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

   
    // Add file upload field.
    $form['file_upload'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Choose the File'),      
      '#upload_validators' => [
        'file_validate_extensions' => ['csv'],
      ],  
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

    $file_upload = $form_state->getValue('file_upload', 0);
    if (isset($file_upload[0]) && !empty($file_upload[0])) {
      $file = File::load($file_upload[0]);
      $file->setPermanent();
      $file->save();
    }

  // Check if the file entity exists and get its ID.
 
    $file_id = $file->id();
    error_log('File uploaded with ID: ' . $file_id);

    $csv_data = $this->readCsv($file);

  error_log('csv data'. print_r($csv_data, true));
    // Start the batch process to import CSV data.
    $operation = [];
    foreach($csv_data as $node_data){

      $operation[] = [
        '\Drupal\employees_record\Batch\CustomBatch::batchOperation',
        [$node_data]
      ];
    }  
    $batch =[
      'title' => t('Uploading'),
      'operations' => $operation,
      'finished' =>'\Drupal\employees_record\Batch\CustomBatch::batchFinished',
    ];

    batch_set($batch);
  }

  
 /**
 * Helper function to read CSV data.
 * Replace this with your actual CSV reading logic.
 */
protected function readCsv($file) {
   
  if ($file instanceof FileInterface) {
    // Get the file URI.
    $file_uri = $file->getFileUri();

    // Initialize an empty array to store CSV data.
    $csv_data = [];

    if (($handle = fopen($file_uri, 'r')) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        // Add each row to the CSV data array.
        $csv_data[] = $data;
      }
      fclose($handle);
    }

    return $csv_data;
  }

  return [];
}

}

