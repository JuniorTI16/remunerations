var usersTable;

// const urlApp = "http://localhost/sistema_remuneraciones/";
const urlApp = "https://remunerationsapp.herokuapp.com/";

$(document).ready(function () {
  listUsers();
});

function listUsers() {
  usersTable = $("#usersTable").DataTable({
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
      url: urlApp + "users/listUser",
      type: "POST",
    },
    order: [[1, "asc"]],
    columns: [
      { defaultContent: "", className: "text-center" },
      {
        data: "username",
        render: function (data, type, row) {
          if (data.length > 30) {
            return (
              '<span class="badge bg-label-customize me-1">' +
              data.substring(0, 30) +
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
        data: "name",
        render: function (data, type, row) {
          if (data.length > 30) {
            return (
              '<span class="badge bg-label-customize me-1">' +
              data.substring(0, 30) +
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
        data: "photo",
        render: function (data, type, row) {
          return (
            '<img src="' +
            urlApp +
            '/public/photos/' + data + '" alt="Avatar" class="rounded-circle" height="60" width="60"/>'
          );
        },
        className: "text-center",
      },
      {
        defaultContent: `<div class="dropdown bg-label-customize">
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item editUser" href="javascript:void(0);">
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

  usersTable.on("draw.dt", function () {
    let PageInfo = $("#usersTable").DataTable().page.info();
    usersTable
      .column(0, { page: "current" })
      .nodes()
      .each(function (cell, i) {
        const val = i + 1 + PageInfo.start;
        cell.innerHTML =
          '<span class="badge bg-label-customize me-1">' + val + "</span>";
      });
  });
}

function cleanForm() {
  $("#username").val("");
  $("#name").val("");
  $("#password").val("");
  $("#userPhoto").val("");
  $("#password").attr('type', 'password');
}

$("#usersTable").on("click", ".editUser", function () {
  // Extrae la información de la fila seleccionada
  let dataRow = usersTable.row($(this).parents("tr")).data();
  $("#passworde").attr("type", "password");
  // El modal no se cierra al dar click a los costados
  $("#editUser").modal({ backdrop: "static", keyboard: false });
  $("#editUser").modal("show");

  $("#usernamee").val(decode(dataRow.username));
  $("#namee").val(decode(dataRow.name));
  $("#passworde").val(decode(dataRow.password));
  $("#userPhotoe").val("");
  $("#idUs").val(decode(dataRow.id));
});

function decode(value) {
  let he = $("#he");
  return he.html(value).text();
}

function sendUser() {
  let username = $("#username").val();
  let name = $("#name").val();
  let password = $("#password").val();
  let userPhoto = $("#userPhoto")[0].files[0];
  let formData = new FormData();

  formData.append("username", username);
  formData.append("name", name);
  formData.append("password", password);
  formData.append("userPhoto", userPhoto);

  if (username.length < 3 || name.length < 3 || password.length < 3) {
    return Swal.fire({
      icon: "error",
      title: "Error...",
      text: "El usuario, el nombre y la contraseña son campos obligatorios y deben tener 3 caracteres o más!",
      timer: 2700,
    });
  }

  if (
    username.length > 60 ||
    name.length > 100 ||
    password.length > 60
  ) {
    return Swal.fire({
      icon: "error",
      title: "Error...",
      text: "El usuario, el nombre y la contraseña no deben exceder de 60, 100 y 60 caracteres respectivamente!",
      timer: 2700,
    });
  }

  $.ajax({
    url: urlApp + "users/addUser",
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
        title: "Registrado!",
        text: "El usuario fue registrado correctamente!",
        timer: 2700,
      });
      listUsers();
      $("#addUser").modal("hide");
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

function editUser() {
  let id = $("#idUs").val();
  let username = $("#usernamee").val();
  let name = $("#namee").val();
  let password = $("#passworde").val();
  let userPhoto = $("#userPhotoe")[0].files[0];
  let formData = new FormData();

  formData.append("id", id);
  formData.append("username", username);
  formData.append("name", name);
  formData.append("password", password);
  formData.append("userPhoto", userPhoto);

  if (username.length < 3 || name.length < 3 || password.length < 3) {
    return Swal.fire({
      icon: "error",
      title: "Error...",
      text: "El usuario, el nombre y la contraseña son campos obligatorios y deben tener 3 caracteres o más!",
      timer: 2700,
    });
  }

  if (
    username.length > 60 ||
    name.length > 100 ||
    password.length > 60
  ) {
    return Swal.fire({
      icon: "error",
      title: "Error...",
      text: "El usuario, el nombre y la contraseña no deben exceder de 60, 100 y 60 caracteres respectivamente!",
      timer: 2700,
    });
  }

  $.ajax({
    url: urlApp + "users/updateUser",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    error: function (r) {
      console.log(r)
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
        text: "El usuario fue actualizado correctamente!",
        timer: 2700,
      });
      listUsers();
      $("#editUser").modal("hide");
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

$("#pe").on('click', function () {
  const passFielde = $('#passworde');
  if(passFielde.attr('type') == 'text'){
    passFielde.attr('type','password');
  } else {
    passFielde.attr('type', 'text');
  }
});

$("#p").on("click", function () {
  const passFielde = $("#password");
  if (passFielde.attr("type") == "text") {
    passFielde.attr("type", "password");
  } else {
    passFielde.attr("type", "text");
  }
});