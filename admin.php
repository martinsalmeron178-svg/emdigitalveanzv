<?php
session_start();
if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<?php
include('conexion.php');

// Procesar actualización de configuración (WhatsApp, Instagram, Email)
if (isset($_POST['update_config'])) {
    $whatsapp = $_POST['whatsapp'];
    $instagram = $_POST['instagram'];
    $email = $_POST['email_contacto'];

    $stmt = $conn->prepare("UPDATE configuracion SET whatsapp=?, instagram=?, email_contacto=? WHERE id=1");
    $stmt->bind_param("sss", $whatsapp, $instagram, $email);
    $stmt->execute();
    header("Location: admin.php?success=1");
    exit();
}

// Procesar nuevo demo
if (isset($_POST['add_demo'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $imagen_url = $_POST['imagen_url'];
    $demo_url = $_POST['demo_url'];

    $stmt = $conn->prepare("INSERT INTO demos (titulo, descripcion, imagen_url, demo_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $descripcion, $imagen_url, $demo_url);
    $stmt->execute();
    header("Location: admin.php?success=2");
    exit();
}

// Procesar eliminación de demo
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM demos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php?success=3");
    exit();
}

// Cargar datos actuales
$config = $conn->query("SELECT * FROM configuracion LIMIT 1")->fetch_assoc();
$demos = $conn->query("SELECT * FROM demos ORDER BY creado_el DESC");
?>
<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | EMDIGITALVE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        obsidian: '#0B0C10',
                        neonOrange: '#FF5722',
                        silverTech: '#C0C0C0',
                        darkCard: '#1F2833'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-obsidian text-white font-sans min-h-screen p-6">

    <div class="max-w-4xl mx-auto">
        <!-- Header del Panel -->
        <div class="flex justify-between items-center mb-8 border-b border-gray-800 pb-4">
            <div class="flex items-center gap-2">
                <span class="text-neonOrange text-2xl font-black">{EM}</span>
                <h1 class="text-xl font-bold text-white">Panel de Control</h1>
            </div>
            <a href="index.php" target="_blank" class="bg-gray-800 hover:bg-gray-700 text-silverTech text-xs px-4 py-2 rounded transition border border-gray-700">
                Ver Web Principal &rarr;
            </a>
        </div>

        <?php if(isset($_GET['success'])): ?>
            <div class="bg-green-900 border border-green-700 text-green-200 px-4 py-3 rounded mb-6 text-sm">
                ¡Operación realizada con éxito, mano! Cambios guardados correctamente.
            </div>
        <?php endif; ?>

        <!-- Sección 1: Datos de Contacto y Redes -->
        <div class="bg-darkCard border border-gray-800 p-6 rounded-lg mb-8 shadow-lg">
            <h2 class="text-lg font-bold mb-4 text-neonOrange">1. Configuración de Contacto (WhatsApp & Instagram)</h2>
            <form action="admin.php" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs text-silverTech mb-1">WhatsApp (con código de país)</label>
                    <input type="text" name="whatsapp" value="<?php echo $config['whatsapp']; ?>" class="w-full bg-obsidian border border-gray-700 p-2 rounded text-white text-sm" required>
                </div>
                <div>
                    <label class="block text-xs text-silverTech mb-1">Instagram (@usuario)</label>
                    <input type="text" name="instagram" value="<?php echo $config['instagram']; ?>" class="w-full bg-obsidian border border-gray-700 p-2 rounded text-white text-sm" required>
                </div>
                <div>
                    <label class="block text-xs text-silverTech mb-1">Correo de Contacto</label>
                    <input type="email" name="email_contacto" value="<?php echo $config['email_contacto']; ?>" class="w-full bg-obsidian border border-gray-700 p-2 rounded text-white text-sm" required>
                </div>
                <div class="md:col-span-3 pt-2">
                    <button type="submit" name="update_config" class="bg-neonOrange hover:bg-orange-600 text-white font-bold text-sm py-2 px-6 rounded transition shadow-[0_0_10px_rgba(255,87,34,0.3)]">
                        Guardar Cambios de Contacto
                    </button>
                </div>
            </form>
        </div>

        <!-- Sección 2: Agregar Nuevo Demo -->
        <div class="bg-darkCard border border-gray-800 p-6 rounded-lg mb-8 shadow-lg">
            <h2 class="text-lg font-bold mb-4 text-neonOrange">2. Subir Nuevo Demo al Portafolio</h2>
            <form action="admin.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs text-silverTech mb-1">Título del Proyecto</label>
                    <input type="text" name="titulo" placeholder="Ej: Landing Page Restaurante PLC" class="w-full bg-obsidian border border-gray-700 p-2 rounded text-white text-sm" required>
                </div>
                <div>
                    <label class="block text-xs text-silverTech mb-1">Descripción Corta</label>
                    <textarea name="descripcion" placeholder="Breve detalle de lo que se desarrolló..." class="w-full bg-obsidian border border-gray-700 p-2 rounded text-white text-sm" rows="2"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-silverTech mb-1">URL de la Imagen (Captura)</label>
                        <input type="text" name="imagen_url" placeholder="https://ejemplo.com/imagen.jpg" class="w-full bg-obsidian border border-gray-700 p-2 rounded text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-silverTech mb-1">URL del Demo en Vivo</label>
                        <input type="text" name="demo_url" placeholder="https://ejemplo.com/demo" class="w-full bg-obsidian border border-gray-700 p-2 rounded text-white text-sm">
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" name="add_demo" class="bg-green-600 hover:bg-green-700 text-white font-bold text-sm py-2 px-6 rounded transition">
                        + Publicar Demo en la Web
                    </button>
                </div>
            </form>
        </div>

        <!-- Sección 3: Lista de Demos Existentes (Con opción de Borrar) -->
        <div class="bg-darkCard border border-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold mb-4 text-neonOrange">3. Gestionar Demos Publicados</h2>
            <div class="space-y-3">
                <?php if ($demos->num_rows > 0): ?>
                    <?php while($d = $demos->fetch_assoc()): ?>
                        <div class="flex justify-between items-center bg-obsidian p-4 rounded border border-gray-800">
                            <div>
                                <p class="font-bold text-white text-sm"><?php echo $d['titulo']; ?></p>
                                <p class="text-xs text-gray-400"><?php echo !empty($d['demo_url']) ? $d['demo_url'] : 'Sin enlace web'; ?></p>
                            </div>
                            <a href="admin.php?delete=<?php echo $d['id']; ?>" onclick="return confirm('¿Seguro que quieres borrar este demo, mano?');" class="bg-red-600 hover:bg-red-700 text-white text-xs py-1.5 px-3 rounded transition">
                                Borrar Demo
                            </a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-sm text-center py-6">No hay demos registrados todavía.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>