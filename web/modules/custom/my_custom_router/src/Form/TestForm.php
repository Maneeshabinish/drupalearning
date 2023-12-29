<?php

namespace Drupal\my_custom_router\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Utility\EmailValidatorInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class TestForm extends FormBase {
  protected $emailValidator;

  public function __construct(EmailValidatorInterface $emailValidator) {
      $this->emailValidator = $emailValidator;
  }
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('email.validator')
    );
  }

 
  public function getFormId() {
    return 'test-form';
  }

    public function buildForm(array $form, FormStateInterface $form_state) {

      $form['attached']['library'][]='custom_form_css';
      $form['#theme'] = 'custom_test_form';
      $form['text'] = [

        '#type' => 'textfield',
        '#title' => $this->t('Enter Your Name:'),
        '#description' => t('Enter your first name.'),
        '#required' => TRUE,
        
      ];

      $options = [

        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'neutral' => $this->t('Neutral'),
        
      ];
      $form['choice'] = [

        '#type' => 'select',
        '#options' => $options,
        '#title' => $this->t('Gender:'),
       
      ];
     
      $form['age'] = [

        '#type' => 'number',
        '#title' => $this->t('Age:'),
        '#description' => t('Enter your age.'),
        '#required' => TRUE,
        '#element_validate' => [[$this, 'validateForm']],
      
      ];
      $form['email'] = [

        '#type' => 'email',
        '#title' => $this->t('Email:'),
        '#description' => t('Enter your email.'),
        '#required' => TRUE,
        '#element_validate' => [[$this, 'validateForm']],
        
      ];

      $form['address'] = [

        '#type' => 'textarea',
        '#title' => $this->t('Permenant Address:'),
       

      ];
    
      $options_radiobutton = array(
        'option1' => t('Exceptional'),
        'option2' => t('Very Good'),
        'option3' => t('Needs Improvement'),
        'option4' => t('Poor'),
      );
      $form['user_opinion'] = [

        '#type' => 'radios',
        '#title' => t('Rate the site content.'),
        '#options' => $options_radiobutton,
        '#attached' => [
          'library' => [
            'my_custom_router/custom-styles',
          ],
        ],
       
      ];
      $form['subscribe'] = [
 
        '#type' => 'checkbox',
        '#title' => t('Subscribe to our newsletter'),
        

      ];
      $form['submit'] = [

        '#type' => 'submit',
        '#value' => $this->t('Go'),
      ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Get the submitted phone number.
    $phone_number = $form_state->getValue('phone_number');

    // Remove non-digit characters (e.g., spaces, dashes, parentheses) from the phone number.
    $cleaned_phone_number = preg_replace('/\D/', '', $phone_number);

    // Check if the cleaned phone number has exactly 10 digits.
    if (strlen($cleaned_phone_number) !== 10) {
        // The phone number is not valid. Set an error message.
        $form_state->setErrorByName('phone_number', $this->t('Phone number must have exactly 10 digits.'));
    }

    $age = $form_state->getValue('age');

    if ($age < 18) {

        $form_state->setErrorByName('age', $this->t('Age should be 18 or older.'));
    }

    $email_id = $form_state->getValue('email');
  
    if (!$this->emailValidator->isValid($email_id)) {

        $form_state->setErrorByName('email', $this->t('The email address is not valid.'));
    }
  
  
}

   public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->messenger()->addMessage($this->t('Hi %input, thanks for your input.',
    ['%input' => $form_state->getValue('text')]));

    $subscribe = $form_state->getValue('subscribe');

    if ($subscribe) {

      $this->messenger()->addMessage($this->t('You are subscribed to our newsletter.'));
      
    } 
    
  }

}