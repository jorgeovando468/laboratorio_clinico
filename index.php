<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Laboratorio Clinico</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="color-scheme" content="light dark" />
        <meta name="theme-color" content="#667eea" media="(prefers-color-scheme: light)" />
        <meta name="theme-color" content="#6a4190" media="(prefers-color-scheme: dark)" />

        <!-- Stylesheets -->
        <link rel="preload" href="./css/adminlte.css" as="style" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" media="print" onload="this.media='all'" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
        <link rel="stylesheet" href="css/adminlte.css" />
        <!-- CSS Custom para la Paleta de Colores (cargado después de AdminLTE para sobrescrituras) -->
        <link rel="stylesheet" href="css/custom-theme.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" />
    </head>
    <body class="layout-fixed sidebar-expand-lg sidebar-open bg-light">
        <div class="app-wrapper">
            <!-- Header -->
            <nav class="app-header navbar navbar-expand bg-body">
              <!-- Contenido del header -->
              <div class="container-fluid">
          <!--begin::Start Navbar Links-->
                    <ul class="navbar-nav">
                      <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                          <i class="bi bi-list"></i>
                        </a>
                      </li>
                      <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Inicio</a></li>
                      <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contacto</a></li>
                      <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Nosotros</a></li>
                    </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
                    <ul class="navbar-nav ms-auto">
                      <!--begin::Navbar Search-->
                      <li class="nav-item">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                          <i class="bi bi-search"></i>
                        </a>
                      </li>
                      <!--end::Navbar Search-->
                      <!--begin::Messages Dropdown Menu-->
                      <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                          <i class="bi bi-chat-text"></i>
                          <span class="navbar-badge badge text-bg-danger">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                          <a href="#" class="dropdown-item">
                            <!--begin::Message-->
                            <div class="d-flex">
                              <div class="flex-shrink-0">
                                <img src="./assets/img/user1-128x128.jpg" alt="Avatar de Diego Ovando" class="img-size-50 rounded-circle me-3"/>
                              </div>
                                
                              <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">Diego Ovando<span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span></h3>
                                <p class="fs-7">Llámame cuando puedas...</p>
                                <p class="fs-7 text-secondary"><i class="bi bi-clock-fill me-1"></i> 4 Hace horas</p>
                              </div>
                            </div>
                            <!--end::Message-->
                          </a>
                          <div class="dropdown-divider"></div>
                          <a href="#" class="dropdown-item">
                            <!--begin::Message-->
                            <div class="d-flex">
                              <div class="flex-shrink-0">
                                <img src="./assets/img/user8-128x128.jpg" alt="Avatar de Angel Herrera" class="img-size-50 rounded-circle me-3"/>
                              </div>
                              <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">Angel Herrera
                                  <span class="float-end fs-7 text-secondary"><i class="bi bi-star-fill"></i></span> </h3>
                                <p class="fs-7">Recibí tu mensaje hermano</p>
                                <p class="fs-7 text-secondary"><i class="bi bi-clock-fill me-1"></i> 4 Hace horas</p>
                              </div>
                            </div>
                            <!--end::Message-->
                          </a>
                          <div class="dropdown-divider"></div>
                          <a href="#" class="dropdown-item">
                            <!--begin::Message-->
                            <div class="d-flex">
                              <div class="flex-shrink-0">
                                <img src="./assets/img/user3-128x128.jpg" alt="Avatar de Nora Silvester" class="img-size-50 rounded-circle me-3"/>
                              </div>
                              <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">Nora Silvester<span class="float-end fs-7 text-warning"><i class="bi bi-star-fill"></i></span></h3>
                                <p class="fs-7">El tema va aquí</p>
                                <p class="fs-7 text-secondary"><i class="bi bi-clock-fill me-1"></i> 4 Hace horas</p>
                              </div>
                            </div>
                            <!--end::Message-->
                          </a>
                          <div class="dropdown-divider"></div>
                          <a href="#" class="dropdown-item dropdown-footer">Ver todos los mensajes</a>
                        </div>
                      </li>
                      <!--end::Messages Dropdown Menu-->
                      <!--begin::Notifications Dropdown Menu-->
                      <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-bell-fill"></i><span class="navbar-badge badge text-bg-warning">15</span>
                        </a><!--Final item menu link-->
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                          <span class="dropdown-item dropdown-header">15 Notificaciones</span>
                          <div class="dropdown-divider"></div>
                          <a href="#" class="dropdown-item"><i class="bi bi-envelope me-2"></i> 4 nuevos mensajes
                            <span class="float-end text-secondary fs-7">3 mins</span>
                          </a>
                          <div class="dropdown-divider"></div>
                          <a href="#" class="dropdown-item"><i class="bi bi-people-fill me-2"></i> 8 solicitudes de amistad
                            <span class="float-end text-secondary fs-7">12 horas</span>
                          </a>
                          <div class="dropdown-divider"></div>
                          <a href="#" class="dropdown-item"><i class="bi bi-file-earmark-fill me-2"></i> 3 nuevos informes
                            <span class="float-end text-secondary fs-7">2 dias</span>
                          </a>
                          <div class="dropdown-divider"></div>
                          <a href="#" class="dropdown-item dropdown-footer"> Ver todas las notificaciones </a>
                        </div>
                      </li>
                      <!--end::Notifications Dropdown Menu-->
                      <!--begin::Fullscreen Toggle-->
                      <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                      </li>
                      <!--end::Alternar pantalla completa-->
                      <!--begin::Menú desplegable del usuario-->
                      <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="./assets/img/avatar4.png" class="user-image rounded-circle shadow" alt="Imagen de Usuario"/>
                          <span class="d-none d-md-inline">Usuario</span></a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                          <!--begin::User Image-->
                          <li class="user-header text-bg-primary">
                              <img src="./assets/img/avatar4.png" class="rounded-circle shadow" alt="Imagen de Usuario"/>
                            <p>Usuario - Web Developer<small>Miembro desde Nov. 2023</small></p>
                          </li>
                          <!--end::User Image-->
                          <!--begin::Menu Body-->
                          <li class="user-body">
                            <!--begin::Row-->
                            <div class="row">
                              <div class="col-4 text-center"><a href="#">Seguidores</a></div>
                              <div class="col-4 text-center"><a href="#">Ventas</a></div>
                              <div class="col-4 text-center"><a href="#">Amigos</a></div>
                            </div>
                            <!--end::Row-->
                          </li>
                          <!--end::Menu Body-->
                          <!--begin::Menu Footer-->
                          <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Perfil</a>
                            <a href="controladores/cerrarSession.php" class="btn btn-default btn-flat float-end">Desconectar</a>
                          </li>
                          <!--end::Menu Footer-->
                        </ul>
                      </li>
                      <!--Final::Menú desplegable del usuario-->
                    </ul>
          <!--end::End Navbar Links-->
                </div>
        <!--end::Container-->
            </nav>

            <!-- Barra lateral -->
            <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
              <!-- Contenido de la Barra lateral  -->
              <div class="sidebar-brand"><!--begin::Brand Link-->
                  <a href="index.php" class="brand-link"><!--begin::Brand Image-->
                  <img src="./assets/img/AdminLTELogo.png" alt="Logo de AdminLTE" class="brand-image opacity-75 shadow"/><!--end::Brand Image-->
                 
                  <span class="brand-text fw-light">Jorge Ovando</span> <!--begin::Brand Text-->
                </a> <!--end::Brand Link-->
              </div>
              <div class="sidebar-wrapper">
                <nav class="mt-2">
                  <!--begin::Sidebar Menu-->
                  <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" 
                      role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
                    <li class="nav-item menu-open">
                      <a href="#" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p> REFERENCIALES<i class="nav-arrow bi bi-chevron-right"></i></p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarPaciente(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Paciente</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarExamen(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Examen</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarResultado(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Resultado</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarMedico(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Medico</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarCita(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Cita</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarFactura(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Factura</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarPago(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Pago</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarEmpleado(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Empleado</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarTipoExamen(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Tipo de Examen</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarMuestra(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Muestra</p>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="mostrarListarMejorador(); return false;" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Mejorador de Foto de Perfil</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  <!--end::Sidebar Menu-->
                </nav>
              </div>
            </aside>
            <!-- Main content -->
            <main class="app-main">
              <div class="app-content-header">
          <!--begin::Container-->
                <div class="container-fluid">
                  <!--begin::Row-->
                  <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Panel</h3></div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Panel</li>
                      </ol>
                    </div>
                  </div>
                  <!--end::Row-->
                </div>
                <!--end::Container-->
              </div><!--Final::Encabezado de contenido de la aplicación-->
        <!--begin::App Content-->
                <div class="app-content" id="contenido-principal">
                  <!--begin::Container-->
                  <!--end::Container-->
                </div>
            </main>
            <!-- Footer -->
            <footer class="app-footer">
              <!-- Contenido del footer -->
              <div class="float-end d-none d-sm-inline">Todo lo que quieras</div>
                <!--end::To the end-->
                <!--begin::Copyright-->
                <strong>
                  Copyright &copy; 2014-2025&nbsp;
                  <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
                </strong>
                 Todos los derechos Reservados.
                <!--end::Copyright-->
            </footer>
        </div> <!--end::App Wrapper-->
        <!--begin::Script-->
        <!--begin::Third Party Plugin(OverlayScrollbars)-->
         <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"></script>
        <script src="jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts propios -->
        <script src="util.js"></script>
        <script src="vistas/paciente.js"></script>
        <script src="vistas/pacientes.js"></script>
        <script src="vistas/cita.js"></script>
        <script src="vistas/empleado.js"></script>
        <script src="vistas/examen.js"></script>
        <script src="vistas/examenes.js"></script>
        <script src="vistas/factura.js"></script>
        <script src="vistas/medico.js"></script>
        <script src="vistas/medicos.js"></script>
        <script src="vistas/muestra.js"></script>
        <script src="vistas/pago.js"></script>
        <script src="vistas/facturas.js"></script>
        <script src="vistas/resultado.js"></script>
        <script src="vistas/tipo_examen.js"></script>
        <script src="vistas/tipo_examenes.js"></script>
        <script src="vistas/Mejorador.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Configuraciones y scripts inline mínimos -->
        <script src="./js/adminlte.js"></script>
        <script src="./js/custom-config.js"></script> <!-- Aquí puedes poner configuraciones JS -->
    </body>
</html>