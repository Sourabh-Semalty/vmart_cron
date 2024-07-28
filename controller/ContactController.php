<?php

class ContactController
{
    private $contactModel;

    // Constructor to accept a ContactModel instance
    public function __construct($contactModel)
    {
        $this->contactModel = $contactModel;
    }

    // Method to handle POST requests for inserting contacts
    public function createContact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Get form data
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $phone = $_POST['phone'];

                $result = $this->contactModel->getContactByPhone($phone);
                if (sizeof($result) > 0) throw new Exception("contact already added");

                // Insert the contact using the model
                $result = $this->contactModel->insertContact($first_name, $last_name, $phone);

                // Output the result as JSON
                echo json_encode($result);
            } catch (\Throwable $th) {
                echo json_encode(['status' => 'error', 'messag' => $th->getMessage()]);
            }
        } else {
            // Method not allowed
            http_response_code(405); // Method Not Allowed
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }

    // Method to handle GET requests for retrieving contacts
    public function getContacts()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];  // Sanitize input
                // Fetch contact by ID
                $contact = $this->contactModel->getContactById($id);

                // Output the contact as JSON
                echo json_encode($contact);
            } else {
                // Fetch all contacts
                $contacts = $this->contactModel->getAllContacts();

                // Output the contacts as JSON
                echo json_encode($contacts);
            }
        } else {
            // Method not allowed
            http_response_code(405); // Method Not Allowed
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }
}
