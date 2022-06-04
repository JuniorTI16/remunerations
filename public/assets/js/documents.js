var documentsTable;

// const urlApp = 'http://localhost/remunerations/';
const urlApp = 'https://remunerationsapp.herokuapp.com/';
$(document).ready(function () {
  listarDocumentos();
});

function listarDocumentos() {
  documentsTable = $("#documentsTable").DataTable({
    ordering: true,
    bLengthChange: true,
    searching: { regex: false },
    lengthMenu: [
      [5, 10, 25, 50, 100, -1],
      [5, 10, 25, 50, 100, "All"],
    ],
    pageLength: 10,
    destroy: true,
    async: false,
    processing: true,
    ajax: {
      url: urlApp + "documents/listDoc",
      type: "POST",
    },
    order: [[1, "asc"]],
    columns: [
      { defaultContent: "", className: "text-center" },
      {
        data: "docDate",
        render: function (data, type, row) {
          return (
            '<span class="badge bg-label-customize me-1">' + data + "</span>"
          );
        },
        className: "text-center",
      },
      {
        data: "nExp",
        render: function (data, type, row) {
          if (data.length > 12) {
            return (
              '<span class="badge bg-label-customize me-1">' +
              data.substring(0, 12) +
              "...</span>"
            );
          }
          return (
            '<span class="badge bg-label-customize me-1">' + data + "</span>"
          );
        },
        className: "text-center",
      },
      {
        data: "subject",
        render: function (data, type, row) {
          if (data.length > 20) {
            return (
              '<span class="badge bg-label-customize me-1">' +
              data.substring(0, 12) +
              "...</span>"
            );
          }
          return (
            '<span class="badge bg-label-customize me-1">' + data + "</span>"
          );
        },
        className: "text-center",
      },
      {
        data: "reason",
        render: function (data, type, row) {
          if (data.length > 15) {
            return (
              '<span class="badge bg-label-customize me-1">' +
              data.substring(0, 12) +
              "...</span>"
            );
          }
          return (
            '<span class="badge bg-label-customize me-1">' + data + "</span>"
          );
        },
        className: "text-center",
      },
      {
        data: "observation",
        render: function (data, type, row) {
          if (data == "") {
            return '<span class="badge bg-label-primary me-1">Sin observación</span>';
          }
          if (data.length > 15) {
            return (
              '<span class="badge bg-label-customize me-1">' +
              data.substring(0, 12) +
              "...</span>"
            );
          }
          return (
            '<span class="badge bg-label-customize me-1">' + data + "</span>"
          );
        },
        className: "text-center",
      },
      {
        data: "file",
        render: function (data, type, row) {
          if (data == "") {
            return '<span class="badge bg-label-primary me-1">Sin archivo</span>';
          } else {
            return `<a href="${urlApp}public/uploads/${data}" download>
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cloud-download" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fd0061" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"/> <path d="M19 18a3.5 3.5 0 0 0 0 -7h-1a5 4.5 0 0 0 -11 -2a4.6 4.4 0 0 0 -2.1 8.4" /> <line x1="12" y1="13" x2="12" y2="22" /> <polyline points="9 19 12 22 15 19" /></svg>
            </a>`;
          }
        },
        className: "text-center",
      },
      {
        data: "user",
        render: function (data, type, row) {
          // console.log(data)
          let datas = data.split("-"); 
          // console.log(datas)
          return (
            `<p data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="d-flex justify-content-center avatar avatar-xs pull-up" title="${datas[1]}"> <img src="${urlApp}/public/photos/${datas[0]}" alt="Avatar" class="rounded-circle" /></p>`
          );
        },
      },
      {
        defaultContent: `<div class="dropdown bg-label-customize">
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item editDoc" href="javascript:void(0);">
              <i class="bx bx-edit-alt me-1"></i> Edit
            </a>
          </div>
        </div>`,
        className: "text-center",
      },
    ],
    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 to 0 of 0 registros",
      infoFiltered: "(Filtrado de _MAX_ registros)",
      infoPostFix: "",
      thousands: ",",
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        first: "Primero",
        last: "Ultimo",
        next: "Siguiente",
        previous: "Anterior",
      },
    },
    select: true,
  });

  documentsTable.on("draw.dt", function () {
    let PageInfo = $("#documentsTable").DataTable().page.info();
    documentsTable
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        const val = i + 1 + PageInfo.start;
        cell.innerHTML = '<span class="badge bg-label-customize me-1">' + val + '</span>';
      });
  });
}

function cleanForm(){
  $('#numberExp').val('');
  $('#docSubject').val('');
  $('#docReason').val('');
  $('#docObservation').val('');
  $('#docFile').val('');
}

$('#documentsTable').on('click', '.editDoc', function () {
  // Extrae la información de la fila seleccionada
  let dataRow = documentsTable.row($(this).parents('tr')).data(); 
  // El modal no se cierra al dar click a los costados
  $("#editDocument").modal({ backdrop: "static", keyboard: false });
  $('#editDocument').modal('show');
  $("#numberExpe").val(decode(dataRow.nExp));
  $("#docReasone").val(decode(dataRow.reason));
  $("#docSubjecte").val(decode(dataRow.subject));
  $("#docFilee").val('');
  $("#docObservatione").val(decode(dataRow.observation));
  $("#idDoce").val(decode(dataRow.id));
});

function decode(value) {
  let he = $("#he");
  return he.html(value).text();
}

function sendDocument() {
  let nExp = $('#numberExp').val();
  let docSubject = $('#docSubject').val();
  let docReason = $('#docReason').val();
  let docObservation = $('#docObservation').val();
  let docFile = $('#docFile')[0].files[0];
  let formData = new FormData();

  formData.append('nExp', nExp);
  formData.append('docSubject', docSubject);
  formData.append('docReason', docReason);
  formData.append('docObservation', docObservation);
  formData.append('docFile', docFile);

  if (nExp.length < 3 || docSubject.length < 3 || docReason.length < 3) {
    return Swal.fire({
      icon: 'error',
      title: 'Error...',
      text: 'El número de expediente, el asunto y la razón son campos obligatorios y deben tener 3 caracteres o más!',
      timer: 2700,
    });
  }

  if (nExp.length > 100 || docSubject.length > 255 || docReason.length > 255 || docObservation.length > 150) {
    return Swal.fire({
      icon: 'error',
      title: 'Error...',
      text: 'El número de expediente, el asunto, la razón y la observación no deben exceder de 100, 255, 255 y 150 caracteres respectivamente!',
      timer: 2700,
    });
  }

  $.ajax({
    url: urlApp + 'documents/addDoc',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    error: function () {
        Swal.fire({
        icon: 'error',
        title: 'Error...',
        text: 'Ocurrió un error en el servidor.',
        timer: 2700,
      });
    },
  }).done((response) => {
    const resp = JSON.parse(response);
    if (resp === 1) {
      cleanForm();
      Swal.fire({
        icon: 'success',
        title: 'Registrado!',
        text: 'El documento fue registrado correctamente!',
        timer: 2700,
      });
      listarDocumentos();
      $('#addDocument').modal('hide');
    } else {
      Swal.fire({
        icon: "error",
        title: "Error...",
        text: "Ocurrió un error en el servidor.",
        timer: 2700,
      });
    }
  });
} 

function editDocument() {
  let id = $("#idDoce").val();
  let nExp = $("#numberExpe").val();
  let docSubject = $("#docSubjecte").val();
  let docReason = $("#docReasone").val();
  let docObservation = $("#docObservatione").val();
  let docFile = $("#docFilee")[0].files[0];
  let formData = new FormData();

  formData.append("id", id);
  formData.append("nExp", nExp);
  formData.append("docSubject", docSubject);
  formData.append("docReason", docReason);
  formData.append("docObservation", docObservation);
  formData.append("docFile", docFile);

  if (nExp.length < 3 || docSubject.length < 3 || docReason.length < 3) {
    return Swal.fire({
      icon: "error",
      title: "Error...",
      text: "El número de expediente, el asunto y la razón son campos obligatorios y deben tener 3 caracteres o más!",
      timer: 2700,
    });
  }

  if (
    nExp.length > 100 ||
    docSubject.length > 255 ||
    docReason.length > 255 ||
    docObservation.length > 150
  ) {
    return Swal.fire({
      icon: "error",
      title: "Error...",
      text: "El número de expediente, el asunto, la razón y la observación no deben exceder de 100, 255, 255 y 150 caracteres respectivamente!",
      timer: 2700,
    });
  }

  $.ajax({
    url: urlApp + "documents/updateDoc",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Error...",
        text: "Ocurrió un error en el servidor.",
        timer: 2700,
      });
    },
  }).done((response) => {
    const resp = JSON.parse(response);
    if (resp === 1) {
      cleanForm();
      Swal.fire({
        icon: "success",
        title: "Actualizado!",
        text: "El documento fue actualizado correctamente!",
        timer: 2700,
      });
      listarDocumentos();
      $("#editDocument").modal("hide");
    } else {
      Swal.fire({
        icon: "error",
        title: "Error...",
        text: "Ocurrió un error en el servidor.",
        timer: 2700,
      });
    }
  });
} 

/*
document.getElementById('tabla_cita_filter').style.display = 'none';
$('input.global_filter').on('keyup click', function () {
  filterGlobal();
});
$('input.column_filter').on('keyup click', function () {
  filterColumn($(this).parents('tr').attr('data-column'));
});

function filterGlobal() {
  $('#tabla_cita').DataTable().search($('#global_filter').val()).draw();
}

table_cita.on('draw.dt', function () {
  let PageInfo = $('#tabla_cita').DataTable().page.info();
  table_cita
    .column(0, { page: 'current' })
    .nodes()
    .each(function (cell, i) {
      cell.innerHTML = i + 1 + PageInfo.start;
    });
});
*/