import './bootstrap';

$(document).ready(function() {
    console.log('jqof')
    setTimeout(function() {        
        $('#quick-message').fadeOut('slow');
    }, 3000);
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
