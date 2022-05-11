<!-- Modal -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Agregar Usuario</h5>
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
                        <label for="username" class="form-label">Usuario</label>
                        <input
                            type="text"
                            id="username"
                            class="form-control"
                            placeholder="JUPEDECRUZ15"
                            maxlength="255"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="name" class="form-label">Nombres y Apellidos</label>
                        <input
                            type="text"
                            id="name"
                            class="form-control"
                            placeholder="JUAN PEREZ DE LA CRUZ"
                            maxlength="255"
                        />
                    </div>
                </div>
                <div class="row">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="col-10 mb-3">
                        
                        <input
                            type="password"
                            id="password"
                            class="form-control"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password"
                            maxlength="60"
                        />
                    </div>
                    <div class="col-2">
                        <span class="input-group-text cursor-pointer" id="p"><i class="bx bx-hide"></i></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="userPhoto" class="form-label">Foto</label>
                        <input
                            type="file"
                            id="userPhoto"
                            class="form-control"
                            accept="image/x-png,image/gif,image/jpeg"
                        />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cerrar
            </button>
            <button type="button" class="btn btn-primary" onclick="sendUser()">Guardar</button>
            </div>
        </div>
        </div>
    </div>
<!-- Modal -->
