<!-- Modal -->
    <div class="modal fade" id="editDocument" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Editar Documento</h5>
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
                        <label for="numberExpe" class="form-label">Nro. de Expediente</label>
                        <input
                            type="text"
                            id="numberExpe"
                            class="form-control"
                            placeholder="MEMO N°139-JDO"
                            maxlength="100"
                        />
                    </div>
                    <div class="col mb-0">
                        <label for="docReasone" class="form-label">Razón</label>
                        <input
                            type="text"
                            id="docReasone"
                            class="form-control"
                            placeholder="DSCTO. MES DE NOVIEMBRE"
                            maxlength="255"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="docSubjecte" class="form-label">Asunto</label>
                        <input
                            type="text"
                            id="docSubjecte"
                            class="form-control"
                            placeholder="CORTE ADMINISTRATIVO"
                            maxlength="255"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="docFilee" class="form-label">Archivo</label>
                        <input
                            type="file"
                            id="docFilee"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="docObservatione" class="form-label">Observación</label>
                        <input
                            type="text"
                            id="docObservatione"
                            class="form-control"
                            placeholder="CAS"
                            maxlength="150"
                        />
                    </div>
                </div>
                <input type="hidden" id="idDoce">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cerrar
            </button>
            <button type="button" class="btn btn-primary" onclick="editDocument()">Editar</button>
            </div>
        </div>
        </div>
    </div>
<!-- Modal -->
