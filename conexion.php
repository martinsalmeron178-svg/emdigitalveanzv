<?php
$host = "127.0.0.1";
$user = "root";       // Tu usuario de MySQL en XAMPP[cite: 14]
$password = "";       // Contraseña (por defecto en XAMPP)[cite: 14]
$dbname = "emdigitalveanz_db";

// Conexión protegida con arroba y validación segura por número de error
$conn = @new mysqli($host, $user, $password, $dbname);

if (mysqli_connect_errno()) {
    // Si falla la conexión en Render, anulamos la variable sin matar la página
    $conn = null; 
} else {
    $conn->set_charset("utf8mb4");
}
?>