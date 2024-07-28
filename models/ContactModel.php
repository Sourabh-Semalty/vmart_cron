<?php

class ContactModel
{
    private $pdo;

    // Constructor to accept PDO instance
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Method to insert a contact
    public function insertContact($firstName, $lastName, $phone)
    {
        $sql = 'INSERT INTO contacts (first_name, last_name, phone) VALUES (:first_name, :last_name, :phone)';
        $stmt = $this->pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':phone', $phone);

        // Execute and return the result
        if ($stmt->execute()) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error'];
        }
    }

    // Method to get all contacts
    public function getAllContacts()
    {
        $sql = 'SELECT * FROM contacts';
        $stmt = $this->pdo->query($sql);

        // Fetch all contacts
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $contacts;
    }

    public function getAllNotSentContacts()
    {
        $sql = "SELECT * FROM contacts where message_status = 'NotProcessedByUs'";
        $stmt = $this->pdo->query($sql);
        // Fetch all contacts
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $contacts;
    }

    public function getContactByPhone($phone)
    {
        $sql = 'SELECT * FROM contacts WHERE phone = :phone';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch a single contact
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);

        return $contact;
    }
}
