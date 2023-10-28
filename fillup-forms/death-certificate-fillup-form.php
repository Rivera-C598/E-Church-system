<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Death Certificate Request Form</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>

    <header class="bg-dark text-light">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="#">
                    <img src="../imgs/church-logo.png" alt="Church Logo" width="40" height="auto" />
                    Archidiocesan Shrine of Apostol de Compostela
                </a>
            </nav>
        </div>
    </header>

    <!-- Hero for the "Baptism Certificate Request Form" -->
    <section class="hero" id="formTitle">
        <div class="container">
            <h2>Death Certificate</h2>
            <p>REQUEST FORM</p>
        </div>
    </section>

    <section class="content py-5">
        <div class="container">
            <!-- Baptism Certificate Request Form -->
            <form action="../processing/process-baptismal-certificate-request.php" method="POST">
                <div class="mb-3">
                    <label for="nameOfTheDeceased" class="form-label">Name of the Deceased:</label>
                    <input type="text" class="form-control" id="nameOfTheDeceased" name="nameOfTheDeceased" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="dateOfBirth" class="form-label">Date of birth:</label>
                        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dateOfDeath" class="form-label">Date of death:</label>
                        <input type="date" class="form-control" id="dateOfDeath" name="dateOfDeath" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="familyName" class="form-label">Family's Name:</label>
                    <input type="text" class="form-control" id="familyName" name="familyName" placeholder="ex: Gibson Family" required>
                </div>
                <div class="mb-3">
                    <label for="requesterName" class="form-label">Requester Name:</label>
                    <input type="text" class="form-control" id="requesterName" name="requesterName" required>
                </div>
                <div class="mb-3">
                    <label for="requesterEmail" class="form-label">Requester Email:</label>
                    <input type="email" class="form-control" id="requesterEmail" name="requesterEmail" required>
                </div>
                <div class="mb-3">
                    <label for="phoneNumber" class="form-label">Requester Phone number:</label>
                    <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" pattern="9\d{8}" title="Invalid number format. It should be an 10-digit number starting with 9." placeholder="9----------" maxlength="10" required>
                </div>
                <button type="submit" class="btn btn-primary" id="showConfirmation">Submit</button>
            </form>

            <!-- Confirmation screen -->
            <div id="confirmationScreen" class="d-none">
                <h3>Confirmation</h3>
                <p>Please review your information before submitting:</p>
                <div class="mb-3">
                    <strong>Name of the deceased: </strong> <span id="confirmNameOfTheDeceased"></span>
                </div>
                <div class="mb-3">
                    <strong>Date of birth: </strong> <span id="confirmDOB"></span>
                </div>
                <div class="mb-3">
                    <strong>Date of death: </strong> <span id="confirmDateOfDeath"></span>
                </div>
                <div class="mb-3">
                    <strong>Family Name: </strong> <span id="confirmFamilyName"></span>
                </div>
                <div class="mb-3">
                    <strong>Requester Name: </strong> <span id="confirmRequesterName"></span>
                </div>
                <div class="mb-3">
                    <strong>Requester Email: </strong> <span id="confirmEmail"></span>
                </div>
                <div class="mb-3">
                    <strong>Requester Phone Number: </strong> <span id="confirmNumber"></span>
                </div>

                <button type="button" class="btn btn-primary" id="backToForm">Back to Form</button>
                <button type="button" class="btn btn-primary" id="submitRequest">Confirm and Submit</button>
            </div>
        </div>
    </section>



    <footer class="bg-dark text-light text-center py-3">
        <div class="container">&copy; 2023 Your Website</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deathCertForm = document.querySelector("form");
            const confirmationScreen = document.getElementById("confirmationScreen");
            const showConfirmationBtn = document.getElementById("showConfirmation");
            const backToFormBtn = document.getElementById("backToForm");
            const submitRequestBtn = document.getElementById("submitRequest");

            showConfirmationBtn.addEventListener("click", function(event) {
                event.preventDefault();

                // If validation passes, proceed to display the confirmation screen
                if (validateForm(deathCertForm)) {
                    document.getElementById("confirmNameOfTheDeceased").textContent = deathCertForm.nameOfTheDeceased.value;
                    document.getElementById("confirmDOB").textContent = deathCertForm.dateOfBirth.value;
                    document.getElementById("confirmDateOfDeath").textContent = deathCertForm.dateOfDeath.value;
                    document.getElementById("confirmFamilyName").textContent = deathCertForm.familyName.value;
                    document.getElementById("confirmRequesterName").textContent = deathCertForm.requesterName.value;
                    document.getElementById("confirmEmail").textContent = deathCertForm.requesterEmail.value;
                    document.getElementById("confirmNumber").textContent = deathCertForm.phoneNumber.value;

                    deathCertForm.classList.add("d-none");
                    confirmationScreen.classList.remove("d-none");
                }
            });

            backToFormBtn.addEventListener("click", function(event) {
                event.preventDefault();
                confirmationScreen.classList.add("d-none");
                deathCertForm.classList.remove("d-none");
            });

            submitRequestBtn.addEventListener("click", function(event) {
                event.preventDefault();

                const formData = new FormData(deathCertForm);

                if (validateForm(deathCertForm)) {
                    fetch("../processing/process-death-certificate-request.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            throw new Error("Network response was not ok");
                        }
                    })
                    .then((data) => {
                        if (data.message === 'success') {
                            window.location.href = "../form-submitted-response.html";
                        } else {
                            console.error("Server Error:", data);
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
                }
            });

            // Function to validate the form
            function validateForm(form) {
                const name = form.nameOfTheDeceased.value;
                const dateOfBirth = form.dateOfBirth.value;
                const dateOfDeath = form.dateOfDeath.value;
                const familyName = form.familyName.value;
                const requesterName = form.requesterName.value;
                const requesterEmail = form.requesterEmail.value;
                const phoneNumber = form.phoneNumber.value;

                if (name.trim() === "" || dateOfBirth.trim() === "" || dateOfDeath.trim() === "" || familyName.trim() === "" || requesterName.trim() === "" || requesterEmail.trim() === "" || phoneNumber.trim() === "") {
                    alert("All fields are required.");
                    return false;
                }

                if (!validateEmail(requesterEmail)) {
                    alert("Invalid email format.");
                    return false;
                }

                return true;
            }

            // Function to validate email format
            function validateEmail(email) {
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                return emailPattern.test(email);
            }
        });
    </script>

</body>

</html>

