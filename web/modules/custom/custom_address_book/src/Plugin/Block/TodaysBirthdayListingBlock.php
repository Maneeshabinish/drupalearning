<?php

namespace Drupal\custom_address_book\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Database\Database;

/**
 * Provides a 'Birthday Listing Block' block.
 *
 * @Block(
 *   id = "birthday_block",
 *   admin_label = @Translation("Todays Birthdays!!!"),
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
    $today_month_day = date('md', $today); // Only extract month and day.

    // Query the database for names and dates of birth.
    $query = \Drupal::database()->select('address_entry', 'a')
      ->fields('a', ['name', 'dob'])
      ->execute();

    $result = $query->fetchAll();

    $output = [];
    $names = [];

    // Build the output.
    if (!empty($result)) {
      foreach ($result as $row) {
        $dob_month_day = date('md', strtotime($row->dob)); // Extract month and day from dob.

        // Check if the dob matches today's month and day.
        if ($dob_month_day === $today_month_day) {
          $names[] = $row->name;
        }
      }

      $output = [
        '#theme' => 'birthday_list',
        '#names' => $names, 
        '#attached' => [
          'library' => [
            'custom_address_book/custom_block_css', // Adjust this to your actual library name.
          ],
        ],       
      ];
    } else {
      // No birthdays today.
      $output = [
        '#theme' => 'birthday_list',
        '#names' => [],
        '#attached' => [
          'library' => [
            'custom_address_book/custom_block_css', // Adjust this to your actual library name.
          ],
        ],       
      ];
    }

    return $output;
  }  
}