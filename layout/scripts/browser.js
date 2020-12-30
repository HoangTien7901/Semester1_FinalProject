// prevent form from resubmiting when page is refreshed
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// for I.E so that update can take effect
$.ajaxSetup({
    // Disable caching of AJAX responses */
    cache: false,
});