<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pagos1";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Variables para almacenar criterios de búsqueda
$numero_obra = isset($_GET['numero_obra']) ? $_GET['numero_obra'] : '';
$localidad = isset($_GET['localidad']) ? $_GET['localidad'] : '';

// Construir consulta SQL con criterios de búsqueda
$sql = "SELECT * FROM obras WHERE 1=1";
if ($numero_obra != '') {
    $sql .= " AND numero_obra LIKE '%" . $conn->real_escape_string($numero_obra) . "%'";
}
if ($localidad != '') {
    $sql .= " AND localidad LIKE '%" . $conn->real_escape_string($localidad) . "%'";
}

$result = $conn->query($sql);

// Verificar si la consulta se ejecutó correctamente
if (!$result) {
    die("Error al ejecutar la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Obras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <script>
        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta obra?")) {
                window.location.href = "eliminarObra.php?id=" + id;
            }
        }
    </script>
</head>
<body>
    <h1>Datos de Obras Guardadas</h1>
    <center><h4>Buscar Obra</h4>
    <form method="get" action="">
        <label for="numero_obra">Número de Obra:</label>
        <input type="text" id="numero_obra" name="numero_obra" value="<?php echo htmlspecialchars($numero_obra); ?>">
        <label for="localidad">Localidad:</label>
        <input type="text" id="localidad" name="localidad" value="<?php echo htmlspecialchars($localidad); ?>">
        <button type="submit">Buscar</button>
    </form>
    <table>
        <tr>
            <th>Número de Oficio</th>
            <th>Fecha de Autorización</th>
            <th>Número de Obra</th>
            <th>Obra</th>
            <th>Localidad</th>
            <th>Modalidad</th>
            <th>Monto Autorizado</th>
            <th>Monto Contratado</th>
            <th>Número de Contrato</th>
            <th>Contratista</th>
            <th>Supervisor Empresa</th>
            <th>Supervisor Obras</th>
            <th>Capacitación Comité</th>
            <th>Fecha de Contrato</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Término</th>
            <th>Observaciones</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['numero_oficio']}</td>
                        <td>{$row['fecha_autorizacion']}</td>
                        <td>{$row['numero_obra']}</td>
                        <td>{$row['obra']}</td>
                        <td>{$row['localidad']}</td>
                        <td>{$row['modalidad']}</td>
                        <td>$" . number_format($row['monto_autorizado'], 2) . "</td>
                        <td>$" . number_format($row['monto_contratado'], 2) . "</td>
                        <td>{$row['numero_contrato']}</td>
                        <td>{$row['contratista']}</td>
                        <td>{$row['supervisor_empresa']}</td>
                        <td>{$row['supervisor_obras']}</td>
                        <td>{$row['capacitacion_comite']}</td>
                        <td>{$row['fecha_contrato']}</td>
                        <td>{$row['fecha_inicio']}</td>
                        <td>{$row['fecha_termino']}</td>
                        <td>{$row['observaciones']}</td>
                        <td>
                            <a href='editarObra.php?id={$row['id']}'>Editar</a> |
                            <a href='#' onclick='confirmarEliminacion({$row['id']})'>Eliminar</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='18'>No hay datos disponibles</td></tr>";
        }
        ?>
    </table>
    <div class="footer">
        <a href="Obras.php">Volver al formulario</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
