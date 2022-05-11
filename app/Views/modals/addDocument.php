<!-- Modal -->
    <div class="modal fade" id="addDocument" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Agregar Documento</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col mb-0">
                        <label for="numberExp" class="form-label">Nro. de Expediente</label>
                        <input
                            type="text"
                            id="numberExp"
                            class="form-control"
                            placeholder="MEMO N°139-JDO"
                            maxlength="100"
                        />
                    </div>
                    <div class="col mb-0">
                        <label for="docReason" class="form-label">Razón</label>
                        <input
                            type="text"
                            id="docReason"
                            class="form-control"
                            placeholder="DSCTO. MES DE NOVIEMBRE"
                            maxlength="255"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="docSubject" class="form-label">Asunto</label>
                        <input
                            type="text"
                            id="docSubject"
                            class="form-control"
                            placeholder="CORTE ADMINISTRATIVO"
                            maxlength="255"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="docFile" class="form-label">Archivo</label>
                        <input
                            type="file"
                            id="docFile"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="docObservation" class="form-label">Observación</label>
                        <input
                            type="text"
                            id="docObservation"
                            class="form-control"
                            placeholder="CAS"
                            maxlength="150"
                        />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cerrar
            </button>
            <button type="button" class="btn btn-primary" onclick="sendDocument()">Guardar</button>
            </div>
        </div>
        </div>
    </div>
<!-- Modal -->
