jQuery(document).ready(function ($) {
  $("a[href='nolink']").on("click", function (e) {
    e.preventDefault();
  });

  if ($('#cookie-notice').length) {
    $('#cookie-notice .btn').on('click', function (e) {
      e.preventDefault();
      // Save to session storage
      sessionStorage.setItem('cookie-notice', 'true');
      $('#cookie-notice').removeClass('active');
    });

    if (sessionStorage.getItem('cookie-notice') === 'true') {
      $('#cookie-notice').removeClass('active');
    }
  }


  // Update footer copyright year
  if ($('.current-year').length) {
    $('.current-year').text(new Date().getFullYear());
  }
  if ($('.site-main .wp-block-spacer').length) {
    // Convert each spacer the px to rem



    if ($(window).width() <= 768) {
      // Check if the spacer has a class called mob-space-123 and if so, replace the height with the value of the class 
      $(".site-main .wp-block-spacer").each(function () {
        var classList = $(this).attr("class").split(" ");
        for (var i = 0; i < classList.length; i++) {
          if (classList[i].startsWith("mob-space-")) {
            var number = parseInt(classList[i].split("-")[2]);
            if (!isNaN(number)) {
              $(this).height((number / 10) + "rem");
              break;
            }
          }
        }
      });
    } else {
      $('.site-main .wp-block-spacer').each(function () {
        var px = $(this).css('height');
        var rem = px.replace('px', '') / 10;
        $(this).css('height', rem + 'rem');
      });
    }
  }

  if ($('[style*="font-size"]').length) {
    // Convert each font-size the px to rem
    $('[style*="font-size"]').each(function () {
      var px = $(this).css('font-size');
      var rem = px.replace('px', '') / 10;
      $(this).css('font-size', rem + 'rem');
    });
  }

  $('body').removeClass('overflow-hidden');
  setTimeout(function () {
    $('#preloader').fadeOut(500, function () {
      $(this).remove();
    });
  }, 1);
  if ($('.page-template-contact .col-form form').length) {
    // Remove the p and br tags from the form
    $('.page-template-contact .col-form form p').each(function () {
      $(this).contents().unwrap();
    });
  }

  $('[data-href]').on('click', function (e) {
    e.preventDefault();
    window.location.href = $(this).data('href');
  });
});
