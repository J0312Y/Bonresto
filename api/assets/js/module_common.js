$(document).ready(function() {

    $('table.table').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "order": [[0, "asc"]],
        "autoWidth": false
    });

    $('a.btn-danger').on('click', function(e) {
        if (!confirm('⚠️ Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    });

    function showToast(type, message) {
        var toastHTML = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;
        $('#toast-container').append(toastHTML);
        new bootstrap.Toast($('#toast-container .toast').last()[0]).show();
    }

    $('.flash-message').each(function() {
        var type = $(this).data('type');
        var msg = $(this).text();
        showToast(type, msg);
    });
});
