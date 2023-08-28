// document.getElementById("defaultOpen").click();
// function openCity(evt, cityName) {
// // Declare all variables
// var i, tabcontent, tablinks;

// // Get all elements with class="tabcontent" and hide them
// tabcontent = document.getElementsByClassName("tabcontent");
// for (i = 0; i < tabcontent.length; i++) {
// tabcontent[i].style.display = "none";
// }

// // Get all elements with class="tablinks" and remove the class "active"
// tablinks = document.getElementsByClassName("tablinks");
// for (i = 0; i < tablinks.length; i++) {
// tablinks[i].className = tablinks[i].className.replace(" active", "");
// }

// // Show the current tab, and add an "active" class to the button that opened the tab
// document.getElementById(cityName).style.display = "block";
// evt.currentTarget.className += " active";
// }

function auto_top(){
    var nav = jQuery('.main-nav').outerHeight();
    jQuery('#page-container').attr('style', 'padding-top: ' + nav + 'px !important');
}

jQuery(function(){
    auto_top();
});
// jQuery( document ).load(function() {
//     auto_top();
// });
// jQuery( window ).on("resize", function() {
//     auto_top();
// });
jQuery(window).on("scroll", function(){
    auto_top();
});

jQuery(".dropdown").on("click", function(){
    if(jQuery(this).parent().hasClass("show")){
        jQuery(this).parent().removeClass("show");
    }else{
        jQuery(this).parent().addClass("show");
    }
})

jQuery(".cart-container img").on("click", function(){
    jQuery("#viewOrder").addClass("active");
})

jQuery("#viewOrder .close").on("click", function(){
    jQuery("#viewOrder").removeClass("active");
})