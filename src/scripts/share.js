jQuery(document).ready(function ($) {
    $('.share-btn.linkedin').on('click', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let linkedinShareUrl = 'https://www.linkedin.com/shareArticle?mini=true&url=' + url;
        window.open(linkedinShareUrl, 'Share on LinkedIn', 'width=600,height=400');
    });

});