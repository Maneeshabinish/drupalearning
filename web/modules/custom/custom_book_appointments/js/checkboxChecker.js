(function ($, Drupal) {
    Drupal.behaviors.bootstrapTabCheckbox = {
      attach: function (context, settings) {
        // Function to update checkboxes based on the clicked tab
        function updateCheckboxes(clickedTab, checkboxId) {
          // Uncheck all checkboxes
          $('input[type="checkbox"]').prop('checked', false);
  
          // Check the corresponding checkbox
          $('#' + checkboxId).prop('checked', true);
        }
  
        // Update checkboxes when the "Book Appointment" tab is clicked
        $('#nav-book-appointment-tab').on('click', function () {
          updateCheckboxes($(this), 'checkbox-book-appointment');
        });
  
        // Update checkboxes when the "Review Report" tab is clicked
        $('#nav-review-report-tab').on('click', function () {
          updateCheckboxes($(this), 'checkbox-review-report');
        });
  
        // Update checkboxes when the "General Enquiry" tab is clicked
        $('#nav-general-enquiry-tab').on('click', function () {
          updateCheckboxes($(this), 'checkbox-general-enquiry');
        });
      }
    };
  })(jQuery, Drupal);
  
  
  
  
  