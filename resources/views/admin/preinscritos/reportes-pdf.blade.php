<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Preinscritos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            color: #666;
        }
        
        .estadisticas {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .estadistica {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #ddd;
        }
        
        .estadistica-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .estadistica-valor {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead {
            background-color: #2c3e50;
            color: white;
        }
        
        th {
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
        }
        
        td {
            padding: 6px 5px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tbody tr:hover {
            background-color: #e9ecef;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            color: white;
        }
        
        .badge-success {
            background-color: #28a745;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #333;
        }
        
        .badge-danger {
            background-color: #dc3545;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 8px;
            color: #666;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Preinscritos</h1>
        <p>Generado el: {{ $fecha }}</p>
    </div>
    
    <div class="estadisticas">
        <div class="estadistica">
            <div class="estadistica-label">Total</div>
            <div class="estadistica-valor">{{ $estadisticas['total'] }}</div>
        </div>
        <div class="estadistica">
            <div class="estadistica-label">Inscritos</div>
            <div class="estadistica-valor">{{ $estadisticas['inscrito'] }}</div>
        </div>
        <div class="estadistica">
            <div class="estadistica-label">Por Inscribir</div>
            <div class="estadistica-valor">{{ $estadisticas['por_inscribir'] }}</div>
        </div>
        <div class="estadistica">
            <div class="estadistica-label">Con Novedad</div>
            <div class="estadistica-valor">{{ $estadisticas['con_novedad'] }}</div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Nombre Completo</th>
                <th style="width: 12%;">Documento</th>
                <th style="width: 10%;">Celular</th>
                <th style="width: 18%;">Correo</th>
                <th style="width: 20%;">Programa</th>
                <th style="width: 8%;">Ficha</th>
                <th style="width: 12%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preinscritos as $preinscrito)
                <tr>
                    <td>{{ $preinscrito->nombre_completo }}</td>
                    <td>{{ strtoupper($preinscrito->tipo_documento) }}-{{ $preinscrito->numero_documento }}</td>
                    <td>{{ $preinscrito->celular_principal }}</td>
                    <td>{{ $preinscrito->correo_principal }}</td>
                    <td>{{ $preinscrito->programa->nombre ?? 'Sin asignar' }}</td>
                    <td>{{ $preinscrito->programa->numero_ficha ?? 'N/A' }}</td>
                    <td>
                        <span class="badge badge-{{ $preinscrito->estado === 'inscrito' ? 'success' : ($preinscrito->estado === 'por_inscribir' ? 'warning' : 'danger') }}">
                            {{ $preinscrito->etiqueta_estado }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>SENA - Sistema de Gestión de Preinscritos</p>
        <p>Documento generado automáticamente | Total de registros: {{ $preinscritos->count() }}</p>
    </div>
</body>
</html>
