import TomSelect from 'tom-select';

import axios from 'axios';
jQuery(document).ready(function ($) {

    let homeUrl = window.location.origin;
    let api_url = homeUrl + '/wp-json/ff-east/v1/jobs';
    if ($('.ffeast-jobs-board-block').length) {
        $('.ffeast-jobs-board-block .select-basic').each(function () {
            new TomSelect(this, {
                create: false,
                allowEmptyOption: false,
                controlInput: false,
                // on change event
                onChange: function (value) {
                    $('.ffeast-jobs-board-block .filter').toggleClass('active');
                    $('.ffeast-jobs-board-block .container header .filter .filter-item').attr('data-job-type', value);
                    fetchJobs($('.ffeast-jobs-board-block .container header .filter .filter-item.active').attr('data-job-category'), value);
                    $('#jobTypeHidden').val(value);
                    // trigger change event 
                    $('#jobTypeHidden').trigger('change');
                }
            });
        });

        $('.ffeast-jobs-board-block .select-basic-second').each(function () {
            new TomSelect(this, {
                create: false,
                allowEmptyOption: false,
                controlInput: false,
                // on change event
                onChange: function (value) {
                    $('.ffeast-jobs-board-block .filter').toggleClass('active');
                    $('.ffeast-jobs-board-block .container header .filter .filter-item').attr('data-job-type', value);
                    $('#jobCategoryHidden').val(value);
                    // trigger change event
                    $('#jobCategoryHidden').trigger('change');
                }
            });
        });

        $('.ffeast-jobs-board-block .filter li .filter-item').on('click', function (e) {
            e.preventDefault();
            let $this = $(this);
            if ($this.hasClass('active') || $('.ffeast-jobs-board-block .filter').hasClass('loading')) {
                return;
            }
            $this.parent().parent().find('a').removeClass('active');
            $this.addClass('active');
            fetchJobs($this.attr('data-job-category'), $this.attr('data-job-type'));
        });
    }

    function singleJobComponent(category, categoryColor, title, link, btnTxt, shortDescription, jobType, minYears) {
        return `
        <div class="single-job" data-href="${link}">
        <div class="top">
            <div class="content">
                <p class="category" style="--textColor:${categoryColor}">${category}</p>
                <h3 class="title">${title}</h3>
            </div>
            <a href="${link}" class="btn btn-primary btn-primary-xs">${btnTxt}</a>
        </div>
        <p class="short-description">${shortDescription}</p>
        <ul>
            <li class="job-type">
                ${jobType.label} </li>
            <li class="min-years">
                ${minYears} </li>
        </ul>
    </div>
        `
    }


    fetchJobs('*', '*');
    function fetchJobs(job_category, job_type) {
        $('.ffeast-jobs-board-block .filter, .ffeast-jobs-board-block header').addClass('loading');
        axios.get(api_url, {
            params: {
                job_category: job_category,
                job_type: job_type,
                lang: $('#page').attr('data-current-lang')
            }
        }).then(function (response) {
            let jobs = response.data;
            let html = '';
            let container = $('.ffeast-jobs-board-block .container .row .job-results');

            if (jobs.length > 0) {
                jobs.forEach(function (job) {
                    html += singleJobComponent(job.job_category, job.job_category_color ? job.job_category_color : '#000', job.title, job.link, job.btnTxt, job.short_description, job.job_type, job.min_years);
                });
            } else {
                html = '<p class="no-results">No results found</p>';
            }
            container.html(html);

        }).then(() => {
            if ($(window).width() <= 768) {
                // Move the .job-results .single-job .top .btn to the bottom of the .job-results .single-job as last 
                $('.ffeast-jobs-board-block .container .row .job-results .single-job .top .btn').each(function () {
                    $(this).appendTo($(this).parent().parent());
                });
            }
        })
            .then(() => {
                // Convert the .single-job to a link

                $('.ffeast-jobs-board-block .container .row .job-results .single-job').on('click', function (e) {
                    e.preventDefault();
                    window.location.href = $(this).attr('data-href');

                });
            })
            .then(() => {
                $('.ffeast-jobs-board-block .filter, .ffeast-jobs-board-block header').removeClass('loading');

            })
            .catch(function (error) {
                console.log(error);
            }
            );

    }

    // when #jobCategoryHidden or #jobTypeHidden change, trigger the change event of the select
    $('#jobCategoryHidden').on('change', function () {
        fetchJobs($(this).val(), $('#jobTypeHidden').val());
        console.log('jobCategoryHidden change');
    });

    $('#jobTypeHidden').on('change', function () {
        fetchJobs($('#jobCategoryHidden').val(), $(this).val());
        console.log('jobTypeHidden change');
    });


});