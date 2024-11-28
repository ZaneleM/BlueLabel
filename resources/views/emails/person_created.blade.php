<!DOCTYPE html>
<html>
<head>
    <title>You have been added to the system</title>
</head>
<body>
    <p>Dear {{ $person->name }},</p>
    <p>You have been added to the system. Here are your details:</p>
    <ul>
        <li>Name: {{ $person->name }}</li>
        <li>Surname: {{ $person->surname }}</li>
        <li>Email: {{ $person->email }}</li>
        <li>Mobile Number: {{ $person->mobile_number }}</li>
        <li>Birth Date: {{ $person->birth_date }}</li>
        <li>Language: {{ $person->language->name }}</li>
    </ul>
    <p>Thank you!</p>
</body>
</html>
