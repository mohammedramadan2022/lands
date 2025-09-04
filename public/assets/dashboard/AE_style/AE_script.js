console.log("start")
$(document).ready(function () {
    $('.AE_dropdown-toggle').click(function () {
        $(this).siblings('.AE_dropdown-menu').slideToggle();
    });
});

// button header
let AE_header_button = document.getElementById("AE_header_button");
AE_header_button.addEventListener("click", () => {
    document.querySelector(".AE_FastLink").classList.toggle("active")
})
$(document).ready(function () {
    $('#searchSideBar').on('input', function () {
        var searchValue = $(this).val().toLowerCase();
        var resultCount = 0;

        $('#navbar-nav li').filter(function () {
            var isVisible = $(this).text().toLowerCase().indexOf(searchValue) > -1;
            $(this).toggle(isVisible);

            if (isVisible) {
                resultCount++;
            }
        });

        // Display the result count
        $('#resultCount').css('display', 'block').text(resultCount + ' نتائج');
    });
});

$('.light-dark-mode').click(function () {
    var navbarMenu = document.getElementsByClassName('navbar-menu');
    var userHeader = document.getElementsByClassName('topbar-user');
    var AE_dropdownMenu = document.getElementsByClassName('AE_dropdown-menu');
    var header = document.getElementById('page-topbar');
    var navbarSupportedContent = document.getElementById('navbarSupportedContent');

    // Check if 'dark-side' is already set in local storage
    if (localStorage.getItem('dark-mode') === 'enabled') {
        // Remove the 'dark-side' and 'semi-dark' classes from all elements and clear local storage
        [...navbarMenu].forEach(el => el.classList.remove('dark-side'));
        [...AE_dropdownMenu].forEach(el => el.classList.remove('dark-side'));
        [...userHeader].forEach(el => el.classList.remove('semi-dark'));
        if (header) header.classList.remove('semi-dark');
        if (navbarSupportedContent) navbarSupportedContent.classList.remove('semi-dark');

        localStorage.removeItem('dark-mode');
    } else {
        // Add the 'dark-side' and 'semi-dark' classes and set it in local storage
        [...navbarMenu].forEach(el => el.classList.add('dark-side'));
        [...AE_dropdownMenu].forEach(el => el.classList.add('dark-side'));
        [...userHeader].forEach(el => el.classList.add('semi-dark'));
        if (header) header.classList.add('semi-dark');
        if (navbarSupportedContent) navbarSupportedContent.classList.add('semi-dark');

        localStorage.setItem('dark-mode', 'enabled');
    }
});

// On page load, check if 'dark-mode' is enabled and apply the class if needed
$(document).ready(function () {
    if (localStorage.getItem('dark-mode') === 'enabled') {
        var navbarMenu = document.getElementsByClassName('navbar-menu');
        var header = document.getElementById('page-topbar');
        var userHeader = document.getElementsByClassName('topbar-user');
        var AE_dropdownMenu = document.getElementsByClassName('AE_dropdown-menu');
        var navbarSupportedContent = document.getElementById('navbarSupportedContent');

        [...navbarMenu].forEach(el => el.classList.add('dark-side'));
        [...AE_dropdownMenu].forEach(el => el.classList.add('dark-side'));
        [...userHeader].forEach(el => el.classList.add('semi-dark'));
        if (header) header.classList.add('semi-dark');
        if (navbarSupportedContent) navbarSupportedContent.classList.add('semi-dark');
    }
});

$(document).ready(function () {
    // Function to show the corresponding nav-side-ya element
    function showActiveElement() {
        // Get the active header-link-ya
        const activeLink = $('.header-link-ya.active');

        // If there's an active link, show the corresponding nav-side-ya element
        if (activeLink.length) {
            const openId = activeLink.attr('data-open');

            // Hide all nav-side-ya elements
            $('.nav-side-ya').hide();

            // Show the nav-side-ya element with the matching data-id
            $('.nav-side-ya[data-id="' + openId + '"]').removeClass('d-none').show();
        }
    }

    // On page load, show the active element
    showActiveElement();

    // Handle click event for header-link-ya
    $('.header-link-ya').click(function () {

        window.location = $(this).attr('data-routeName');
        // Remove 'active' class from all header-link-ya elements
        $('.header-link-ya').removeClass('active');

        // Add 'active' class to the clicked element
        $(this).addClass('active');

        // Show the corresponding nav-side-ya element
        showActiveElement();
    });
});
