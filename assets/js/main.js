/**
 * Main
 */

'use strict';

let menu, animate;

(function () {
  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }


  var needsValidation = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(needsValidation)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        // Prevent the form from submitting normally
        event.preventDefault();
        event.stopPropagation();

        // Perform form validation
        if (form.checkValidity()) {
          // If the form is valid, handle the form submission via AJAX
          var formData = new FormData(form);
          $("#loading").show();
          // Use Fetch API to send the form data
          fetch(form.getAttribute('action'), {
            method: 'POST',
            body: formData,
          })
            .then(response => response.json())  // Parse JSON response
            .then(data => {
              $("#loading").hide();
              var title = data.title;
              var message = data.message;
              var icon = data.icon;
              Swal.fire({
                title: title,
                text: message,
                icon: icon,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500
              });
              if (data.status == 'ok') {
                if (data.page == "reload") {
                  setTimeout('window.location.reload();', 1000);
                } else if (data.page == "table") {
                  if (active_modal != null) {
                    $("#" + active_modal).modal("hide");
                  }
                  if (table != null)
                    table.ajax.reload();
                } else if (data.callback != undefined) {

                  /*if (typeof window[data.callback.replace('()', '')] === 'function') {
                    window[data.callback.replace('()', '')]();
                  }*/
                  eval(data.callback);

                } else if (data.page == "redirect") {
                  setTimeout('window.location.href = "' + data.redirect_link + '";', 1000);
                }
              }
            })
            .catch((error) => {
              $("#loading").hide();
              // Handle network or unexpected errors
              Swal.fire({
                title: 'Error',
                text: 'An unexpected error occurred.',
                icon: 'error',
                position: "top-end",
                showConfirmButton: false,
                timer: 3000
              });
            });
        } else {
          // If the form is invalid, stop the submission
          form.classList.add('was-validated');
        }
      }, false);
    });





  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  window.Helpers.setCollapsed(true, false);
})();
