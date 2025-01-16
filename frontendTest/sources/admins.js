// Fetch Admins and populate the table
function fetchAdmins() {
    $.ajax({
        url: 'http://localhost/crud/apiTest/rest.php?endpoint=admins',
        method: 'GET',
        success: function (admins) {
            let rows = '';
            admins.forEach(admin => {
                rows += `
                    <tr>
                        <td>${admin.id}</td>
                        <td>${admin.email}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="showEditAdminModal(${admin.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteAdmin(${admin.id})">Delete</button>
                        </td>
                    </tr>
                `;
            });
            $('#adminsTable').html(rows);
        },
        error: function () {
            alert('Failed to fetch admins.');
        }
    });
}

// Create Admin
$('#createAdminForm').submit(function (e) {
    e.preventDefault();

    const admin = {
        email: $('#createEmail').val(),
        password: $('#createPassword').val()
    };

    $.ajax({
        url: 'http://localhost/crud/apiTest/rest.php?endpoint=admins',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(admin),
        success: function (res) {
            if (res.success) {
                fetchAdmins();
                $('#createAdminModal').modal('hide');
                $('#createAdminForm')[0].reset();
            } else {
                $('#create-error-message').removeClass('d-none').text(res.message);
            }
        },
        error: function () {
            $('#create-error-message').removeClass('d-none').text('Failed to create admin.');
        }
    });
});

// Show Edit Admin Modal
function showEditAdminModal(id) {
    $.ajax({
        url: `http://localhost/crud/apiTest/rest.php?endpoint=admins&id=${id}`,
        method: 'GET',
        success: function (admin) {
            console.log(admin);
            $('#editAdminId').val(admin.id);
            $('#editEmail').val(admin.email);
            $('#editPassword').val('');
            $('#edit-error-message').addClass('d-none');
            $('#editAdminModal').modal('show');
        },
        error: function () {
            alert('Failed to fetch admin data.');
        }
    });
}

// Update Admin
$('#editAdminForm').submit(function (e) {
    e.preventDefault();

    const id = $('#editAdminId').val();
    const email = $('#editEmail').val();
    const password = $('#editPassword').val();

    const adminData = { email };
    if (password) adminData.password = password;

    $.ajax({
        url: `http://localhost/crud/apiTest/rest.php?endpoint=admins&id=${id}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(adminData),
        success: function (res) {
            if (res.success) {
                fetchAdmins();
                $('#editAdminModal').modal('hide');
            } else {
                $('#edit-error-message').removeClass('d-none').text(res.message);
            }
        },
        error: function () {
            $('#edit-error-message').removeClass('d-none').text('Failed to update admin.');
        }
    });
});

// Delete Admin
function deleteAdmin(id) {
    if (confirm('Are you sure you want to delete this admin?')) {
        $.ajax({
            url: `http://localhost/crud/apiTest/rest.php?endpoint=admins&id=${id}`,
            method: 'DELETE',
            success: function (res) {
                if (res.success) {
                    fetchAdmins();
                } else {
                    alert('Failed to delete admin.');
                }
            },
            error: function () {
                alert('Failed to delete admin.');
            }
        });
    }
}

// Load admins on page load
$(document).ready(function () {
    fetchAdmins();
});
