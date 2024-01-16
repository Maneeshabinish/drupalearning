<?php

namespace Drupal\employees_record\Batch;

use Drupal\node\Entity\Node;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class CustomBatch {

    public static function batchOperation($node_data, &$context){

        // Skip processing if this row is the header row.
        if ($node_data[0] === 'id') {
            return;
        }
    
        $id = $node_data[0];
        $name = $node_data[1];
        $location = $node_data[2];
        $age = $node_data[3];

        $node = \Drupal::entityTypeManager()->getStorage('person')->create([
            'id' => $id,
            'name' => $name,
            'location' => $location,
            'age' => $age,
        ]);        

        $node->save();
        $context['result'][] = $node_data;
    }

    public static function batchFinished($success, $csv_data, $operation){
       
        if ($success) {
            \Drupal::messenger()->addMessage(t('CSV imported successfully.'));
        }
        else {
            \Drupal::messenger()->addError(t('CSV import failed.'));
        }
    }
    
}
