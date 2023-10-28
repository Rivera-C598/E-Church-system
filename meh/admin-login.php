

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Archdiocesan Shrine of Apostol de Compostela - Admin login</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    />
  </head>
  <body>
    <header class="bg-dark text-light">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
          <a class="navbar-brand" href="#">
            <img
              src="imgs/church-logo.png"
              alt="Church Logo"
              width="40"
              height="auto"
            />
            Archidiocesan Shrine of Apostol de Compostela
          </a>
        </nav>
      </div>
    </header>

    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <h1 class="text-center">Admin Login</h1>
          <form action="admin-login-authorize.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" name="email" class="form-control" required />
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input
                type="password"
                name="password"
                class="form-control"
                id="password"
                required
              />
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Log in</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <footer class="bg-dark text-light text-center py-3">
      <div class="container">&copy; 2023 Your Website</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
