<?php 
    include_once("./layaout/header.php");
?>

<body>
    <main style='height: 100svh; place-content: center;'>
        <div class="card container" style='max-width: 300px; margin: 0 auto;'>
            <h2 class="card-header text-center">Login</h2>
            <form id="loginForm">
            <div class="card-body">
                <div id="error-message" class="alert alert-danger d-none" role="alert"></div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" id="email" type="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </div>
            </form>
        </div>
    </main>
</body>

<?php 
    include_once("./layaout/footer.php");
?>

<script src="./sources/login.js"></script>