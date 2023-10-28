<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the "documentType" POST parameter exists
    if (isset($_POST["documentType"])) {
        // Get the selected document type from the POST data
        $selectedDocument = $_POST["documentType"];

        // Perform additional actions based on the selected document type
        switch ($selectedDocument) {
            case "Baptismal Certificate":
                // Save data to a database, send email notifications, etc.
                // Redirect to the Baptismal Certificate fill-up form
                header("Location: fillup-forms/baptismal-certificate-fillup-form.php");
                exit;
            case "Marriage Certificate":
                header("Location: fillup-forms/marriage-certificate-fillup-form.php");
                exit;
                case "Death Certificate":
                    header("Location: fillup-forms/death-certificate-fillup-form.php");
                    exit;
            case "Other Document Type":
                // Handle other document types and redirects as needed
                // ...
            default:
                // Handle unsupported document types or show an error message
                $response = ["message" => "Unsupported document type"];
                header("Content-Type: application/json");
                echo json_encode($response);
                exit;
        }
    } else {
        // Handle the case when "documentType" is not set in the POST data
        $response = ["message" => "Please select a document type before submitting."];
        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    }
} else {
    // Handle other HTTP request methods (e.g., GET)
    $response = ["message" => "Invalid request method."];
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}
