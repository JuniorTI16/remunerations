<?=$header?>
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Remuneraciones /</span> Documentos</h4>

              <!-- Bootstrap Table with Header - Dark -->
              <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">Documentos Recibidos
                  <button 
                    type="button" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addDocument" 
                    class="btn btn-outline-dark my-2"
                    onclick="cleanForm()">
                    Agregar Documento
                  </button>
                </h5>
                <div class="table-responsive text-nowrap">
                  <table id="documentsTable" class="table">
                    <thead class="table-dark">
                      <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>N° Expediente</th>
                        <th>Asunto</th>
                        <th>Razón</th>
                        <th>Observación</th>
                        <th>Archivo</th>
                        <th>Usuario</th>
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
<?php require_once 'modals/addDocument.php'; ?>
<?php require_once 'modals/editDocument.php'; ?>
<?=$footer?>