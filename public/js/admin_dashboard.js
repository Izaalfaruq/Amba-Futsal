// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');
});

// Initial hide of the sidebar
sidebar.classList.add('hide');


const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
    if(window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle('show');
        if(searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    }
})

if(window.innerWidth < 768) {
    sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
    if(this.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
})
//dropdown
document.getElementById("profileDropdown").addEventListener("click", function() {
    var dropdownContent = document.getElementById("profileDropdownContent");
    dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";
});

// Close the dropdown when clicking outside
document.addEventListener("click", function(event) {
    var dropdown = document.getElementById("profileDropdownContent");
    if (!event.target.closest(".dropdown") && dropdown.style.display === "block") {
        dropdown.style.display = "none";
    }
});

