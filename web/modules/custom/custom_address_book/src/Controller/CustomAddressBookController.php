<?php

namespace Drupal\custom_address_book\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Routing\UrlGeneratorInterface;

class CustomAddressBookController extends ControllerBase {

  protected $urlGenerator;

  public function __construct(UrlGeneratorInterface $urlGenerator) {
    $this->urlGenerator = $urlGenerator;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('url_generator')
    );
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
error_log($searchname);
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

}