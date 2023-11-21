(function ($, Drupal) {
  Drupal.behaviors.bootstrapTabCheckbox = {
    attach: function (context, settings) {
      // Function to update checkboxes based on the clicked tab
      function updateCheckboxes(clickedTab) {
        // Uncheck all checkboxes
        $('input[type="checkbox"]').prop('checked', false);

        // Extract the form ID from the clicked tab's href attribute
        var formId = clickedTab.attr('href').split('-').pop();
        var checkboxId = '#checkbox-' + formId;

        // Check the corresponding checkbox
        $(checkboxId).prop('checked', true);


      }

      // Update checkboxes for dynamically generated tabs
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        updateCheckboxes($(this));
      });
    }
  };
})(jQuery, Drupal);
  
  
  
  