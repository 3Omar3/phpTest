<?php 
    include_once("../layaout/header.php");
?>

<body>
  <main>
  <div class="container mt-5">
        <h1 class="text-center">CRUD Admins</h1>

        <!-- Button to trigger Create Admin Modal -->
        <div class="text-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAdminModal">Add Admin</button>
        </div>

        <!-- Admins Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="adminsTable">
                <!-- AJAX will populate this -->
            </tbody>
        </table>
    </div>
</main>


<!-- Create Admin Modal -->
<div class="modal fade" id="createAdminModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="create-error-message" class="alert alert-danger d-none"></div>
                    <form id="createAdminForm">
                        <div class="mb-3">
                            <label for="createEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="createEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="createPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="createPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Admin Modal -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="edit-error-message" class="alert alert-danger d-none"></div>
                    <form id="editAdminForm">
                        <input type="hidden" id="editAdminId">
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editPassword">
                            <small class="text-muted">Leave blank to keep the current password</small>
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

<script src="../sources/admins.js"></script>                                            