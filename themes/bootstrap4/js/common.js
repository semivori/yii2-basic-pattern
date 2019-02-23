$(document).ready(function () {

    // Hide alerts:
    window.setTimeout(function() {
        $(".alert").alert('close');
    }, 5000);

    // Chosen
    $(".chosen-select").chosen({
        no_results_text: "Nothing found."
    });

});
