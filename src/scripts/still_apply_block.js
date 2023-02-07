import * as Uppy from '@uppy/core'
jQuery(document).ready(function ($) {

    // if ($('.ffeast-still-apply-block').length) {


    //     // Add required attribute to all inputs
    //     $('.ffeast-still-apply-block .apply-modal input').each(function () {
    //         // If it has required attribute add a span in the label text
    //         if ($(this).attr('required')) {
    //             $(this).parent().find('label').append('<span class="req"></span>');
    //         }
    //     });

    //     // Modal Toggle
    //     $('.ffeast-still-apply-block .open-modal').on('click', function (e) {
    //         e.preventDefault();
    //         $('.ffeast-still-apply-block .apply-modal').addClass('active');
    //         $('body').addClass('overflow-hidden');
    //     });

    //     $('.ffeast-still-apply-block .apply-modal .close-modal').on('click', function (e) {
    //         e.preventDefault();
    //         $('.ffeast-still-apply-block .apply-modal').removeClass('active');
    //         $('body').removeClass('overflow-hidden');
    //     });

    //     $('.ffeast-still-apply-block .form-control.upload .wrapper p').on('click', function () {
    //         $('.ffeast-still-apply-block .form-control.upload input').click();
    //     })

    //     // // File upload handler
    //     // let filesUploaded = [];
    //     // $('#uploadFiles').on('change', function () {
    //     //     for (let i = 0; i < this.files.length; i++) {
    //     //         filesUploaded.push(this.files[i].name);
    //     //     }
    //     //     // add <li> for each file uploaded
    //     //     $('.files-selected').html('');
    //     //     filesUploaded.forEach(function (file) {
    //     //         $('.files-selected').append(
    //     //             '<li><span class="material-symbols-outlined icon">description</span>' +
    //     //             file +
    //     //             '<span class="material-symbols-outlined delete">close</span> </li>'
    //     //         );
    //     //     });
    //     // });

    //     // // Remove file handler
    //     // $('.files-selected').on('click', '.delete', function () {
    //     //     let fileToRemove = $(this).prev().text();
    //     //     let indexToRemove = filesUploaded.indexOf(fileToRemove);
    //     //     if (indexToRemove > -1) {
    //     //         filesUploaded.splice(indexToRemove, 1);
    //     //     }
    //     //     $(this).parent().remove();
    //     // });

    //     // // Submit form handler
    //     // $('form').on('submit', function (e) {
    //     //     e.preventDefault();

    //     //     // Get form data
    //     //     let firstName = $('#firstName').val();
    //     //     let lastName = $('#lastName').val();
    //     //     let email = $('#email').val();
    //     //     let phone = $('#phone').val();
    //     //     let address = $('#address').val();
    //     //     let city = $('#city').val();
    //     //     let files = $('#uploadFiles')[0].files;

    //     //     // Check if all required fields are filled
    //     //     if (!firstName || !lastName || !email || !phone) {
    //     //         alert('Please fill in all required fields');
    //     //         return;
    //     //     }

    //     //     // Prepare form data for API request
    //     //     let formData = new FormData();
    //     //     formData.append('firstName', firstName);
    //     //     formData.append('lastName', lastName);
    //     //     formData.append('email', email);
    //     //     formData.append('phone', phone);
    //     //     formData.append('address', address);
    //     //     formData.append('city', city);
    //     //     for (let i = 0; i < files.length; i++) {
    //     //         formData.append('files', files[i]);
    //     //     }

    //     //     // Console log form data in table format
    //     //     console.table({
    //     //         'First Name': firstName,
    //     //         'Last Name': lastName,
    //     //         'Email': email,
    //     //         'Phone': phone,
    //     //         'Address': address,
    //     //         'City': city,
    //     //         'Files': filesUploaded
    //     //     });
    //     // });


    //     // File Pond

    //     let $uploadInput = $('.ffeast-still-apply-block form .form-control.upload input')

    //     new Uppy({
    //         debug: true,
    //         autoProceed: true,
    //         // Target
    //         target: $uploadInput.parent().get(0),
    //         restrictions: {
    //             maxFileSize: 1000000,
    //             maxNumberOfFiles: 3,
    //             minNumberOfFiles: 1,
    //             allowedFileTypes: ['image/*', '.pdf', '.doc', '.docx']
    //         },
    //         onBeforeFileAdded: (currentFile, files) => {
    //             console.log('onBeforeFileAdded', currentFile, files)
    //         },
    //         onBeforeUpload: (files) => {
    //             console.log('onBeforeUpload', files)
    //         },
    //         onFileAdded: (currentFile, files) => {
    //             console.log('onFileAdded', currentFile, files)
    //         },
    //         onFileRemoved: (currentFile, files) => {
    //             console.log('onFileRemoved', currentFile, files)
    //         },
    //         onFileUploaded: (file, response) => {
    //             console.log('onFileUploaded', file, response)
    //         },
    //     })




    // }
});