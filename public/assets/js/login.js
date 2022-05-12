// const urlApp = "http://localhost/sistema_remuneraciones/";
const urlApp = "https://remunerationsapp.herokuapp.com/";

$('#formAuthentication').submit(function (event) {
    event.preventDefault();
    const username = $('#username').val();
    const password = $("#password").val();
    if(!username || !password){
        return Swal.fire({
            icon: "error",
            title: "Error...",
            text: "El usuario y contraseña son obligatorios!",
            timer: 2700,
        });
    }

    $.ajax({
        url: urlApp + 'auth',
        type: "POST",
        data: {
            username,
            password
        },
        error: function (r) {
            console.log(r)
            Swal.fire({
                icon: "error",
                title: "Error...",
                text: "Ocurrió un error en el servidor.",
                timer: 2700,
            });
        },
    }).done(function (response) {
        let resp = JSON.parse(response);
        if (resp == 0) {
             Swal.fire({
              icon: "error",
              title: "Error...",
              text: "Usuario o contraseña Incorrectos!",
              timer: 2700,
            });
        } else {
            Swal.fire({
              icon: "success",
              title: "Bienvenid@!",
              text: resp + " bienvenid@ al Sistema de Remuneraciones!",
              timer: 2700,
            });
            setTimeout(() => {
                window.location.href = `${urlApp}home`;
            }, 2000);
        }
    });
});