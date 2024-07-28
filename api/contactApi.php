<?php

// Include necessary files
require '../database.php';       // Database configuration
require '../models/ContactModel.php';    // Model class
require '../controller/ContactController.php'; // Controller class

// Instantiate the model and controller
$contactModel = new ContactModel($pdo);
$contactController = new ContactController($contactModel);

// Route requests to the appropriate controller methods
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactController->createContact();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $contactController->getContacts();
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
