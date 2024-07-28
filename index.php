<?php 
include_once './database.php';
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <script>
        async function submitForm(event) {
            event.preventDefault();

            const formData = new FormData(document.querySelector('form'));
            const response = await fetch('/rakhi-website-php/api/contactApi.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            alert(result.status === 'success' ? 'Contact saved!' : 'Failed to save contact.');
        }
    </script>
</head>
<body>
    <h1>Contact Form</h1>
    <form onsubmit="submitForm(event)">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
