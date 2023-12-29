<?php

namespace Drupal\employees_record\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Drupal\mymodule\Form\ImportForm;
use Drupal\Core\Database\Connection;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormBuilderInterface;



class EmployeesRecordController extends ControllerBase {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

/**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */

  /**
   * ImportController constructor.
   */
  public function __construct(FormBuilderInterface $formBuilder, Connection $database) {
    $this->formBuilder = $formBuilder;
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder'),
      $container->get('database')
    );
  }

  /**
   * Page callback for the import page.
   */
  public function importPage() {

    // Check access for the import page.
    $access_result = $this->checkAccess($this->currentUser());

    if ($access_result->isForbidden()) {
      // Redirect or show an error message.
      \Drupal::messenger()->addMessage(t('You do not have permission to access the import page.'), 'error');
      return $this->redirect('<front>');
    }

    // Render the file upload form.
    $form = $this->formBuilder->getForm(ImportForm::class);

    return [
      '#markup' => render($form),
    ];
  }

  /**
   * Check access for the import page.
   */
  public function checkAccess(AccountInterface $account) {
    // Check if the user has the 'file_uploader' role.
    if ($account->hasRole('file_uploader')) {
      return AccessResult::allowed();
    }

    return AccessResult::forbidden();
  }

   /**
   * Returns a list of salaries along with related person information.
   *
   * @return array
   *   The render array representing the page.
   */
  public function salaryList(Request $request) {
    $header = [
      'id' => $this->t('ID'),
      'name' => $this->t('Name'),
      'month' => $this->t('Month'),
      'year' => $this->t('Year'),
      'salary' => $this->t('Salary'),
    ];

    $rows = $this->buildSalaryRows();

    $table = [
      '#theme' => 'salary_listing',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No entries found'),
    ];

    return $table;
  }
  /**
   * Builds rows for the salary list table.
   *
   * @return array
   *   An array of rows for the salary list table.
   */
  protected function buildSalaryRows() {

    $query = $this->database->select('person_salary', 'ps')
      ->fields('ps', ['aid', 'month', 'year', 'salary'])
      ->fields('p', ['name']) // Assuming 'name' is the field in the Person entity you want to display.
      ->condition('ps.aid', 'p.id') // Join condition between person_salary and Person entities.
      ->extend('TableSort')
      ->orderByHeader($this->header)
      ->limit(50)
      ->addTag('node_access')
      ->execute();

    $rows = [];

    foreach ($query as $row) {
      $rows[] = [
        'id' => $row->aid,
        'name' => $row->name,
        'month' => $row->month,
        'year' => $row->year,
        'salary' => $row->salary,
      ];
    }

    return $rows;
  }

}








