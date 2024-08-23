<?php
session_start();
$page = 'carta';
include 'class/ProductoClass.php';
include 'class/Producto_ingrediente.php';

$objProducto = new ProductoClass();
$objProductoIngrediente = new Producto_ingrediente();

$id= $_GET['id'];
$producto = $objProducto->getProductoById($id);
$ingredientesPan = $objProductoIngrediente->getIngredientesByIdProductoAndTipo($producto['idProducto'], 'PAN', 'nombre');
$ingredientesEnsalada = $objProductoIngrediente->getIngredientesByIdProductoAndTipo($producto['idProducto'], 'ENSALADA', 'nombre');
$ingredientesCarne = $objProductoIngrediente->getIngredientesByIdProductoAndTipo($producto['idProducto'], 'CARNE', 'nombre');
$ingredientesComplemento = $objProductoIngrediente->getIngredientesByIdProductoAndTipo($producto['idProducto'], 'COMPLEMENTO', 'nombre');

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - <?php echo $producto['nombreProducto'] ?></title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">

    <link rel="stylesheet" href="assets/css/seleccion_multiple.css">
    <style>
        html{
            scroll-behavior: smooth;
        }
    </style>

</head>
<body>
<?php include 'shared/navBar.php' ?>
<div class="container main-container animated fadeIn slow mb-5">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" style="background-image: none !important;">
                <ol class="breadcrumb bg-transparent font-weight-bold text-lowercase m-0 p-0">
                    <li class="breadcrumb-item "><a href="elegipcio.php" class="text-dark">Inicio</a></li>
                    <li class="breadcrumb-item "><a href="egipcio-carta.php" class="text-dark">Carta</a></li>
                    <li class="breadcrumb-item active "
                        aria-cur rent="page"><?php echo $producto['nombreProducto'] ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-xl-6 col-lg-6 text-center">
            <img class="img-fluid " loading="lazy"
                 src="assets/img/promos/<?php echo $producto['imagenProducto'] ?>" alt="">
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-xl-6 col-lg-6">
            <h3 class="text-egipcio font-weight-bolder mt-4 mt-md-0"><?php echo $producto['nombreProducto'] ?></h3>
            <div class="row mb-3">
                <div class="col">
                    <div class="separador"></div>
                </div>
            </div>
            <h6>
                <?php echo $producto['descripcionProducto'] ?>
            </h6>
            <h5 class="">

                <?php
                if ($producto['acumulaNPuntos'] > 0) {
                    ?>
                    ¡Acumula <?php echo $producto['acumulaNPuntos'] ?> Pts!

                    <?php
                }
                ?>

            </h5>
            <h4 class="font-weight-bolder mt-2">S/. <?php echo $producto['precioProducto'] ?>.00</h4>
            <div class="row mt-5">
                <div class="col text-center">
                    <a href="#helperIngredientes"
                       class="comprar-button w-100 d-block text-center">Elije tus ingredientes <i
                                class="fa fa-arrow-down" aria-hidden="true"></i></a>
                </div>

            </div>

        </div>
    </div>

<div id="helperIngredientes" style="height: 86px"></div>
    <div class="row mb-5">
        <div class="col text-center">
            <form id="formIngredientes" method="post" action="script/cartAction.php">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
                <h3 class="text-center text-egipcio">Paso 1</h3>
                <h5 class="text-center">(Escoge tu tipo de pan) <i
                            class="fa fa-arrow-down animated bounce infinite slow" aria-hidden="true"></i></h5>

                <input type="hidden" class="form-control idModal" name="id"
                       value="<?php echo $producto['idProducto'] ?>">

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3  p-3 justify-content-center">

                    <?php foreach ($ingredientesPan as $ingrediente) {
                        $uniqueId = uniqid();
                        ?>

                        <div class="col mb-2 mx-auto justify-content-center d-flex">
                            <div class="card h-100 card-products">
                                <img src="assets/img/ingredientes/<?php echo $ingrediente['imageUrl'] ?>"
                                     class="card-img-top"
                                     alt="<?php echo $ingrediente['nombre'] ?>">
                                <div class="card-body p-2 d-flex flex-column">
                                    <h5 class="card-title titulo-cards"><?php echo $ingrediente['nombre'] ?></h5>
                                    <input name="paso1[]" class="d-none" type="checkbox" id="<?php echo $uniqueId ?>">
                                    <label for="<?php echo $uniqueId ?>"
                                           class="ingrediente-button w-100 align-self-end mt-auto">Elegir
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>



                </div>


                <h3 class="text-center text-egipcio">Paso 2</h3>
                <h5 class="text-center">(Escoge 1 complemento) <i
                            class="fa fa-arrow-down animated bounce infinite slow" aria-hidden="true"></i></h5>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3  p-3 justify-content-center">


                    <?php foreach ($ingredientesComplemento as $ingrediente) {
                        $uniqueId = uniqid();
                        ?>

                        <div class="col mb-2 mx-auto justify-content-center d-flex">
                            <div class="card h-100 card-products">
                                <img src="assets/img/ingredientes/<?php echo $ingrediente['imageUrl'] ?>"
                                     class="card-img-top"
                                     alt="<?php echo $ingrediente['nombre'] ?>">
                                <div class="card-body p-2 d-flex flex-column">
                                    <h5 class="card-title titulo-cards"><?php echo $ingrediente['nombre'] ?></h5>
                                    <input name="paso2[]" class="d-none" type="checkbox" id="<?php echo $uniqueId ?>">
                                    <label for="<?php echo $uniqueId ?>"
                                           class="ingrediente-button w-100 align-self-end mt-auto">Elegir
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <h3 class="text-center text-egipcio">Paso 3</h3>
                <h5 class="text-center">(Escoge 4 ensaladas) <i
                            class="fa fa-arrow-down animated bounce infinite slow" aria-hidden="true"></i></h5>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3  p-3 justify-content-center">


                    <?php foreach ($ingredientesEnsalada as $ingrediente) {
                        $uniqueId = uniqid();
                        ?>

                        <div class="col mb-2 mx-auto justify-content-center d-flex">
                            <div class="card h-100 card-products">
                                <img src="assets/img/ingredientes/<?php echo $ingrediente['imageUrl'] ?>"
                                     class="card-img-top"
                                     alt="<?php echo $ingrediente['nombre'] ?>">
                                <div class="card-body p-2 d-flex flex-column">
                                    <h5 class="card-title titulo-cards"><?php echo $ingrediente['nombre'] ?></h5>
                                    <input name="paso3[]" class="d-none" type="checkbox" id="<?php echo $uniqueId ?>">
                                    <label for="<?php echo $uniqueId ?>"
                                           class="ingrediente-button w-100 align-self-end mt-auto">Elegir
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>


                <h3 class="text-center text-egipcio">Paso 4</h3>
                <h5 class="text-center">(Escoge tu tipo de carne) <i
                            class="fa fa-arrow-down animated bounce infinite slow" aria-hidden="true"></i></h5>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3  p-3 justify-content-center">

                    <?php foreach ($ingredientesCarne as $ingrediente) {
                        $uniqueId = uniqid();
                        ?>

                        <div class="col mb-2 mx-auto justify-content-center d-flex">
                            <div class="card h-100 card-products">
                                <img src="assets/img/ingredientes/<?php echo $ingrediente['imageUrl'] ?>"
                                     class="card-img-top"
                                     alt="<?php echo $ingrediente['nombre'] ?>">
                                <div class="card-body p-2 d-flex flex-column">
                                    <h5 class="card-title titulo-cards"><?php echo $ingrediente['nombre'] ?></h5>
                                    <input name="paso4[]" class="d-none" type="checkbox" id="<?php echo $uniqueId ?>">
                                    <label for="<?php echo $uniqueId ?>"
                                           class="ingrediente-button w-100 align-self-end mt-auto">Elegir
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>


                <div class="row mt-2">
                    <div class="col text-center">
                        <input type="hidden" name="action" value="addToCart">
                        <input type="hidden" name="cantidad" value="1">
                        <button type="submit" class="btn btn-primary btn-lg">Comprar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
<?php include 'shared/footer.php' ?>
<script>
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


    checkboxlimit(document.forms.formIngredientes['paso1[]'], 1);
    checkboxlimit(document.forms.formIngredientes['paso2[]'], 1);
    checkboxlimit(document.forms.formIngredientes['paso3[]'], 4);
    checkboxlimit(document.forms.formIngredientes['paso4[]'], 1);


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


</script>
</body>
</html>
