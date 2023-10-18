<?php
namespace Drupal\my_custom_router\Controller;

use Drupal\Core\Controller\ControllerBase;

class MyCustomRouterController extends ControllerBase {
  public function test_page(){
 
    return [
      
      '#theme' => 'test_page',
      '#text' => 'Hello, world',

    ];
  }

  public function arguments_display($first_arg, $second_arg){
    

    return [
      
      '#theme' => 'arguments_display',
      '#num1' => $first_arg,
      '#num2'=> $second_arg,
      
    ];
  }
}