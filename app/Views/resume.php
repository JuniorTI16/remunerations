<?=$header?>
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Remuneraciones /</span> Resumen</h4>

              <!-- Bootstrap Table with Header - Dark -->
              <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">Generar Resumen
                  <button 
                    type="button" 
                    class="btn btn-outline-dark my-2"
                    onclick="cleanForm()">
                    Limpiar Formulario
                  </button>
                </h5>
                <div class="table-responsive-xl text-nowrap">
                    <form id="formPlh" class="p-4">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="year">Año</label>
                                    <input type="text" class="form-control" id="year" maxlength="4">
                                </div>
                                <div class="col">
                                    <label for="month">Mes</label>
                                    <select class="form-control" id="month">
                                        <option value="">Seleccione un mes</option>
                                        <option value="ENERO">Enero</option>
                                        <option value="FEBRERO">Febrero</option>
                                        <option value="MARZO">Marzo</option>
                                        <option value="ABRIL">Abril</option>
                                        <option value="MAYO">Mayo</option>
                                        <option value="JUNIO">Junio</option>
                                        <option value="JULIO">Julio</option>
                                        <option value="AGOSTO">Agosto</option>
                                        <option value="SEPTIEMBRE">Septiembre</option>
                                        <option value="OCTUBRE">Octubre</option>
                                        <option value="NOVIEMBRE">Noviembre</option>
                                        <option value="DICIEMBRE">Diciembre</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="fileplh">Archivo DatosPLH</label>
                                    <input type="file" class="form-control" id="fileplh">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-primary w-25" onclick="generateResume()">Generar</button>
                        </div>
                    </form>
                  </table>
                </div>
              </div>
              <!--/ Bootstrap Table with Header Dark -->
            </div>
            <!-- / Content -->
<?php require_once 'modals/addUser.php'; ?>
<?php require_once 'modals/editUser.php'; ?>
<?=$footer?>