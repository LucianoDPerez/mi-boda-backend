<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Invitados - Casamiento Mary & Lucho!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            color: #fd7e14; /* Naranja fuerte */
            font-size: 3em; /* Tamaño de fuente grande */
            font-weight: bold; /* Texto en negrita */
            background: linear-gradient(90deg, #ff9a8b, #ff6a88, #ff99ac); /* Gradiente de color */
            -webkit-background-clip: text; /* Para aplicar gradiente solo al texto */
            -webkit-text-fill-color: transparent; /* Texto transparente para mostrar gradiente */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Sombra de texto */
            padding-bottom: 20px; /* Separación interna en la parte inferior */
            border-bottom: 3px solid #fd7e14; /* Línea decorativa en la parte inferior */
            text-align: center;
        }
        h2 {
            color: #0056b3; /* Azul */
            border-bottom: 2px solid #0056b3; /* Línea decorativa */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .table {
            background-color: #fff;
            margin-top: 20px; /* Separación con el título */
        }
        .table th {
            background-color: #007bff; /* Azul claro */
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
        .bg-success {
            background-color: #28a745; /* Verde */
        }
        .bg-danger {
            background-color: #dc3545; /* Rojo */
        }
        .confirmation-icon {
            font-size: 1.2em; /* Tamaño del icono */
        }
        /* Estilos para la sección de gráficos */
        .chart-container {
            margin-top: 20px;
            text-align: center;
        }
        .chart-title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        /* Estilos para la barra de búsqueda */
        .search-bar {
            margin-bottom: 20px;
        }
        /* Estilos para el gráfico pequeño */
        #myChart {
            width: 300px; /* Ancho del gráfico */
            height: 200px; /* Alto del gráfico */
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Casamiento Mary & Lucho!</h1>

    <div class="row">
        <div class="col-12">
            <h2>Resumen</h2>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                    <strong>Total de Confirmaciones:</strong> {{ $totalConfirmations }}
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center bg-danger text-light">
                    <strong>Confirmaciones Pendientes:</strong> {{ $pendingConfirmations }}
                </li>
            </ul>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 search-bar">
            <!-- Barra de búsqueda para filtrar por nombre, apellido, teléfono o estado
            <input type="text" class="form-control" id="search-input" placeholder="Buscar por nombre, apellido, teléfono...">
            -->
        </div>
        <div class="col-12">
            <h2>Lista de Invitados</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Confirmación</th>
                    <th>Actualizado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($guests as $guest)
                    <tr>
                        <td>{{ $guest->name }}</td>
                        <td>{{ $guest->phone }}</td>
                        <td>
                                <span class="badge {{ $guest->confirmation ? 'bg-success' : 'bg-danger' }}">
                                    <i class="confirmation-icon {{ $guest->confirmation ? 'bi bi-check-circle-fill' : 'bi bi-x-circle-fill' }}"></i>
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
                        <td>
                            <button class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>
                            <button class="btn btn-sm btn-secondary">
                                <i class="bi bi-envelope"></i> Enviar Mensaje
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if($previousPage)
                        <li class="page-item">
                            <a class="page-link" href="?page={{ $previousPage }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @endif
                    @for($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor
                    @if($nextPage)
                        <li class="page-item">
                            <a class="page-link" href="?page={{ $nextPage }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

    <!-- Gráfico al final del listado -->
    <div class="row mt-4 chart-container">
        <h2 class="chart-title">Resumen de Confirmaciones</h2>
        <canvas id="myChart"></canvas>
    </div>

</div>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Confirmados', 'Pendientes'],
            datasets: [{
                label: 'Confirmaciones',
                data: [{{ $totalConfirmations }}, {{ $pendingConfirmations }}],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false // Oculta la leyenda del gráfico
                }
            },
            aspectRatio: 2.5 // Ajusta la proporción del gráfico (ancho/alto)
        }
    });
</script>
</body>
</html>
