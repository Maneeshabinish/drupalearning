<?php

namespace Drupal\my_custom_router\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Url;

class MyCustomRouterController extends ControllerBase {

  use StringTranslationTrait;
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

  public function customPages(){

     
    $links = [];

    $links[] = [
     '#type' => 'link',
     '#url' => Url::fromRoute('custom_test_pages.list'),
     '#title' => $this->t('Simple page with a list'),
    ];
    $links[] = [
     '#type' => 'link',
     '#url' => Url::fromRoute('custom_test_pages.argumentsTestPage', ['strg1' => 'node1', 'strg2' => 'node2']),
     '#title' => $this->t('Page rendering arguments from url'),
    ];
    $links[] = [
      '#type' => 'link',
      '#url' => Url::fromRoute('custom_test_pages.TestForm'),
      '#title' => $this->t('Test Form'),
     ];
     $links[] = [
      '#type' => 'link',
      '#url' => Url::fromRoute('custom_test_pages.SignInForm'),
      '#title' => $this->t('Sign In'),
     ];
     $links[] = [
      '#type' => 'link',
      '#url' => Url::fromRoute('custom_test_pages.UserDetailsForm'),
      '#title' => $this->t('User Details Form'),
     ];
   $content = [
     '#theme' => 'item_list',
     '#theme_wrappers' => ['custom_test_pages_content_array'],
     '#items' => $links,
     '#title' => $this->t('Custom Test Pages.'),
   ];

   return $content;

 }
 
 public function list() {
   $items = [
    
     $this->t('First item'),
     $this->t('Second item'),
     $this->t('Third item'),
     $this->t('Fourth item'),

       ];

   
   $build['render_version'] = [
    
     '#theme' => 'item_list',
     '#attached' => ['library' => ['custom_test_pages/list']],
     '#title' => $this->t("A list returned to be rendered using theme('item_list')"),
     '#items' => $items,
     '#attributes' => ['class' => ['render-version-list']],
   ];

   
 
   $build['our_theme_function'] = [

     '#theme' => 'custom_test_pages_list',
     '#attached' => ['library' => ['custom_test_pages/list']],
     '#title' => $this->t("The same list rendered by theme('custom_test_pages_list')"),
     '#items' => $items,

   ];
   return $build;
 }
 public function argumentsTestPage($strg1, $strg2) {

   return[

     '#theme'=> 'arguments_test_page',
     '#title' => $this->t("Following are the arguments passed from the Url"),
     '#strg1'=> $strg1,
     '#strg2'=> $strg2,

   ];
 }
}