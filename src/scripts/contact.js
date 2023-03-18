import axios from "axios";
jQuery(document).ready(function ($) {

    if ($('.page-template-contact .content-container .row .col-form form').length) {


        // Add required attribute to all inputs
        $('.page-template-contact .content-container .row .col-form form input').each(function () {
            // If it has required attribute add a span in the label text
            if ($(this).attr('required')) {
                $(this).parent().find('label').append('<span class="req"></span>');
                // Remove required attribute
                $(this).removeAttr('required');
            }
        });

        $('.page-template-contact .content-container .row .col-form form').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let lang = form.attr('data-lang');
            // If there is a class disabled return
            if (form.hasClass('disabled')) {
                return;
            }
            form.addClass('loading');
            let api_url = form.attr('action');
            let formData = new FormData(this);

            // Send the language to the api
            formData.append('lang', lang);

            // Send form data to api with axios
            axios
                .post(api_url, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function (response) {
                    form.find('input').removeClass('error');
                    form.find('.field-error-msg').remove();
                    form.find('.status-msg p').text(response.data.message);

                    if (response.data.error === true) {
                        form.find('.status-msg').addClass('error');
                        // Loop through the error fields and check if they have true value
                        for (let field in response.data.fields) {

                            form.find('input[name=' + field + ']').addClass('error');
                            // add the error message to the input
                            form.find('input[name=' + field + ']').after('<p class="field-error-msg">' + response.data.fields[field] + '</p>');

                        }

                    } else {
                        form.find('.status-msg').addClass('success');
                        form.find('.status-msg').removeClass('error');
                        form[0].reset();
                    }

                })
                .then(() => {
                    form.removeClass('loading');
                })
                .catch(function (error) {
                    console.log(error);
                });


        });
    }
});