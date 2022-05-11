<?=$header?>
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Remuneraciones /</span> Usuarios</h4>

              <!-- Bootstrap Table with Header - Dark -->
              <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">Usuarios Registrados
                  <button 
                    type="button" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addUser" 
                    class="btn btn-outline-dark my-2"
                    onclick="cleanForm()">
                    Agregar Usuario
                  </button>
                </h5>
                <div class="table-responsive-xl text-nowrap">
                  <table id="usersTable" class="table">
                    <thead class="table-dark">
                      <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Nombres y Apellidos</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Bootstrap Table with Header Dark -->
            </div>
            <input type="hidden" id="he">
            <!-- / Content -->
<?php require_once 'modals/addUser.php'; ?>
<?php require_once 'modals/editUser.php'; ?>
<?=$footer?>