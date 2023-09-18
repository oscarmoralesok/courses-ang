import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const tooltipTriggerList = document.querySelectorAll('.tooltipToggle')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))