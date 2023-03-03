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
                    var myDropzone = this;
                    this.on("processing", function (file) {
                        $('form#jobAppForm').addClass('disabled');
                    });
                    // while uploading create a progress bar
                    this.on("uploadprogress", function (file, progress, bytesSent) {
                        let progressItem = '<div class="progress"><div class="progress-bar" role="progressbar" style="width: ' + progress + '%;" aria-valuenow="' + progress + '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                        $('form#jobAppForm .files-selected li').each(function () {
                            if ($(this).find('span.remove-file').attr('data-file') === file.name) {
                                $(this).append(progressItem);
                            }
                        });
                    });


                    this.on("complete", function (file) {
                        $('form#jobAppForm').removeClass('disabled');
                        // Add a <li> to the ul.file-list with the file name and the remove button
                        let fileName = file.name;
                        let fileUrl = file.upload.filename;
                        let fileExt = fileUrl.split('.').pop();
                        let fileIcon = '';
                        if (fileExt === 'pdf') {
                            fileIcon = 'pdf';
                        }
                        if (fileExt === 'doc' || fileExt === 'docx') {
                            fileIcon = 'doc';
                        }
                        let fileItem = '<li><span class="material-symbols-outlined icon">description</span> ' + file.name + ' <span class="material-symbols-outlined removeFile remove-file delete" data-file="' + fileUrl + '">cancel</span></li>';
                        $('form#jobAppForm .files-selected').append(fileItem);
                    });
                    this.on("removedfile", function (file) {
                        // Remove the file from the ul.file-list
                        let fileUrl = file.upload.filename;
                        $('form#jobAppForm .files-selected li').each(function () {
                            if ($(this).find('.remove-file').attr('data-file') === fileUrl) {
                                $(this).remove();
                            }
                        });
                    });
                    $('form#jobAppForm').on("click", ".remove-file", function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var fileUrl = $(this).data('file');
                        // Remove file from Dropzone
                        myDropzone.files.forEach(function (file) {
                            if (file.upload.filename === fileUrl) {
                                file.previewElement.remove();
                                myDropzone.removeFile(file);
                            }
                        });
                        // Remove file from list
                        $(this).parent().remove();
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