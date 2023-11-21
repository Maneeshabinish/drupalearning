<?php

namespace Drupal\custom_book_appointments\Controller;

use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;

class CustomBookAppointmentsController extends ControllerBase {

    protected $formBuilder;

    public function __construct(FormBuilderInterface $formBuilder) {
        $this->formBuilder = $formBuilder;
    }

    public static function create(ContainerInterface $container) {
        
        return new static(
            $container->get('form_builder'),
        );
    }

    public function book_appointments() {
        $forms = [];

        $formDefinitions = [
          'book_appointment_form' => '\Drupal\custom_book_appointments\Form\BookAppointmentForm',
          'review_medical_form' => '\Drupal\custom_book_appointments\Form\ReviewMedicalForm',
          'general_enquiry_form' => '\Drupal\custom_book_appointments\Form\GeneralEnquiryForm',
          // Add more forms as needed.
      ];
  
      // Iterate over form definitions and add forms to $forms array.
      foreach ($formDefinitions as $formKey => $formClass) {

        $formObject = \Drupal::formBuilder()->getForm($formClass);
        $formId = $formObject['#form_id'];
        $forms[$formId] = $formObject;
        
      }
  
      $build = [
          '#theme' => 'book_appointment',
          '#forms' => $forms,
          '#attached' => [
              'library' => [
                  'custom_book_appointments/custom_book_appointments_tabs',
              ],
          ],
      ];
  
      return $build;
  }
        
}