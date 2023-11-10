<?php

namespace Drupal\custom_address_book\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Database\Database;

/**
 * Provides a 'Birthday Listing Block' block.
 *
 * @TodaysBirthdayListingBlock(
 *   id = "birthday_block",
 *   admin_label = @Translation("Todays Birthday Listing Block"),
 *   category = @Translation("Custom")
 * )
 */
class TodaysBirthdayListingBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get today's date.
    $today = \Drupal::time()->getCurrentTime();
    $today_date = date('Y-m-d', $today);

    // Query the database for birthdays today.
    $query = \Drupal::database()->select('address_entry', 'a')
      ->fields('a', ['name', 'dob'])
      ->condition('a.dob', $today_date . '%', 'LIKE')
      ->execute();

    $result = $query->fetchAll();

    $resultString = print_r($result, true);
    error_log('The output is: ' . $resultString);

    $output = [];
    $names = [];

    // Build the output.
    
    if (!empty($result)) {     

      foreach ($result as $row) {
        $names[] = $row->name;
      }

      $output = [
        '#theme' => 'birthday_list',
        '#names' => $names,        
      ];

    }
    $outputString = print_r($output, true);
    error_log('The output is: ' . $outputString);

    return $output;
    
    
  }  

}