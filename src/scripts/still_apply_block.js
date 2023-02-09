import Dropzone from "dropzone";
import axios from "axios";
jQuery(document).ready(function ($) {

    if ($('.ffeast-still-apply-block').length) {
        $('.ffeast-still-apply-block .apply-modal').addClass('active');


        // Add required attribute to all inputs
        $('.ffeast-still-apply-block .apply-modal input').each(function () {
            // If it has required attribute add a span in the label text
            if ($(this).attr('required')) {
                $(this).parent().find('label').append('<span class="req"></span>');
            }
        });

        //     // Modal Toggle
        $('.ffeast-still-apply-block .open-modal').on('click', function (e) {
            e.preventDefault();
            $('.ffeast-still-apply-block .apply-modal').addClass('active');
            $('body').addClass('overflow-hidden');
        });

        $('.ffeast-still-apply-block .apply-modal .close-modal').on('click', function (e) {
            e.preventDefault();
            $('.ffeast-still-apply-block .apply-modal').removeClass('active');
            $('body').removeClass('overflow-hidden');
        });

        //  On esc key press or click outside modal close modal
        $(document).on('keydown', function (e) {
            if (e.keyCode === 27) {
                $('.ffeast-still-apply-block .apply-modal').removeClass('active');
                $('body').removeClass('overflow-hidden');
            }
        });

        $(document).on('click', function (e) {
            if ($(e.target).hasClass('apply-modal')) {
                $('.ffeast-still-apply-block .apply-modal').removeClass('active');
                $('body').removeClass('overflow-hidden');
            }
        });

        // Dropzone
        Dropzone.autoDiscover = false;
        let uploadInput = $(".ffeast-still-apply-block .dropzone");
        if (uploadInput.length) {
            uploadInput.dropzone({
                url: window.location.origin + '/wp-json/ff-east/v1/upload-file-temp',
                addRemoveLinks: true,
                maxFiles: 5,
                // Drop zone text
                dictDefaultMessage: $('.ffeast-still-apply-block .dropzone').attr('data-text'),
            });
        }

        // on form submit 
        $('.ffeast-still-apply-block .apply-modal .modal-content form').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let api_url = form.attr('action');
            let formData = new FormData(this);
            let dropzone = $('.ffeast-still-apply-block .dropzone')[0].dropzone;
            let files = dropzone.files;
            let fileCount = files.length;
            let fileNames = [];
            // Add files to form data
            for (let i = 0; i < fileCount; i++) {
                fileNames.push(files[i].name);
                formData.append('files', files[i]);
            }

            // Send form data to api with axios
            axios.post(api_url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function (response) {
                console.log(response);
            }).catch(function (error) {
                console.log(error);
            });

        });









    }
});