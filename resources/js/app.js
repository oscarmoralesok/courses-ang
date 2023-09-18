import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const tooltipTriggerList = document.querySelectorAll('.tooltipToggle')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

$(function () {
	
	$('nav.menu-nav ul li').hover(function () {
		$(this).find('span').toggleClass('d-none');
	})

})