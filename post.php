<?php
require('connect.php');

if (isset($_POST['phone']))
{
    $phone = $_POST['phone'];
    $stmt = $connection->prepare("SELECT * FROM phones WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $numberIsInDatabase = false;
    if ($stmt->fetch())
    {
        $numberIsInDatabase = true;
    }
    else 
    {
        $stmt->close();
        $stmt = $connection->prepare("INSERT INTO phones (phone) VALUES (?)");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
    }
    $stmt->close();

    $result = array(
        'numberIsInDatabase' => $numberIsInDatabase
    ); 
    echo json_encode($result); 
}
