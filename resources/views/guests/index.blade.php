<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Invitados</title>
    <!-- Incluimos el CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9; /* Color de fondo suave */
        }
        .container {
            padding: 20px;
            background-color: #fff; /* Color de fondo para el contenido */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); /* Sombra suave */
            border-radius: 8px; /* Bordes redondeados */
            margin-top: 50px; /* Separación con la parte superior */
            transition: all 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px); /* Efecto de levitación */
        }
        h1 {
            color: #343a40;
            margin-bottom: 30px; /* Separación con la siguiente sección */
        }
        h2 {
            color: #0056b3;
            border-bottom: 2px solid #0056b3; /* Línea decorativa */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .table {
            background-color: #fff;
            margin-top: 20px; /* Separación con el título */
        }
        .table th {
            background-color: #007bff;
            color: #fff;
            border-top: none;
            padding: 10px 15px; /* Espaciado interno */
        }
        .table td {
            border-top: none;
            padding: 10px 15px; /* Espaciado interno */
        }
        .list-group-item {
            border: none; /* Sin bordes para un look más limpio */
            padding: 10px 15px; /* Espaciado interno */
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center" style="
    color: #fd7e14; /* Naranja fuerte */
    font-size: 3em; /* Tamaño de fuente grande */
    font-weight: bold; /* Texto en negrita */
    background: linear-gradient(90deg, #ff9a8b, #ff6a88, #ff99ac); /* Gradiente de color */
    -webkit-background-clip: text; /* Para aplicar gradiente solo al texto */
    -webkit-text-fill-color: transparent; /* Texto transparente para mostrar gradiente */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Sombra de texto */
    padding-bottom: 20px; /* Separación interna en la parte inferior */
    border-bottom: 3px solid #fd7e14; /* Línea decorativa en la parte inferior */
">
        Casamiento Mary & Lucho!
    </h1>

    <div class="row">
        <div class="col-12">
            <h2>Resumen</h2>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Total de Confirmaciones:</strong> {{ $totalConfirmations }}
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Confirmaciones Pendientes:</strong> {{ $pendingConfirmations }}
                </li>
            </ul>
        </div>

        <div class="col-12 mt-4">
            <h2>Lista de Invitados</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Confirmación</th>
                    <th>Actualizado</th>
                </tr>
                </thead>
                <tbody>
                @foreach($guests as $guest)
                    <tr>
                        <td>{{ $guest->name }}</td>
                        <td>{{ $guest->phone }}</td>
                        <td>
                            <span class="badge {{ $guest->confirmation ? 'bg-success' : 'bg-danger' }}">
                                {{ $guest->confirmation ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td>
                            @if($guest->updated_at)
                                {{ $guest->updated_at->diffForHumans() }}
                            @else
                                No disponible
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Incluimos el JavaScript de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>
