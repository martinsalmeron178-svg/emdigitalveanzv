<?php
session_start();
$host = "127.0.0.1";
$user = "root";
$password = "";
$dbname = "emdigitalveanz_db";

$conn = @new mysqli($host, $user, $password, $dbname);

if (mysqli_connect_errno()) {
    $conn = null; // Evita que explote la página si no hay base de datos
} else {
    $conn->set_charset("utf8mb4");
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['clave']);

    // Validacion directa o contra base de datos (segura ante fallos de conexion)
    $login_valido = false;

    if ($usuario === 'admin' && $clave === 'emdigitalve2026') {
        $login_valido = true;
    } elseif ($conn) {
        // Si hay conexion activa, podemos validar opcionalmente contra la BD
        $stmt = $conn->prepare("SELECT password FROM usuarios WHERE usuario = ?");
        if ($stmt) {
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($hashed_password);
                $stmt->fetch();
                if (password_verify($clave, $hashed_password)) {
                    $login_valido = true;
                }
            }
            $stmt->close();
        }
    }

    if ($login_valido) {
        $_SESSION['admin_logueado'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Acceso denegado: Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EMDIGITALVE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center px-4">

    <div class="max-w-md w-full bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-xl">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">Panel de Control</h1>
            <p class="text-sm text-slate-400 mt-2">Inicia sesión para administrar el sitio</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-950/50 border border-red-800 text-red-300 rounded-lg text-sm text-center">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Usuario</label>
                <input type="text" name="usuario" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-blue-500 transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Contraseña</label>
                <input type="password" name="clave" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:border-blue-500 transition text-sm">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-medium py-3 rounded-xl transition shadow-lg shadow-blue-600/20 text-sm">
                Entrar al Sistema
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="index.php" class="text-xs text-slate-500 hover:text-slate-400 transition">&larr; Volver al inicio</a>
        </div>
    </div>

</body>
</html>