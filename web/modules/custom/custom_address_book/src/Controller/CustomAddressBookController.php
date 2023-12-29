<?php

namespace Drupal\custom_address_book\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Pager\PagerManagerInterface; 
use Drupal\Core\Link;
class CustomAddressBookController extends ControllerBase {

  protected $urlGenerator;
  protected $formBuilder;
  protected $renderer;
  protected $pagerManager;

  public function __construct(UrlGeneratorInterface $urlGenerator, PagerManagerInterface $pagerManager , FormBuilderInterface $formBuilder, RendererInterface $renderer) {
    $this->urlGenerator = $urlGenerator;
    $this->pagerManager = $pagerManager;
    $this->formBuilder = $formBuilder;
    $this->renderer = $renderer;
   
  }

  public static function create(ContainerInterface $container) {

    return new static(
      $container->get('url_generator'),
      $container->get('pager.manager'),
      $container->get('form_builder'),
      $container->get('renderer'),
      
    );
  }

  public function managepage() {

      
    $build = [];
  
    // Add form.
    $addForm = $this->formBuilder->getForm('\Drupal\custom_address_book\Form\AddAddressAjax');
    $build['add_form'] = $addForm;
    
   // Get the current page from the query parameters.
  $current_page = \Drupal::request()->query->get('page', 0);

  // Set the number of items per page.
  $items_per_page = 10;

  // Get total number of entries.
  $total_entries = $this->getTotalEntries();

  // Calculate the offset based on the current page and items per page.
  $offset = ($current_page) * $items_per_page;

  // Create a pager element.
  $pager = $this->pagerManager->createPager($total_entries, $items_per_page);

  // Get entries for the current page.
  $entries = $this->getEntries($items_per_page, $offset);
   
    $build['entries'] = [
      '#theme' => 'address_book_entries',
      '#header' => $this->getEntriesHeader(),
      '#rows' => $entries,
      '#prefix' => '<div id="entries-list-wrapper">',
      '#suffix' => '</div>',
           
        ];


    // Add the pager to the build array.
    $build['pager'] = [
      '#type' => 'pager',
    ];
 
    return $build;

  }
  public function getEntriesHeader(){


    $header = [
      'ID',
      'Name',
      'Email',
      'Phone',
      'Date of Birth',
    ];

    return $header;

  }
  // Add a method to get the total number of entries.
public function getTotalEntries() {
  $query = Database::getConnection()->select('address_entry', 'a');
  $query->addExpression('COUNT(*)');
  return $query->execute()->fetchField();
}

  public function getEntries($limit, $offset) {

    $offset = max(0, $offset);
    $query = Database::getConnection()->select('address_entry', 'a');
    $query->fields('a')
    ->range($offset, $limit)
    ->orderBy('aid', 'ASC');
    $result = $query->execute()->fetchAll();

    $rows = [];
    foreach ($result as $row) {
      $rows[] = [
        $row->aid,
        $row->name,
        $row->email,
        $row->phone,
        $row->dob,
      ];
    }
    
    return $rows;
  }


  public function addressEntries() {

    $query = Database::getConnection()->select('address_entry', 'a');
    $query->fields('a');
    $result = $query->execute()->fetchAll();

    // Create an HTML table for displaying the data.
    $rows = [];
    foreach ($result as $row) {
      $rows[] = [
        $row->aid,
        $row->name,
        $row->email,
        $row->phone,
        $row->dob,
      ];
    }

    $header = [
      'ID',
      'Name',
      'Email',
      'Phone',
      'Date of Birth',
    ];

    $output = [
      '#theme' => 'address_book_entries',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $output;
  }


  // public function editForm($aid) {
   
  //   $url = Url::fromRoute('custom_address_book.editaddress', ['aid' => $aid]);
  //   return new RedirectResponse($url->toString());
  // }

  public function searchresult($searchname) {

    $query = \Drupal::database()->select('address_entry', 'a');
    $query->fields('a', ['aid', 'name', 'email', 'phone', 'dob']);
    $query->condition('a.name', '%' . $searchname . '%', 'LIKE');
    $results = $query->execute();

    // Fetch the results.
    $searchresult = $results->fetchAll();

      // Process and display the search results as needed.
    if (!empty($searchresult)) {

      foreach ($searchresult as $result) {

        $rows[] = [
          $result->aid,
          $result->name,
          $result->email,
          $result->phone,
          $result->dob,
        ];

      }

      // Create a table to display the search results.
      $header = ['ID', 'Name', 'Email', 'Phone', 'Date of Birth'];

      $table = [
        '#theme' => 'address_book_entries',
        '#header' => $header,
        '#rows' => $rows,
      ];

      return $table;

    } else {
      // No matching results found.
      $output['search_results'] = [
        '#markup' => t('No matching results found.'),
      ];
      return $output;
    }

  }

  public function searchpage() {

    // Add form.
    $searchForm = $this->formBuilder->getForm('\Drupal\custom_address_book\Form\SearchAddressAjax');
    $build['search_form'] = $searchForm;

    return $build;

  }

}