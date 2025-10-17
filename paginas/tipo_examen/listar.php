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
      padding: 0;
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
      content: "🧪";
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

    .form-control, .form-select, textarea {
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      padding: 12px 15px;
      transition: all 0.3s ease;
      font-size: 14px;
    }

    .form-control:focus, .form-select:focus, textarea:focus {
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

    #b_resultado {
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      padding: 15px 20px;
      font-size: 15px;
    }

    #b_resultado:focus {
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
      text-align: center;
    }

    .table tbody tr {
      transition: all 0.3s ease;
      text-align: center;
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
<div class="container">
    <div class="main-container">
        <input type="text" id="id_tipo_examen" value="0" hidden>
            <div class="header-section">
                <h2>Registro de Tipo de Exámenes</h2>
            </div>
        <!-- Formulario -->
<div class="form-section">
  <div class="row g-3">
    <div class="col-md-6 mb-3">
      <label class="form-label">Nombre del examen</label>
      <input type="text" class="form-control" id="nombre" placeholder="Ej: Hemograma completo">
    </div>

    <!-- Estado -->
    <div class="col-md-6 mb-3">
      <label class="form-label">Estado</label>
      <select id="estado" class="form-select">
        <option disabled selected value="0">-- Seleccione un estado --</option>
        <option value="Activo">Activo</option>
        <option value="Inactivo">Inactivo</option>
      </select>
    </div>

    <!-- Botones -->
    <div class="col-md-6 mt-3">
      <button class="btn btn-success w-100" onclick="guardarTipoExamen();">
        💾 Guardar
      </button>
    </div>
    <div class="col-md-6 mt-3">
      <button class="btn btn-danger w-100" onclick="cancelarFormulario();">
        ❌ Cancelar
      </button>
    </div>

    <!-- Separador -->
    <div class="col-12 my-4">
      <hr>
    </div>

    <!-- Buscador -->
    <div class="col-12 mb-3">
      <label class="form-label fw-bold">🔍 Buscador</label>
      <input type="text" id="b_tipo_examen" class="form-control" placeholder="Buscar por nombre o estado...">
    </div>

    <!-- Tabla -->
    <div class="col-12">
      <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-primary text-center">
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Operaciones</th>
          </tr>
        </thead>
        <tbody id="tipo_examen_tb" class="text-center"></tbody>
      </table>
        </div>
      </div>
    </div>
  </div>
</div>
