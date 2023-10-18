<?php
namespace Drupal\my_custom_router\Controller;

use Drupal\Core\Controller\ControllerBase;

class MyCustomRouterController extends ControllerBase {
    public function mytestpage(){

        return [
            '#markup' => 'Hello, world',
          ];
    }

    public function arguments($number, $num2){

       return [
        
            '#markup' =>  $this->t('Hi, this is a random number: @arg1 @arg2', ['@arg1' => $number,'@arg2'=> $num2]),
        
          ];
    }
}