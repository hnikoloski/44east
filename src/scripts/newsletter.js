import axios from 'axios';
jQuery(document).ready(function ($) {
    let homeUrl = window.location.origin;
    let api_url = homeUrl + '/wp-json/ff-east/v1/newsletter-sign-up';

    $('.newsletter-form').on('submit', function (e) {
        e.preventDefault();
        let $this = $(this);
        let email = $this.find('input[type="email"]').val();

        if (email === '') {
            return;
        }

        let data = {
            email: email
        };

        axios.post(api_url, data).then(function (response) {
            let data = response.data;
            console.log(data)
            if (data.error === true) {
                // Remove any existing error messages
                $this.find('.status-msg.error').remove();

                // Append error message after the .form-control div
                $this.find('.form-control').after('<p class="status-msg error ">' + data.message + '</p>');
            } else {
                $this.find('.status-msg.error').remove();
                $this.find('.form-control').after('<p class="status-msg success">' + data.message + '</p>');
                $this.find('.form-control').remove();
            }
        }).catch(function (error) {
            console.log(error);
        });


    });
});