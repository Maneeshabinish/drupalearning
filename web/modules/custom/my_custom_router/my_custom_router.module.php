<?php

function my_custom_router_theme($existing, $type, $theme, $path) {

  return [
    
    'test_page' => [

      'render element' => 'children',
      'template' => 'test-page',
      'path' => $path . '/templates',
      'variables' => [
        'text' => '',

      ],
    ],  

    'arguments_display' => [

      'render element' => 'children',
      'template' => 'arguments-display',
      'path' => $path . '/templates',
      'variables' => [
        'num1'=> null,
        'num2'=> null,

      ],
    ],
      
  ];

}