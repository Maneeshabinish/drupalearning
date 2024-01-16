<?php

namespace Drupal\employees_record\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\CacheBackendInterface;

/**
 * Implements a form to filter person information.
 */
class PersonalInfoForm extends FormBase {

  protected $database;
  protected $cacheBackend;

  public function __construct(Connection $database, CacheBackendInterface $cacheBackend) {
    $this->database = $database;
    $this->cacheBackend = $cacheBackend;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('cache.default')
    );
  }

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
    $form['filter_dropdown'] = [
      '#type' => 'select',
      '#title' => $this->t('Filter by'),
      '#options' => [
        'location' => $this->t('Location'),
        'age' => $this->t('Age'),
      ],
      '#ajax' => [
        'callback' => [$this, 'ajaxCallback'],
        'wrapper' => 'table-container',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Verifying entry...'),
        ],
      ],
    ];

    // Container for the dynamic table.
    $form['table_container'] = [
      '#prefix' => '<div id="table-container">',
      '#suffix' => '</div>',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle form submission if needed.
  }
  

  
  public function ajaxCallback(array &$form, FormStateInterface $form_state) {
 
    $data = [];

    // Implement your AJAX logic here.
    $selected_option = $form_state->getValue('filter_dropdown');
  
    // Check if data is already in cache.
  $cache_key = 'personal_info_cache_key_' . $selected_option;
  if ($cache = $this->cacheBackend->get($cache_key)) {
    $data = $cache->data;
  } else {
    // Fetch data based on the selected option.
    $data = $this->getData($selected_option);

    // Cache the data for future use.
    $this->cacheBackend->set($cache_key, $data, CacheBackendInterface::CACHE_PERMANENT, ['employees_record_cache_tag']);
  }

    // Build the dynamic table HTML.
    $table_html = '<table><thead><tr><th>' . ucfirst($selected_option) . '</th><th>' . $this->t('No. of Persons') . '</th></tr></thead><tbody>';

    foreach ($data as $item) {
        $table_html .= '<tr><td>' . $item['label'] . '</td><td>' . $item['count'] . '</td></tr>';
    }

    $table_html .= '</tbody></table>';

    // Replace the content of the table container with the updated table.
    $form['table_container']['table'] = [
        '#markup' => $table_html,
    ];

    return $form['table_container'];
    
  }

  
    
    /**
     * Helper function to fetch data based on the selected option.
     */
    private function getData($selected_option) {
      // fetch data from the database.
      // Adjust the query based on the selected option ('Age' or 'Location').
      // Return an array with 'label' and 'count' for each item.
    
      $data = [];
    
      //  Fetch age-wise data.
    if ($selected_option === 'age') {
      $query = $this->database->select('person', 'p')
        ->fields('p', ['age'])
        ->groupBy('p.age');
      $result = $query->execute();

      foreach ($result as $row) {
        $data[] = ['label' => $row->age, 'count' => $this->getCountForAge($row->age)];

      }

      return $data;
    }

    // Fetch location-wise data.
    elseif ($selected_option === 'location') {
      $query = $this->database->select('person', 'p')
        ->fields('p', ['location'])
        ->groupBy('p.location');
      $result = $query->execute();
      foreach ($result as $row) {
        $data[] = ['label' => $row->location, 'count' => $this->getCountForLocation($row->location)];

      }
    
      return $data;
    }
    
  }  
    
  private function getCountForAge($age) {
    // Implement logic to get the count for a specific age.
    $count = $this->database->select('person', 'pd')
        ->condition('age', $age)
        ->countQuery()
        ->execute()
        ->fetchField();
  
    return $count; 
  
  }
  
  private function getCountForLocation($location) {
    // Implement logic to get the count for a specific location.
    $count = $this->database->select('person', 'pd')
        ->condition('location', $location)
        ->countQuery()
        ->execute()
        ->fetchField();

    return $count;
  }
  
  
}

