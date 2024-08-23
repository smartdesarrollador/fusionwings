<?php
session_start();
unset($_SESSION['estado_cupon']);
$page = 'promociones';


require 'class/ProductoClass.php';
require 'class/TiendaClass.php';
$objTienda = new TiendaClass();
$objProducto = new ProductoClass();
$lista = $objProducto->getTipoProductos(1);
$estadoTienda = trim($objTienda->getEstadoTienda()['estado']);

if (count($lista) < 1) {
    header("Status: 302 Found");
    header('location: egipcio-carta.php');
    exit();
}

//GENERANDO LOS META TAGS
$nombres = '';
foreach ($lista as $item) {
    $nombres = $nombres . ', ' . $item['nombreProducto'];
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta https-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Egipcio - Promociones</title>
    <?php include "shared/libraries.php"; ?>
    <link rel="stylesheet" href="assets/css/cards.css">


    <!--Seo Meta Tags-->
    <meta name="title" content="Promociones - El Egipcio">
    <meta name="description" content="<?php echo substr($nombres, 0, 151) ?>">
    <meta name="keywords" content="<?php echo $nombres ?>">

    <meta property="og:image" content="https://elegipcio.pe/assets/img/OpenGraph/ogPromociones.png"/>

    <meta property="og:description"
          content="<?php echo substr($nombres, 0, 151) ?>">
    <link rel="stylesheet" href="assets/css/seleccion_multiple.css">
    <style>

    </style>
</head>
<body>
<?php include 'shared/navBar.php' ?>
<div class="container main-container animated fadeIn slow mb-5">
    <div class="row mb-3">
        <div class="col">
            <h2 class="titulo">PROMOS</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="separador"></div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-3 mb-4" id="productsDataContainer">

    </div>

    <div class="row mb-5">
        <div class="col text-center">
            <small>▲ FOTOS REFERENCIALES ▲</small>

        </div>
    </div>

</div>

<?php include 'shared/footer.php' ?>
<script src="assets/js/egipcio-combos.js"></script>
<script>
    const data = <?= json_encode($lista) ?>;

    let dataContainer = document.getElementById('productsDataContainer');


    if (localStorage.getItem('addressIsSelected')) {
        if (localStorage.getItem('addressIsSelected') === '1') {
            renderData(parseInt(localStorage.getItem('store')));
        }

    }

    function renderData(storeId) {
        data.filter(value => value.store_id * 1 === storeId).forEach(product => {
            dataContainer.innerHTML += objectToProductoCard(product);

        })
    }

    function objectToProductoCard(product) {
        let card = '<div class="col mb-5 animated fadeIn"><div class="card h-100 card-products">' +
            '<img src="assets/img/promos/' + product.imagenProducto + '" class="card-img-top" alt="...">\n' +
            '                    <div class="card-body p-2 d-flex flex-column">';
        if (product.esNuevo === 'TRUE') {
            card += '<h5 class="text-egipcio mt-2">\n' +
                '                                !NUEVO PRODUCTO!\n' +
                '                            </h5>'
        }
        card += '<h5 class="card-title titulo-cards">' + product.nombreProducto + '</h5>\n' +
            '                        <p class="card-text">' + isNull(product.descripcionProducto) + '</p>\n' +
            '                        <p class="card-points-description">';
        if (product.acumulaNPuntos * 1 > 0) {
            card += 'Acumula  ' + product.acumulaNPuntos + ' puntos';
        }
        card += '</p>'
        if (product.precioDescuento * 1 > 0) {
            card += '<h5 class="card-price">\n' +
                '                                <del>S/. ' + product.precioDescuento + '</del>\n' +
                '                            </h5>'
        }
        card += '<p class="card-price">S/ ' + Number.parseFloat(product.precioProducto).toFixed(2)  + '</p>';


        if (product.stock === 'YES') {

            if (product.productoObservaciones === 'MULTI_BOWL') {
                card += '<a onclick="buyProductAndValidate(event)"\n' + 'href="egipcio-bowl-mediano-y-chicha.php?id=' + product.idProducto + '"' +
                    'class="comprar-button w-100 align-self-end mt-auto">Arma tu Bowl</a>'
            } else {

                card += '<a onclick="buyProductAndValidate(event)" onclick="mostrarLoading()"\n' +
                    '                                       href="script/cartAction.php?action=addToCart&id=' + product.idProducto + '&cantidad=1"\n' +
                    '                                    class="comprar-button w-100 align-self-end mt-auto">Comprar</a>'
            }

        } else {

            card += '<button type="button" class="comprar-button w-100 align-self-end mt-auto">AGOTADO\n' +
                '                                </button>'

        }

        card += '</div>\n' +
            '                </div>\n' +
            '            </div>';
        return card;
    }



</script>
</body>
</html>
