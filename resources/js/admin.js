$(document).ready(function () {
    // Risk filter form submission
    $('#risk-filter-form').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: window.appRoutes.filterRisks,
            method: 'GET',
            data: formData,
            success: function (response) {
                $('#risks-table-container').html(response.table);
                $('#risks-pagination').html(response.pagination);
                $('#risks-total').text(response.total);
            },
            error: function (xhr) {
                alert('Error filtering risks: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    });

    // User filter form submission
    $('#user-filter-form').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: window.appRoutes.filterUsers,
            method: 'GET',
            data: formData,
            success: function (response) {
                $('#users-table-container').html(response.table);
                $('#users-total').text(response.total);
            },
            error: function (xhr) {
                alert('Error filtering users: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    });

    // Handle pagination clicks via AJAX
    $(document).on('click', '#risks-pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');

        $.ajax({
            url: url,
            method: 'GET',
            success: function (response) {
                $('#risks-table-container').html(response.table);
                $('#risks-pagination').html(response.pagination);
                $('#risks-total').text(response.total);
            },
            error: function (xhr) {
                alert('Error loading page: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    });
});