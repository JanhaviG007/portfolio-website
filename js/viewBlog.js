/**
 * viewBlog.js
 * JavaScript for the View Blog page (viewBlog.php)
 *
 * Extra Feature: Archive/Filter by month dropdown
 */


/**
 * Filter by Month Function
 *
 * Reloads viewBlog.php with a ?month= query parameter matching the
 * selected value from the archive dropdown.
 */
function filterByMonth() {
    var monthSelect    = document.getElementById('month-filter');
    var selectedMonth  = monthSelect.value;

    if (selectedMonth === '') {
        window.location.href = 'viewBlog.php';
    } else {
        window.location.href = 'viewBlog.php?month=' + selectedMonth;
    }
}
