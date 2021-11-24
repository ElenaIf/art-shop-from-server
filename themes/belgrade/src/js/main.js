/**
 * @file
 * Belgrade theme main JS file.
 *
 */

(function ($, Drupal) {

  'use strict';

  // Initiate all Toasts on page.
  Drupal.behaviors.belgradeToast = {
    attach: function (context, settings) {
      $('.toast', context).once('initToast').each(function () {
        $(this).toast("show");
      });
    }
  };

  // Accordion buttons containing Edit links.
  Drupal.behaviors.accordionButtonLinks = {
    attach: function (context, settings) {
      $('.fieldset-legend.accordion-button a', context).once().on('click', function (event) {
        window.location = $(this).attr('href');
        event.preventDefault();
      });
    }
  };

  // Collapse and accordion if a field is required.
  Drupal.behaviors.focusRequired = {
    attach: function (context, settings) {
      var inputs = document.querySelectorAll('form .accordion input');
      [].forEach.call(inputs, function(input) {
        input.addEventListener('invalid',function(e){
            var accordion = input.closest(".collapse");
            $(accordion).collapse('show');
        });
      });
    }
  };


})(jQuery, Drupal);
