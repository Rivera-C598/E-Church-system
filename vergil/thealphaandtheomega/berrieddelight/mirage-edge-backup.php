<?php
header("Cache-Control: no-cache, must-revalidate");

session_start();

if (!isset($_SESSION['admin-authorized']) || $_SESSION['admin-authorized'] !== true) {
    // Redirect to the login
    header('Location: ../urizen.php');
    exit;
}



//superadmin control panel
include '../../../database/dbconfig.php';

$sql = "
SELECT ticket_code, document_type, requester_name, requester_email, requester_number, date_requested, status FROM baptismal_certificate_requests
UNION ALL
SELECT ticket_code, document_type, requester_name, requester_email, requester_number, date_requested, status FROM death_certificate_requests
UNION ALL
SELECT ticket_code, document_type, requester_name, requester_email, requester_number, date_requested, status FROM marriage_certificate_requests
ORDER BY date_requested DESC;
";

try {
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <title>Control Panel</title>
    <style>
        /* Add a red border above the navbar */
        header {
            border-top: 5px solid red;
        }

        footer {
            margin-top: 30vh;
            ;
        }




        /* Add a red border below the footer */
    </style>
</head>

<body>
    <header class="bg-dark text-light">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="#">
                    <img src="../../../imgs/church-logo.png" alt="Church Logo" width="40" height="auto" />
                    Archidiocesan Shrine of Apostol de Compostela
                </a>
            </nav>
        </div>
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="display-4 text-center">Control Panel</h1>

            </div>
        </div>
    </div>

    <!-- Hero section for the table and CRUD controls -->
    <div class="container mt-5">
        <div class="row">
            <h2 class="text-center">Document Requests</h2>

            <!-- Search bar -->
            <div class="input-group py-3">
                <input type="text" class="form-control" placeholder="Search...">
                <button class="btn btn-primary" type="button">Search</button>
            </div>

            <div class="col-lg-12">

                <!-- Bootstrap table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Ticket</th>
                            <th scope="col">Document requested</th>
                            <th scope="col">Requester Name </th>
                            <th scope="col">Requester Email</th>
                            <th scope="col">Requester Number </th>
                            <th scope="col">Date Requested</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row) : ?>
                            <tr data-ticket-code="<?= $row['ticket_code'] ?>">
                                <td class="ticket-code"><?= $row['ticket_code'] ?></td>
                                <td class="document-type"><?= $row['document_type'] ?></td>
                                <td class="document-type"><?= $row['document_type'] ?></td>
                                <td class="date-requested"><?= $row['date_requested'] ?></td>
                                <td class="status"><?= $row['status'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <ul class="pagination justify-content-center" id="pagination">
                    <li class="page-item" id="prev-page">
                        <a href="#" class="page-link">Previous</a>
                    </li>
                    <!--Page numbers here-->
                    <li class="page-item" id="next-page">
                        <a href="#" class="page-link">Next</a>
                    </li>
                </ul>

                <button class="btn btn-danger" id="logoutButton">Logout</button>
            </div>



        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        // Pagination variables
        var currentPage = 1;
        var rowsPerPage = 10;
        var totalRows; // Total number of rows
        var totalPages;

        // Function to fetch and update the table
        function updateTable() {
            // Simulating data fetching, replace this with your actual data retrieval logic
            var data = <?php echo json_encode($results); ?>;

            // Calculate the total number of rows
            totalRows = data.length;

            // Calculate the total number of pages
            totalPages = Math.ceil(totalRows / rowsPerPage);

            // Check if currentPage is out of bounds and adjust it
            if (currentPage < 1) {
                currentPage = 1;
            } else if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            // Update the table based on the current page
            var startIndex = (currentPage - 1) * rowsPerPage;
            var endIndex = Math.min(startIndex + rowsPerPage, totalRows);

            // Clear the table
            $('table tbody').empty();

            // Populate the table with the data for the current page
            for (var i = startIndex; i < endIndex; i++) {
                var row = data[i];
                var $row = $('<tr data-ticket-code="' + row.ticket_code + '">');
                $row.append('<td class="ticket-code">' + row.ticket_code + '</td>');
                $row.append('<td class="document-type"> ' + row.document_type + ' </td>');
                $row.append('<td class="requester-name"> ' + row.requester_name + ' </td>');
                $row.append('<td class="requester-email"> ' + row.requester_email + ' </td>');
                $row.append('<td class="requester-number"> ' + row.requester_number + ' </td>');
                $row.append('<td class="date-requested">' + row.date_requested + '</td>');
                $row.append('<td class="status">' + row.status + '</td>');
                $('table tbody').append($row);
            }

            // Update the pagination buttons
            updatePaginationButtons();
        }

        // Function to update the pagination buttons
        function updatePaginationButtons() {
            $('#prev-page').toggleClass('disabled', currentPage <= 1);
            $('#next-page').toggleClass('disabled', currentPage >= totalPages);

            // calcluate range of numbers to be displayed
            var startPage = Math.max(currentPage - 2, 1);
            var endPage = Math.min(currentPage + 2, totalPages);

            //clear pagination list
            $('#pagination').find('li.page-number').remove();

            for (var i = startPage; i <= endPage; i++) {
                var $pageItem = $('<li class="page-item page-number ' + (i === currentPage ? 'active' : '') + '" ><a href="#" class= "page-link">' + i + '</a></li>');
                $pageItem.click(function() {
                    currentPage = parseInt($(this).text());
                    updateTable();
                });
                $('#next-page').before($pageItem);
            }


        }

        // Initial table load
        updateTable();

        // Event handler for previous page button
        $('#prev-page').click(function() {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });

        // Event handler for next page button
        $('#next-page').click(function() {
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const goToLoginBtn = document.getElementById("logoutButton");

            goToLoginBtn.addEventListener("click", function() {
                const xhr = new XMLHttpRequest();

                xhr.open("GET", "../../../unset-var-script.php", true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        window.location.href = "../urizen.php";
                    }
                };

                xhr.send();
            });
        });
    </script>




    <footer class="bg-dark text-light text-center py-3">
        <div class="container">&copy; 2023 Your Website</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>




</body>

</html>