    // Fetch and display all users
    function fetchUsers() {
        $.ajax({
            url: 'http://localhost/crud/apiTest/rest.php?endpoint=users',
            method: 'GET',
            success: function (users) {
                let rows = '';
                users.forEach(user => {
                    rows += `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                            <td>${user.lastname}</td>
                            <td>${user.address}</td>
                            <td>${user.email}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showEditUserModal(${user.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $('#usersTable').html(rows);
            }
        });
    }

    // Create a new user
    $('#createUserForm').submit(function (e) {
        e.preventDefault();
        const user = {
            name: $('#createName').val(),
            lastname: $('#createLastName').val(),
            address: $('#createAddress').val(),
            email: $('#createEmail').val()
        };

        $.ajax({
            url: 'http://localhost/crud/apiTest/rest.php?endpoint=users',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(user),
            success: function () {
                fetchUsers();
                $('#createUserModal').modal('hide');
            }
        });
    });

    // Show edit modal
    function showEditUserModal(id) {
        $.ajax({
            url: `http://localhost/crud/apiTest/rest.php?endpoint=users&id=${id}`,
            method: 'GET',
            success: function (user) {
                $('#editUserId').val(user.id);
                $('#editName').val(user.name);
                $('#editLastName').val(user.lastname);
                $('#editAddress').val(user.address);
                $('#editEmail').val(user.email);
                $('#editUserModal').modal('show');
            }
        });
    }

    // Update a user
    $('#editUserForm').submit(function (e) {
        e.preventDefault();
        const id = $('#editUserId').val();
        const user = {
            name: $('#editName').val(),
            lastname: $('#editLastName').val(),
            address: $('#editAddress').val(),
            email: $('#editEmail').val()
        };

        $.ajax({
            url: `http://localhost/crud/apiTest/rest.php?endpoint=users&id=${id}`,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(user),
            success: function () {
                fetchUsers();
                $('#editUserModal').modal('hide');
            }
        });
    });

    // Delete a user
    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: `http://localhost/crud/apiTest/rest.php?endpoint=users&id=${id}`,
                method: 'DELETE',
                success: function () {
                    fetchUsers();
                }
            });
        }
    }

    // Load users on page load
    $(document).ready(function () {
        fetchUsers();
    });