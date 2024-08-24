
$('.modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('whatever'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-body .idModal').val(recipient)
});


function checkboxlimit(checkgroup, limit) {
    for (var i = 0; i < checkgroup.length; i++) {
        checkgroup[i].onclick = function () {
            let checkedcount = 0;
            for (let i = 0; i < checkgroup.length; i++)
                checkedcount += (checkgroup[i].checked) ? 1 : 0;
            if (checkedcount > limit) {
                alert("En este paso, solo puedes elegir " + limit + " ingredientes.");
                this.checked = false
            }
        }
    }
}


/* PARA EL MODAL DE BOWL */
$("#formIngredientes").submit(function () {

    let totalSeleccionados = 0;
    let infoSeleccionados = '';
    let minimoChkSeleccionados = 7;

    $($('#formIngredientes input[type=checkbox]')).each(function () {
        if (this.checked) {
            infoSeleccionados += $(this)[0].previousElementSibling.textContent + ', ';

            totalSeleccionados += 1;
        }
    });

    let campo = '<input type="hidden"   name="productoIngredientes" value="' + infoSeleccionados + '" />';
    $(this).append(campo);

    console.log(infoSeleccionados);

    if (totalSeleccionados < minimoChkSeleccionados) {
        alert("Whoops, te faltan ingredientes");
        return false;
    }

mostrarLoading();
});

/* PARA EL MODAL DE SHAWERMA PREMIUM */
$("#formIngredientesShawerma").submit(function () {

    let totalSeleccionados = 0;
    let infoSeleccionados = '';
    let minimoChkSeleccionados = 4;

    $($('#formIngredientesShawerma input[type=checkbox]')).each(function () {
        if (this.checked) {
            infoSeleccionados += $(this)[0].previousElementSibling.textContent + ', ';

            totalSeleccionados += 1;
        }
    });

    let campo = '<input type="hidden"   name="productoIngredientes" value="' + infoSeleccionados + '" />';
    $(this).append(campo);

    console.log(infoSeleccionados);

    if (totalSeleccionados < minimoChkSeleccionados) {
        alert("Whoops, te faltan ingredientes");
        return false;
    }

    mostrarLoading();
});


/* PARA EL MODAL DE FALAFEL PREMIUM*/
$("#formIngredientesFalafel").submit(function () {

    let totalSeleccionados = 0;
    let infoSeleccionados = '';
    let minimoChkSeleccionados = 3;

    $($('#formIngredientesFalafel input[type=checkbox]')).each(function () {
        if (this.checked) {
            infoSeleccionados += $(this)[0].previousElementSibling.textContent + ', ';

            totalSeleccionados += 1;
        }
    });

    let campo = '<input type="hidden"   name="productoIngredientes" value="' + infoSeleccionados + '" />';
    $(this).append(campo);

    console.log(infoSeleccionados);

    if (totalSeleccionados < minimoChkSeleccionados) {
        alert("Whoops, te faltan ingredientes");
        return false;
    }

    mostrarLoading();
});
//form combo al peso
$("#formComboAlPeso").submit(function () {

    let totalSeleccionados = 0;
    let infoSeleccionados = '';
    let minimoChkSeleccionados = 2;

    $($('#formComboAlPeso input[type=checkbox]')).each(function () {
        if (this.checked) {
            infoSeleccionados += $(this)[0].previousElementSibling.textContent + ', ';

            totalSeleccionados += 1;
        }
    });

    let campo = '<input type="hidden"   name="productoIngredientes" value="' + infoSeleccionados + '" />';
    $(this).append(campo);

    console.log(infoSeleccionados);

    if (totalSeleccionados < minimoChkSeleccionados) {
        alert("Whoops, te faltan ingredientes");
        return false;
    }

    mostrarLoading();
});
