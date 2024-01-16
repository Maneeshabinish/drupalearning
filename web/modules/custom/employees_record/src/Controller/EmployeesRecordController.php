<?php

namespace Drupal\employees_record\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\employees_record\Form\CsvImportForm;
use Drupal\Core\Render\RendererInterface;


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
  protected $database;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * ImportController constructor.
   */
  public function __construct(FormBuilderInterface $formBuilder, Connection $database, RendererInterface $renderer) {
    $this->formBuilder = $formBuilder;
    $this->database = $database;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder'),
      $container->get('database'),
      $container->get('renderer')
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
    $form = $this->formBuilder->getForm(CsvImportForm::class);

    return [
      '#markup' => $this->renderer->render($form),
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
  public function salaryList() {

    $header = [
      'id' => $this->t('ID'),
      'name' => $this->t('Name'),
      'month' => $this->t('Month'),
      'year' => $this->t('Year'),
      'salary' => $this->t('Salary'),
    ];

    $rows = $this->buildSalaryRows();
 
    $table = [
      '#theme' => 'salary_list',
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

    $query = $this->database->select('person_salary', 'ps');
    $query ->innerjoin('person','p', 'p.id = ps.aid');
    $query ->fields('ps');
    $query ->fields('p', ['name']); 

    $records =  $query ->execute() ->fetchAll();
 
    $rows = [];
    foreach ($records as $record) {
      $rows[] = [
        'id' => $record->aid,
        'name' => $record->name, // Assuming 'name' is the field in the 'person' table.
        'month' => $record->month,
        'year' => $record->year,
        'salary' => $record->salary,
      ]; 
    }

    return $rows;
  }  

  /**
   * Returns the content for the personal-information page.
   */
  public function personalinfo() {

    // Build the form using the Form API.
    $form = \Drupal::formBuilder()->getForm('Drupal\employees_record\Form\PersonalInfoForm');

    return $form;
  }

 
}








