<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas Médicas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preload" href="../../css/custom-theme-listar.css" as="style">
    <link rel="stylesheet" href="../../css/custom-theme-listar.css">
</head>
<body>
    <div class="container">
        <div class="main-container">
            <input type="text" id="id_cita" value="0" hidden>
            
            <!-- Header -->
            <div class="header-section">
                <h3>Gestión de Citas Médicas</h3>
            </div>

            <!-- Formulario -->
            <div class="form-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">📅 Fecha</label>
                        <input type="date" class="form-control" id="fecha">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">⏰ Hora</label>
                        <input type="time" class="form-control" id="hora">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">👤 Paciente</label>
                        <select id="paciente_lst" class="form-select">
                            <option disabled selected value="0">-- Seleccione un paciente --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">🩺 Médico</label>
                        <select id="medico_lst" class="form-select">
                            <option disabled selected value="0">-- Seleccione un médico --</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">📋 Estado</label>
                        <select id="estado_lst" class="form-select">
                            <option disabled selected value="0">-- Seleccione un estado --</option>
                            <option value="Atendida">Atendida</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-4">
                        <button class="btn btn-custom btn-save w-100" onclick="guardarCita();">
                            💾 Guardar Cita
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
                <label>Buscar Citas</label>
                <input type="text" id="b_cita" class="form-control" placeholder="Buscar por paciente, médico, fecha...">
            </div>

            <!-- Tabla -->
            <div class="table-section">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th style="text-align: center;">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="datos_tb">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>