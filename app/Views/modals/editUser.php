<!-- Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Editar Usuario</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="usernamee" class="form-label">Usuario</label>
                        <input
                            type="text"
                            id="usernamee"
                            class="form-control"
                            placeholder="JUPEDECRUZ15"
                            maxlength="60"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="namee" class="form-label">Nombres y Apellidos</label>
                        <input
                            type="text"
                            id="namee"
                            class="form-control"
                            placeholder="JUAN PEREZ DE LA CRUZ"
                            maxlength="100"
                        />
                    </div>
                </div>
                <div class="row">
                    <label for="passworde" class="form-label">Contraseña</label>
                    <div class="col-10 mb-3">
                        
                        <input
                            type="password"
                            id="passworde"
                            class="form-control"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password"
                            maxlength="60"
                        />
                    </div>
                    <div class="col-2">
                        <span class="input-group-text cursor-pointer" id="pe"><i class="bx bx-hide"></i></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="userPhotoe" class="form-label">Foto</label>
                        <input
                            type="file"
                            id="userPhotoe"
                            class="form-control"
                            accept="image/x-png,image/gif,image/jpeg"
                        />
                    </div>
                </div>
                <input type="hidden" id="idUs">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cerrar
            </button>
            <button type="button" class="btn btn-primary" onclick="editUser()">Editar</button>
            </div>
        </div>
        </div>
    </div>
<!-- Modal -->
