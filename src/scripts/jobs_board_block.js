import TomSelect from 'tom-select';

import axios from 'axios';
jQuery(document).ready(function ($) {

    let homeUrl = window.location.origin;
    let api_url = homeUrl + '/wp-json/ff-east/v1/jobs';

    $('.ffeast-jobs-board-block .select-basic').each(function () {
        new TomSelect(this, {
            create: false,
            allowEmptyOption: false,
            controlInput: false,
            // on change event
            onChange: function (value) {
                $('.ffeast-all-posts-block .filter').toggleClass('active');
                $('.ffeast-jobs-board-block .container header .filter li a').attr('data-job-type', value);
                fetchJobs($('.ffeast-jobs-board-block .container header .filter li a.active').attr('data-job-category'), value);
            }
        });
    });

    $('.ffeast-jobs-board-block .filter li a').on('click', function (e) {
        e.preventDefault();
        let $this = $(this);
        if ($this.hasClass('active') || $('.ffeast-jobs-board-block .filter').hasClass('loading')) {
            return;
        }
        $this.parent().parent().find('a').removeClass('active');
        $this.addClass('active');
        fetchJobs($this.attr('data-job-category'), $this.attr('data-job-type'));
    });


    function singleJobComponent(category, categoryColor, title, link, btnTxt, shortDescription, jobType, minYears) {
        return `
        <div class="single-job">
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
        console.log(job_category, job_type)
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

        })
            .catch(function (error) {
                console.log(error);
            }
            );

    }
});