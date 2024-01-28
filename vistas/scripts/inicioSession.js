$("#frmAcceso").on('submit',function(e){
    e.preventDefault();
    logina = $("#logina").val();
    clavea = $("#clavea").val();

    $.post("../ajax/usuario.php?op=verificar",
        {
            logina:logina,
            clavea:clavea
        },
        function(data)
        {
            if(data != 'null')
            {
                $(location).attr("href","escritorio.php");
            }
            else
            {
                Swal.fire({
                    title: "Error",
                    text: "Usuario o contraseña incorrecta",
                    icon: "error"
                  });
            }
        }
    );
})
