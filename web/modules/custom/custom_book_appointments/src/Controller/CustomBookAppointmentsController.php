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

        // Add BookAppointmentForm.
        $forms['appointment_form'] = $this->formBuilder->getForm('\Drupal\custom_book_appointments\Form\BookAppointmentForm');
      
        // Add ReviewMedicalForm.
        $forms['medical_review_form'] = $this->formBuilder->getForm('\Drupal\custom_book_appointments\Form\ReviewMedicalForm');
      
        // Add GeneralEnquiryForm.
        $forms['general_enquiry_form'] = $this->formBuilder->getForm('\Drupal\custom_book_appointments\Form\GeneralEnquiryForm');
      
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