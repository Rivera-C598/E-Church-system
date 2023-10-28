<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $nameOfTheDeceased = $_POST['nameOfTheDeceased'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $dateOfDeath = $_POST['dateOfDeath'];
    $familyName = $_POST['familyName'];
    $requesterName = $_POST['requesterName'];
    $requesterEmail = $_POST['requesterEmail'];
    $phoneNumber = $_POST['phoneNumber'];

    // Perform data validation
    if (empty($nameOfTheDeceased) || empty($dateOfBirth) || empty($dateOfDeath) || empty($familyName) ||empty($requesterName) ||empty($requesterEmail) || empty($phoneNumber)) {
        echo json_encode(['message' => 'error', 'error' => 'All fields are required.']);
        exit;
    }

    if (!filter_var($requesterEmail, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['message' => 'error', 'error' => 'Invalid email format.']);
        exit;
    }

    // Include your database configuration
    include '../database/dbconfig.php';

    // Generate a unique 10-character ticket number
    $ticketNumber = generateTicketNumber($pdo);

    $status = "Not ready";
    $documentType = "Death Certificate";
    // Insert data into the database
    $sql = "INSERT INTO death_certificate_requests 
    (document_type, name_of_the_deceased, date_of_birth, 
    date_of_death, family_name, requester_name, requester_email, requester_number, 
    ticket_code, status)
     VALUES (?, ?, ?, ?, ?, ?, ? ,?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$documentType, $nameOfTheDeceased, $dateOfBirth, $dateOfDeath, $familyName, $requesterName, $requesterEmail, $phoneNumber, $ticketNumber, $status]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'success', 'ticket_code' => $ticketNumber]);
    } else {
        echo json_encode(['message' => 'error', 'error' => 'Database insertion failed.']);
    }
}

// Function to generate a unique 10-character ticket number
function generateTicketNumber($pdo)
{
    $ticketNumber = generateRandomString(10); // You need to implement this function
    // Check if the generated ticket number already exists in the database

    

    $sql = "SELECT COUNT(*) AS ticket_codes 
    FROM (SELECT ticket_code FROM baptismal_certificate_requests 
    UNION ALL 
    SELECT ticket_code FROM marriage_certificate_requests
    UNION ALL
    SELECT ticket_code FROM death_certificate_requests)
    AS combined
    WHERE ticket_code = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ticketNumber]);
    $count = $stmt->fetchColumn();

    // If the ticket number is not unique, generate a new one
    while ($count > 0) {
        $ticketNumber = generateRandomString(10);
        $stmt->execute([$ticketNumber]);
        $count = $stmt->fetchColumn();
    }

    return $ticketNumber;
}

// Function to generate a random string of a specified length
function generateRandomString($length)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
