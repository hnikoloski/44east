import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.default.css';

import axios from 'axios';
jQuery(document).ready(function ($) {

    let homeUrl = window.location.origin;
    let api_url = homeUrl + '/wp-json/ff-east/v1/blog-posts';
    $('.ffeast-all-posts-block .select-basic').each(function () {
        new TomSelect(this, {
            create: false,
            allowEmptyOption: false,
            controlInput: false,
            // on change event
            onChange: function (value) {
                $('.ffeast-all-posts-block .filter').toggleClass('active');

            }
        });
    });

    $('.filter-for-mobile.select-basic-second.categories').each(function () {
        new TomSelect(this, {
            create: false,
            allowEmptyOption: false,
            controlInput: false,
            // on change event
            onChange: function (value) {
                $('#hiddenCategories').val(value);
                // Trigger change event
                $('#hiddenCategories').trigger('change');
            }
        });
    });

    $('.filter-for-mobile.select-basic-second.tags').each(function () {
        new TomSelect(this, {
            create: false,
            allowEmptyOption: false,
            controlInput: false,
            // on change event
            onChange: function (value) {
                $('#hiddenTags').val(value);
                // Trigger change event
                $('#hiddenTags').trigger('change');
            }
        });
    });




    $('.ffeast-all-posts-block .filter li a').on('click', function (e) {
        e.preventDefault();
        let $this = $(this);
        if ($this.hasClass('active') || $('.ffeast-all-posts-block .filter').hasClass('loading')) {
            return;
        }
        $this.parent().parent().find('a').removeClass('active');
        $this.addClass('active');
        $('.ffeast-all-posts-block .filter').addClass('loading');

        let filterVal = $this.attr('data-filter');
        let catFilter = false;

        if ($this.parent().parent().hasClass('categories')) {
            catFilter = true;
        } else {
            catFilter = false;
        }

        // If catFilter is true, then we are filtering by category and set slug param if not, then we are filtering by tag and set tag param
        let param = catFilter ? 'slug' : 'tag';
        let data = {
            [param]: filterVal,
            offsetPosts: $('#offsetPosts').val(),
            lang: $('#page').attr('data-current-lang')
        };
        axios.get(api_url, {
            params: data
        }).then(function (response) {
            let posts = response.data;
            let html = '';
            let container = $('.ffeast-all-posts-block .results');

            if (posts.length > 0) {
                posts.forEach(function (post) {
                    html += blogCard(post.title, post.excerpt, post.catName, post.date, post.readTime, post.imgUrl, post.btnTxt, post.btnLink);
                });
            } else {
                html = '<p class="no-results">No results found</p>';
            }
            container.html(html);

            $('.ffeast-all-posts-block .filter').removeClass('loading');

        }).catch(function (error) {
            console.log(error);
        }
        );
    });

    $('#hiddenCategories').on('change', function () {
        let $this = $(this);
        if ($this.val() == '' || $('.ffeast-all-posts-block .filter').hasClass('loading')) {
            return;
        }
        $('.ffeast-all-posts-block .filter').addClass('loading');

        let filterVal = $this.val();
        let catFilter = true;
        let param = catFilter ? 'slug' : 'tag';
        let data = {
            [param]: filterVal,
            offsetPosts: $('#offsetPosts').val(),
            lang: $('#page').attr('data-current-lang')
        };
        axios.get(api_url, {
            params: data
        }).then(function (response) {
            let posts = response.data;
            let html = '';
            let container = $('.ffeast-all-posts-block .results');

            if (posts.length > 0) {
                posts.forEach(function (post) {
                    html += blogCard(post.title, post.excerpt, post.catName, post.date, post.readTime, post.imgUrl, post.btnTxt, post.btnLink);
                });
            } else {
                html = '<p class="no-results">No results found</p>';
            }
            container.html(html);

            $('.ffeast-all-posts-block .filter').removeClass('loading');

        }).catch(function (error) {
            console.log(error);
        }
        );
    });

    $('#hiddenTags').on('change', function () {
        let $this = $(this);
        if ($this.val() == '' || $('.ffeast-all-posts-block .filter').hasClass('loading')) {
            return;
        }
        $('.ffeast-all-posts-block .filter').addClass('loading');

        let filterVal = $this.val();
        let catFilter = false;
        let param = catFilter ? 'slug' : 'tag';
        let data = {
            [param]: filterVal,
            offsetPosts: $('#offsetPosts').val(),
            lang: $('#page').attr('data-current-lang')
        };
        axios.get(api_url, {
            params: data
        }).then(function (response) {
            let posts = response.data;
            let html = '';
            let container = $('.ffeast-all-posts-block .results');

            if (posts.length > 0) {
                posts.forEach(function (post) {
                    html += blogCard(post.title, post.excerpt, post.catName, post.date, post.readTime, post.imgUrl, post.btnTxt, post.btnLink);
                });
            } else {
                html = '<p class="no-results">No results found</p>';
            }
            container.html(html);

            $('.ffeast-all-posts-block .filter').removeClass('loading');

        }).catch(function (error) {
            console.log(error);
        }
        );
    });


    // Initial Call
    axios.get(api_url, {
        params: {
            offsetPosts: $('#offsetPosts').val()
        }
    }).then(function (response) {
        let posts = response.data;
        let html = '';
        let container = $('.ffeast-all-posts-block .results');

        if (posts.length > 0) {
            posts.forEach(function (post) {
                html += blogCard(post.title, post.excerpt, post.catName, post.date, post.readTime, post.imgUrl, post.btnTxt, post.btnLink);
            });
        } else {
            html = '<p class="no-results">No results found</p>';
        }
        container.html(html);

        $('.ffeast-all-posts-block .filter').removeClass('loading');

    }).catch(function (error) {
        console.log(error);
    });

    function blogCard(title, excerpt, catName, date, readTime, imgUrl, btnTxt, btnLink) {
        return `
        <div class="single-post">
        <div class="img-wrapper">
            <img src="${imgUrl}" alt="${title}" class="full-size-img full-size-img-cover">
        </div>
        <div class="wrapper">

            <div class="meta">
                <p>
                   ${date}
                    -
                    ${readTime}
                </p>
                <ul class="categories">
                        <li>${catName}</li>
                </ul>
            </div>
            <h2 class="title">
                ${title}
            </h2>
            <p class="excerpt">
               ${excerpt}
            </p>
            <a href="${btnLink}" class="btn btn-arrow">
                ${btnTxt}
                <span class="material-symbols-outlined">
                    arrow_circle_right
                </span>
            </a>
        </div>
    </div>
        `
    }
});