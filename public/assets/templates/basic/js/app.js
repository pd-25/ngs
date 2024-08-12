"use strict";

$(document).ready(function () {
	//preloader
	$(".preloader")
		.delay(300)
		.animate(
			{
				opacity: "0",
			},
			300,
			function () {
				$(".preloader").css("display", "none");
			}
		);
});


// menu options custom affix
var fixed_top = $(".header");
$(window).on("scroll", function () {
	if ($(window).scrollTop() > 50) {
		fixed_top.addClass("animated fadeInDown menu-fixed");
	} else {
		fixed_top.removeClass("animated fadeInDown menu-fixed");
	}
});

// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function () {
	const element = $(this).parent("li");
	if (element.hasClass("open")) {
		element.removeClass("open");
		element.find("li").removeClass("open");
	} else {
		element.addClass("open");
		element.siblings("li").removeClass("open");
		element.siblings("li").find("li").removeClass("open");
	}
});

$(".header__search-btn").on("click", function () {
	$(this).toggleClass("active");
	$(".header-search-form").toggleClass("active");
});

$(document).on("click touchstart", function (e) {
	if (!$(e.target).is(".header__search-btn, .header__search-btn *, .header-search-form, .header-search-form *")) {
		$(".header-search-form").removeClass("active");
		$(".header__search-btn").removeClass("active");
	}
});

// main wrapper calculator
var bodySelector = document.querySelector("body");
var headerTop = document.querySelector(".header__top");
var heroSection = document.querySelector(".hero-section");
var innerHeroSection = document.querySelector(".inner-hero");

(function () {
	if (bodySelector.contains(headerTop) && bodySelector.contains(heroSection)) {
		var headerTopHeight = headerTop.clientHeight;

		var totalHeight = parseInt(headerTopHeight, 10) + "px";
		heroSection.style.marginTop = `${totalHeight}`;
	}

	if (bodySelector.contains(headerTop) && bodySelector.contains(innerHeroSection)) {
		var headerTopHeight = headerTop.clientHeight;

		var totalHeight = parseInt(headerTopHeight, 10) + "px";
		innerHeroSection.style.marginTop = `${totalHeight}`;
	}
})();

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Show or hide the sticky footer button
$(window).on("scroll", function () {
	if ($(this).scrollTop() > 200) {
		$(".scroll-to-top").fadeIn(200);
	} else {
		$(".scroll-to-top").fadeOut(200);
	}
});

// Animate the scroll to top
$(".scroll-to-top").on("click", function (event) {
	event.preventDefault();
	$("html, body").animate({ scrollTop: 0 }, 300);
});

new WOW().init();

// lightcase plugin init
$("a[data-rel^=lightcase]").lightcase();

$(".datepicker-here").datepicker({
	autoClose: true,
	minDate: new Date()
});

// faq js
$(".faq-single__header").each(function () {
	$(this).on("click", function () {
		$(this).siblings(".faq-single__content").slideToggle();
		$(this).parent(".faq-single").toggleClass("active");
	});
});

// brand image append js
$(".brand-item").each(function () {
	var imgsrc = $(this).attr("data-src");
	$(this).append(`
    <img src="${imgsrc}" alt="image" class="front-img">
    <img src="${imgsrc}" alt="image" class="back-img">
  `);
});

$(".sidebar-open-btn").on("click", function () {
	$(".sidebar").addClass("active");
});

$(".sidebar-close-btn").on("click", function () {
	$(".sidebar").removeClass("active");
});

$(".user-sidebar-open-btn").on("click", function () {
	$(".user-sidebar__menu").slideToggle();
});

// other-room-slider js
$(".other-room-slider").slick({
	infinite: true,
	slidesToShow: 3,
	slidesToScroll: 1,
	dots: false,
	arrows: true,
	prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
	nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
	autoplay: false,
	cssEase: "cubic-bezier(0.645, 0.045, 0.355, 1.000)",
	speed: 1000,
	autoplaySpeed: 1000,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 4,
			},
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 3,
			},
		},
		{
			breakpoint: 768,
			settings: {
				slidesToShow: 2,
			},
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
			},
		},
	],
});

// testimonial-slider js
$(".testimonial-slider").slick({
	infinite: true,
	slidesToShow: 4,
	slidesToScroll: 1,
	dots: false,
	arrows: false,
	autoplay: true,
	cssEase: "cubic-bezier(0.645, 0.045, 0.355, 1.000)",
	speed: 2000,
	autoplaySpeed: 1000,
	responsive: [
		{
			breakpoint: 1400,
			settings: {
				slidesToShow: 3,
			},
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 2,
			},
		},
		{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
			},
		},
	],
});

$(".room-details-thumb-slider").slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	dots: false,
	fade: true,
	asNavFor: ".room-details-nav-slider",
});
$(".room-details-nav-slider").slick({
	slidesToShow: 4,
	slidesToScroll: 1,
	asNavFor: ".room-details-thumb-slider",
	arrows: false,
	dots: false,
	focusOnSelect: true,
});

$(".sidebar-open-btn").on("click", function (e) {
	$(".overlay").toggleClass("active");
});

$(".sidebar-close-btn").on("click", function (e) {
	$(".overlay").removeClass("active");
});

$(".overlay").on("click", function (e) {
	$(".overlay").removeClass("active");
	$(".sidebar").removeClass("active");
});

$(".user-sidebar-toggler").on("click", function (e) {
	$(".overlay").toggleClass("active");
	$(".user-sidebar").toggleClass("active");
});

$(".sidebar-close, .overlay").on("click", function (e) {
	$(".overlay").removeClass("active");
	$(".user-sidebar").removeClass("active");
});

$('.datepicker-here').on('keydown', function () {
	return false;
})