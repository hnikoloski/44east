import Dropzone from "dropzone";
import axios from "axios";
jQuery(document).ready(function ($) {

    if ($('.ffeast-still-apply-block').length || $('form#jobAppForm').length) {


        // Add required attribute to all inputs
        $('form#jobAppForm input').each(function () {
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
        let uploadInput = $("form#jobAppForm .dropzone");
        if (uploadInput.length) {
            uploadInput.dropzone({
                url: window.location.origin + '/wp-json/ff-east/v1/upload-file-temp',
                addRemoveLinks: true,
                maxFiles: 5,
                // Pdf and word files only
                acceptedFiles: ".pdf,.doc,.docx",
                // Drop zone text
                dictDefaultMessage: $('form#jobAppForm .dropzone').attr('data-text'),


                init: function () {
                    this.on("processing", function (file) {
                        $('form#jobAppForm').addClass('disabled');
                    });
                    this.on("complete", function (file) {
                        $('form#jobAppForm').removeClass('disabled');
                    });
                }
            });
        }


        // on form submit 
        $('form#jobAppForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            // If there is a class disabled return
            if (form.hasClass('disabled')) {
                return;
            }
            form.addClass('loading');
            let api_url = form.attr('action');
            let formData = new FormData(this);
            let dropzone = $('form#jobAppForm .dropzone')[0].dropzone;
            let files = dropzone.files;
            let fileCount = files.length;
            let fileNames = [];
            // Add files to form data
            for (let i = 0; i < fileCount; i++) {
                fileNames.push(files[i].name);
                formData.append('files', files[i]);
            }

            // Send form data to api with axios
            axios
                .post(api_url, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function (response) {

                    form.find('.status-msg p').text(response.data.message);
                    if (response.data.error === true) {
                        form.find('.status-msg').addClass('error');
                    } else {
                        form.find('.status-msg').addClass('success');
                        form.find('.status-msg').removeClass('error');
                        dropzone.removeAllFiles();
                        // Reset Form
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