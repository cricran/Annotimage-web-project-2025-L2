$(document).ready(function () {
    window.addEventListener('scroll', function () {
        const searchBar = document.getElementById('searchBarTop');
        if (window.scrollY > 300) {
            searchBar.classList.add('show');
        } else {
            searchBar.classList.remove('show');
        }
    });
});