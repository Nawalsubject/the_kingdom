/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
require('bootstrap');
require('@fortawesome/fontawesome-free/css/all.min.css');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});


// jquery for change navbar color on scroll

function checkScroll() {
    let startY = $('.navbar').height(); //The point where the navbar changes in px

    if ($(window).scrollTop() > startY) {
        $('.navbar').addClass("bg-custom");
    } else {
        $('.navbar').removeClass("bg-custom");
    }
}

if ($('.navbar').length > 0) {
    $(window).on("scroll load resize", function () {
        checkScroll();
    });
}

// function to see file chosen with vich_uploader

$('#user_information_imageFile_file').on('change', function () {
    //get the file name
    let fileName = $(this).val();
    //replace the "Choose a file" label
    $(this).next('.custom-file-label').html(fileName);
});
