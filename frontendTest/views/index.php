<?php 
    include_once("../layaout/header.php");
?>

<body>
  <main>
<div class="container mt-4">
    <h1 class="text-center">CRUD Users</h1>
    <a href="http://localhost/crud/frontendTest/views/admins.php">
      <button type="button" class="btn btn-primary">
        ADMINS
      </button>
    </a>
    <div class="text-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Add User</button>
    </div>

    <!-- Users Table -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="usersTable">
        <!-- AJAX will populate the rows here -->
        </tbody>
    </table>
</div>
</main>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createUserForm">
                    <div class="mb-3">
                        <label for="createName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="createName" required>
                    </div>
                    <div class="mb-3">
                        <label for="createLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="createLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="createAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="createAddress" required>
                    </div>
                    <div class="mb-3">
                        <label for="createEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="createEmail" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="editAddress" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
    include_once("../layaout/footer.php");
?>

<script src="../sources/users.js"></script>