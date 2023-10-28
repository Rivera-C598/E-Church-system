<?php
include '../../../dbconfig.php';

// Function to fetch the document requests
function fetchDocumentRequests($pdo) {
    $sql = "
    SELECT ticket_code, 'Baptism Certificate' AS document_type, requester_name, requester_email, requester_number, date_requested, status FROM baptismal_certificate_requests
    UNION ALL
    SELECT ticket_code, 'Death Certificate' AS document_type, requester_name, requester_email, requester_number, date_requested, status FROM death_certificate_requests
    UNION ALL
    SELECT ticket_code, 'Marriage Certificate' AS document_type, requester_name, requester_email, requester_number, date_requested, status FROM marriage_certificate_requests
    ORDER BY date_requested DESC;
    ";
    
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$results = fetchDocumentRequests($pdo);

// Output the results as JSON
echo json_encode($results);
?>
