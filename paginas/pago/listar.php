<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .main-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            margin-bottom: 30px;
        }

        .header-section h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-section h2::before {
            content: "💳";
            font-size: 32px;
        }

        .form-section {
            padding: 0 30px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control, .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .btn-custom {
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            color: white;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-cancel {
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
            color: white;
        }

        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
        }

        .search-section {
            background: #f9fafb;
            padding: 25px 30px;
            margin: 30px 0;
            border-radius: 15px;
            border: 2px dashed #e5e7eb;
        }

        .search-section label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-section label::before {
            content: "🔍";
            font-size: 20px;
        }

        #b_pago {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 15px 20px;
            font-size: 15px;
        }

        #b_pago:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .table-section {
            padding: 0 30px 30px 30px;
        }

        .table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table thead th {
            border: none;
            padding: 18px 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: #f9fafb;
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-color: #f3f4f6;
        }

        .btn-operation {
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 3px;
        }

        .btn-edit {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
        }

        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
            margin: 30px 0;
        }

        @media (max-width: 768px) {
            .main-container {
                border-radius: 0;
            }

            .header-section, .form-section, .table-section {
                padding: 20px 15px;
            }

            .btn-custom {
                padding: 10px 20px;
                font-size: 13px;
            }

            .table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-container">
            <input type="text" id="id_pago" value="0" hidden>

            <!-- Header -->
            <div class="header-section">
                <h2>Gestión de Pagos</h2>
            </div>

            <!-- Formulario -->
            <div class="form-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">📅 Fecha</label>
                        <input type="date" class="form-control" id="fecha">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">💵 Monto</label>
                        <input type="number" class="form-control" id="monto" placeholder="Ej: 150000">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🧾 Factura</label>
                        <select id="factura_lst" class="form-select">
                            <option disabled selected value="0">-- Seleccione una factura --</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">💰 Tipo de Pago</label>
                        <select id="tipo_pago" class="form-select">
                            <option disabled selected value="0">-- Seleccione un tipo de pago --</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-4">
                        <button class="btn btn-custom btn-save w-100" onclick="guardarPago();">
                            💾 Guardar Pago
                        </button>
                    </div>
                    <div class="col-md-6 mt-4">
                        <button class="btn btn-custom btn-cancel w-100">
                            ❌ Cancelar
                        </button>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Buscador -->
            <div class="search-section mx-4">
                <label>Buscar Pagos</label>
                <input type="text" id="b_pago" class="form-control" placeholder="Buscar por factura, monto, tipo...">
            </div>

            <!-- Tabla -->
            <div class="table-section">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Factura</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Tipo de Pago</th>
                                <th style="text-align: center;">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="datos_tb"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script></script>
</body>
</html>
