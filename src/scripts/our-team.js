import axios from 'axios';
jQuery(document).ready(function ($) {

    let api_url = location.protocol + '//' + location.host + '/wp-json/ff-east/v1/';
    $('.ffeast-our-team-block .single-team-member').on('click', function (e) {
        e.preventDefault();
        $(this).addClass('active');
        // Make custom cursor <i class="fas fa-circle-notch fa-spin"></i>
        $('.ffeast-our-team-block .single-team-member').css('cursor', 'wait');
        $('body').css('cursor', 'wait');

        let id = $(this).data('id');
        let modal = $('.member-modal');
        axios.get(api_url + 'our-team/' + id)
            .then(function (response) {
                let data = response.data;
                let img = data.img;
                let title = data.title;
                let position = data.team_member_position_title;
                let description = data.team_member_description;
                let linkedin = data.team_member_linkedin;
                let email = data.team_member_email;
                modal.html(modalMarkup(img, title, position, description, linkedin, email));
                modal.addClass('active');
            }).then(() => {
                $('body').addClass('overflow-hidden');

                $('.member-modal .close-modal').on('click', function (e) {
                    e.preventDefault();
                    modal.removeClass('active');
                    $('body').removeClass('overflow-hidden');
                });

                // Close modal on click outside or on escape key
                $(document).on('click', function (e) {
                    if ($(e.target).is('.member-modal')) {
                        modal.removeClass('active');
                        $('body').removeClass('overflow-hidden');
                    }
                });

                $(document).keyup(function (e) {
                    if (e.keyCode === 27) {
                        modal.removeClass('active');
                        $('body').removeClass('overflow-hidden');
                    }
                });
            })
            .then(() => {
                $('.single-team-member').removeClass('active');

                $('.ffeast-our-team-block .single-team-member').css('cursor', 'pointer');
                $('body').css('cursor', 'auto');
            })
            .catch(function (error) {
                console.log(error);
            });
    });

});

function modalMarkup(img, title, position, description, linkedin, email) {
    return `
 
    <div class="modal-dialog">
        <a href="#" class="close-modal" title="Close"><span></span><span></span></a>
        <div class="top">
            <div class="img-wrapper">
                <img src="${img}" alt="${title}" class="full-size-img full-size-img-cover">
            </div>
            <div class="content">
                <h2>${title}</h2>
           
                    <p>${position}</p>
          
                <ul class="socials">
                    <li><a href="${linkedin}" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-linkedin-in"></i>
                    </a></li>
                    <li><a href="mailto:${email}" target="_blank"><i class="fa fa-envelope"></i></a></li>
                </ul>
            </div>
        </div>
            <div class="description">
                ${description}
            </div>
</div>`;
}