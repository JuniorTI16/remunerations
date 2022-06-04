
// const urlApp = "http://localhost/remunerations/";
const urlApp = 'https://remunerationsapp.herokuapp.com/';

function cleanForm() {
  $("#year").val("");
  $("#month").val("");
  $("#fileplh").val("");
}

function generateResume() {

  let year = $("#year").val();
  let month = $("#month").val();
  let fileplh = $("#fileplh")[0].files[0];

  if (year.length < 4 || month.length < 1) {
    return Swal.fire({
      icon: "error",
      title: "Error...",
      text: "El año y el mes deben tener un formato correcto!",
      timer: 2700,
    });
  }

  if (!fileplh) {
    return Swal.fire({
      icon: "error",
      title: "Error...",
      text: "El archivo DATOSPLH es requerido!",
      timer: 2700,
    });
  }

  const formData = new FormData();
  formData.append("year", year);
  formData.append("month", month);
  formData.append("fileplh", fileplh);

  Swal.fire({
    title: "<strong>Generando...</strong>",
    showConfirmButton: false
  });

  $.ajax({
    url: urlApp + "create_resume",
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
    
    if (typeof resp.mes === "string") {
      cleanForm();
      const { mes, anio } = resp;
      $.ajax({
        url: urlApp + "make",
        type: "POST",
        data: { mes, anio },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Error...",
            text: "Ocurrió un error en el servidor.",
            timer: 2700,
          });
        },
      }).done((response) => {
        Swal.fire({
          icon: "success",
          title: "Creado!",
          text: "El resumen fue creado correctamente!",
          timer: 2700,
        });
        location.href = response;
      });
    } else {
      const { errors } = resp;
      let msg = "";
      for (const error in errors) {
        msg += errors[error] + " ";
      }
      Swal.fire({
        icon: "error",
        title: "Llenar correctamente!",
        text: msg,
        timer: 2700,
      });
    }
  });
}