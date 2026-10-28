<?php
// Conexión a base de datos
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

$whatsapp_numero = '584223770933';
$instagram_usuario = 'em.digital.be';

// Cargar demos desde BD de forma segura
$demosQuery = null;
if ($conn) {
    $demosQuery = $conn->query("SELECT * FROM demos ORDER BY creado_en DESC");
}
?>
<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMDIGITALVE | Desarrollo Web & Soluciones Digitales</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="border-b border-slate-800 bg-slate-900/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl font-bold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">EMDIGITALVE</span>
            </div>
            <nav class="hidden md:flex space-x-6 text-sm font-medium text-slate-300">
                <a href="#" class="hover:text-blue-400 transition">Inicio</a>
                <a href="#servicios" class="hover:text-blue-400 transition">Servicios</a>
                <a href="#demos" class="hover:text-blue-400 transition">Demos</a>
                <a href="#contacto" class="hover:text-blue-400 transition">Contacto</a>
            </nav>
            <div>
                <a href="login.php" class="text-xs bg-slate-800 hover:bg-slate-700 border border-slate-700 px-3 py-2 rounded-lg transition font-medium">Panel Admin</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-6">
                Soluciones Digitales y <span class="bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">Desarrollo Web</span>
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-slate-400 mb-8">
                Llevamos tu negocio al siguiente nivel con aplicaciones web modernas, rápidas y adaptadas a tus necesidades.
            </p>
            <div class="flex justify-center gap-4">
                <a href="https://wa.me/<?php echo $whatsapp_numero; ?>" target="_blank" class="bg-blue-600 hover:bg-blue-500 text-white font-medium px-6 py-3 rounded-xl transition shadow-lg shadow-blue-600/20">
                    Contáctanos por WhatsApp
                </a>
            </div>
        </section>

        <!-- Servicios Section -->
        <section id="servicios" class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-900">
            <h2 class="text-2xl font-bold mb-12 text-center">Nuestros Servicios</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 hover:border-slate-700 transition">
                    <div class="w-12 h-12 bg-blue-600/10 text-blue-400 rounded-xl flex items-center justify-center font-bold text-xl mb-4">💻</div>
                    <h3 class="text-lg font-semibold mb-2">Desarrollo Web a Medida</h3>
                    <p class="text-sm text-slate-400">Creamos páginas web y aplicaciones robustas, escalables y optimizadas para cualquier dispositivo.</p>
                </div>
                <div class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 hover:border-slate-700 transition">
                    <div class="w-12 h-12 bg-indigo-600/10 text-indigo-400 rounded-xl flex items-center justify-center font-bold text-xl mb-4">🚀</div>
                    <h3 class="text-lg font-semibold mb-2">Optimización y Rendimiento</h3>
                    <p class="text-sm text-slate-400">Mejoramos la velocidad de carga, la estructura y el posicionamiento de tus plataformas digitales.</p>
                </div>
                <div class="bg-slate-900/50 border border-slate-800/80 rounded-2xl p-6 hover:border-slate-700 transition">
                    <div class="w-12 h-12 bg-emerald-600/10 text-emerald-400 rounded-xl flex items-center justify-center font-bold text-xl mb-4">🛠️</div>
                    <h3 class="text-lg font-semibold mb-2">Soporte y Mantenimiento</h3>
                    <p class="text-sm text-slate-400">Asistencia técnica continua para garantizar que tus proyectos funcionen sin interrupciones.</p>
                </div>
            </div>
        </section>

        <!-- Demos Section -->
        <section id="demos" class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-900">
            <h2 class="text-2xl font-bold mb-8 text-center">Nuestros Trabajos y Demos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if ($demosQuery && $demosQuery->num_rows > 0): ?>
                    <?php while($demo = $demosQuery->fetch_assoc()): ?>
                        <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 flex flex-col justify-between">
                            <div>
                                <h3 class="font-semibold text-lg mb-2 text-slate-200"><?php echo htmlspecialchars($demo['titulo']); ?></h3>
                                <p class="text-sm text-slate-400 mb-4"><?php echo htmlspecialchars($demo['descripcion']); ?></p>
                            </div>
                            <?php if (!empty($demo['url'])): ?>
                                <a href="<?php echo htmlspecialchars($demo['url']); ?>" target="_blank" class="text-blue-400 hover:text-blue-300 text-sm font-medium inline-flex items-center gap-1">
                                    Ver proyecto &rarr;
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-span-full text-center text-slate-500 py-8">
                        <p>No hay demos disponibles en este momento o la base de datos se está configurando.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Contacto Section -->
        <section id="contacto" class="py-16 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto border-t border-slate-900 text-center">
            <h2 class="text-2xl font-bold mb-4">¿Listo para comenzar tu proyecto?</h2>
            <p class="text-slate-400 mb-8 text-sm">Contáctanos directamente y hablemos sobre cómo podemos ayudarte a destacar en internet.</p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <a href="https://wa.me/<?php echo $whatsapp_numero; ?>" target="_blank" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 text-white font-medium px-6 py-3 rounded-xl transition shadow-lg shadow-emerald-600/20 text-sm">
                    Escríbenos por WhatsApp
                </a>
                <a href="https://instagram.com/<?php echo $instagram_usuario; ?>" target="_blank" class="w-full sm:w-auto bg-slate-900 hover:bg-slate-800 border border-slate-800 text-slate-200 font-medium px-6 py-3 rounded-xl transition text-sm">
                    Instagram: @<?php echo $instagram_usuario; ?>
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 py-8 text-center text-xs text-slate-500">
        <p>&copy; <?php echo date('Y'); ?> EMDIGITALVE. Todos los derechos reservados.</p>
    </footer>

</body>
</html>