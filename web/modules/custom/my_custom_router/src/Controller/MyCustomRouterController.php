<?php
namespace Drupal\my_custom_router\Controller;

use Drupal\Core\Controller\ControllerBase;

class MyCustomRouterController extends ControllerBase {
  public function test_page(){
   $array = [
    'name' => 'Annie',
    'id' => 3025,
   ];

    return[
      
      '#theme' => 'demo_page',
      '#text' => 'This is a string passed using Twig template and hook_theme. The following are listed from an array.',
      '#arr'=> $array ,

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