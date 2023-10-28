<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Archdiocesan Shrine of Apostol de Compostela - Admin Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
  <header class="bg-dark text-light">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">
          <img src="imgs/church-logo.png" alt="Church Logo" width="40" height="auto" />
          Archdiocesan Shrine of Apostol de Compostela
        </a>
      </nav>
    </div>
  </header>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <h1 class="text-center">Admin Registration</h1>
        <form action="admin-registration-authorize.php" method="POST">
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" name="first_name" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name:</label>
            <input type="text" name="last_name" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="number" class="form-label">Number:</label>
            <input type="tel" name="number" class="form-control" required pattern="09\d{9}" title="Invalid number format. It should be an 11-digit number starting with 09." maxlength="11" />
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password requirements: Minimum 8 characters, at least one uppercase letter, one lowercase letter, one digit, and one special character." />
          </div>

          <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password:</label>
            <input type="password" name="confirm_password" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Passwords do not match' : '');" oninput="clearError('confirm-password-error')" />
            <span class="error" id="confirm-password-error"></span>
          </div>

          <div class="mb-3">
            <label for="verification_code" class="form-label">Verification Code:</label>
            <input type="text" name="verification_code" class="form-control" required />
            <div id="verification-code-error" class="error"></div>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary" id="submit-button">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer class="bg-dark text-light text-center py-3">
    <div class="container">&copy; 2023 Your Website</div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function clearError(elementId) {
      document.getElementById(elementId).textContent = '';
    }

    document.addEventListener("DOMContentLoaded", function() {
      const form = document.querySelector("form");
      const submitButton = document.querySelector("#submit-button");
      const numberInput = document.querySelector("input[name='number']");

      numberInput.addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
      });

      form.addEventListener("submit", function(event) {
        let isValid = true;
        const numberPattern = /^09\d{9}$/;
        const passwordPattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&!])[A-Za-z\d@#$%^&!]{8,}$/;

        const firstName = document.querySelector("input[name='first_name']").value;
        const lastName = document.querySelector("input[name='last_name']").value;
        const number = document.querySelector("input[name='number']").value;
        const email = document.querySelector("input[name='email']").value;
        const password = document.querySelector("input[name='password']").value;
        const confirmPassword = document.querySelector("input[name='confirm_password']").value;
        const verificationCode = document.querySelector("input[name='verification_code']").value;

        if (!numberPattern.test(number)) {
          isValid = false;
          document.querySelector("#number-error").textContent = "Invalid phone number format. It should be an 11-digit number starting with 09.";
        }

        if (!passwordPattern.test(password)) {
          isValid = false;
          document.querySelector("#password-error").textContent = "Password requirements: Minimum 8 characters, at least one uppercase letter, one lowercase letter, one digit, and one special character (@, #, $, %, ^, &, !).";
        }

        if (password !== confirmPassword) {
          isValid = false;
          document.querySelector("#confirm-password-error").textContent = "Passwords do not match.";
        }

        if (!isValid) {
          event.preventDefault();
        }
      });
    });
  </script>
</body>

</html>