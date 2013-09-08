$(document).ready(function(){
    site.init();
});

site = {
    
    init: function(){
        "use strict";
        
        // HTML5ify IE
        if ($('html').hasClass('lt-ie9')) {
            document.createElement('header');
            document.createElement('nav');
            document.createElement('section');
            document.createElement('article');
            document.createElement('aside');
            document.createElement('footer');
        }
        site.initUI();
        site.initEvents();
        
    },
    
    initEvents: function(){
        "use strict";
        
        // All event handlers get attached here
    },
    
    initUI: function(){
        "use strict";
        
        // Layout adjustments happen here
    }
    
    
}
