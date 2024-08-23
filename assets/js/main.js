$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 0) {
            $("#imgBrand").removeClass("logoNavBar").addClass("logoNavBarMin");
        } else {
            $("#imgBrand").removeClass("logoNavBarMin").addClass("logoNavBar");
        }
    });

});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function mostrarLoading() {
    document.getElementById("loading").style.display = "block";
}

function forceLower(strInput) {
    strInput.value = strInput.value.toLowerCase();
}


/* SELECTOR DE LOCAL */
google.maps.event.addDomListener(window, 'load', initAutocompleteStoreSelector);

let autompletado;
let D = document;
let storeSelectorInput = D.getElementById('storeSelectorInput');
let formStoreSelector = D.getElementById('formStoreSelector');
let mapStoreSelector = D.getElementById('mapStoreSelector');
let saveAddressInformationBtn = D.getElementById('saveAddressInformationBtn');
let hiddenLatInput = D.getElementById('hiddenLatInput');
let hiddenLngInput = D.getElementById('hiddenLngInput');
let btnCloseAddressSelectorModal = D.getElementById('btnCloseAddressSelectorModal');
let radiostoreSelectorRecojo = D.getElementById('storeSelectorRecojo');
let radiostoreSelectorDelivery = D.getElementById('storeSelectorDelivery');
let selectStoreSelectorElement = D.getElementById('selectStoreSelector');

let deliveryInputContainer = D.getElementById('deliveryInputContainer');
let recojoInputContainer = D.getElementById('recojoInputContainer');

var geocoderStore = new google.maps.Geocoder();

let finalLat;
let finalLng;

initialAddressLoader()

function initAutocompleteStoreSelector() {

    let options = {
        types: ['geocode'],
        componentRestrictions: { country: "PE" }
    };

    autompletado = new google.maps.places.Autocomplete(
        storeSelectorInput, options);

    autompletado.addListener('place_changed', fillInAddressStore);
}

function fillInAddressStore() {

    saveAddressInformationBtn.disabled = false;
    let place = autompletado.getPlace();

    let longitud = place.geometry.location.lng();
    let latitud = place.geometry.location.lat();
    setHiddenCoordinates(longitud, latitud);
    crearMapaStore(longitud, latitud);


}

function crearMapaStore(lng, lat) {
    console.log(lng, lat);

    document.getElementById('map-titleStore').classList.remove('d-none');

    mapStoreSelector.style.height = '300px';

    let mapsOptions = {
        zoom: 15,
        streetViewControl: false,
        center: new google.maps.LatLng(lat, lng),
        mapTypeControl: false
    };
    let map = new google.maps.Map(mapStoreSelector, mapsOptions
    );
    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(lat, lng),

    });

    google.maps.event.addListener(marker, 'dragend', function (evt) {
        console.log(evt.latLng.lng(), evt.latLng.lat());
        setHiddenCoordinates(evt.latLng.lng(), evt.latLng.lat());
    })
}


function initialAddressLoader() {
    let addressIsSelected = localStorage.getItem('addressIsSelected');

    if (!addressIsSelected) {
        localStorage.setItem('addressIsSelected', '1');
        localStorage.setItem('store', '1');
        localStorage.setItem('address', '')
        localStorage.setItem('lat', '')
        localStorage.setItem('lng', '')
        selectStoreSelectorElement.value = localStorage.getItem('store') || '';
        deliveryInputContainer.classList.remove('d-none');

    }
    if (addressIsSelected === '1') {
        storeSelectorInput.value = localStorage.getItem('address') || '';
        let shippingType = localStorage.getItem('shippingType') || 'RECOJO';
        if (shippingType === 'DELIVERY') {
            deliveryInputContainer.classList.remove('d-none');
            radiostoreSelectorDelivery.checked = true;
            hiddenLatInput.value = localStorage.getItem('lat') || '';
            hiddenLngInput.value = localStorage.getItem('lng') || '';
        } else if (shippingType === 'RECOJO') {
            recojoInputContainer.classList.remove('d-none');
            radiostoreSelectorRecojo.checked = true;
            selectStoreSelectorElement.value = localStorage.getItem('store') || '';



        }

        return false;
    } else {
        localStorage.setItem('addressIsSelected', '1');
        localStorage.setItem('store', '1');
        localStorage.setItem('address', '')
        localStorage.setItem('lat', '')
        localStorage.setItem('lng', '')


    }

}

function setHiddenCoordinates(lng, lat) {
    hiddenLngInput.value = lng;
    hiddenLatInput.value = lat;
}

formStoreSelector.addEventListener('submit', async function (event) {
    event.preventDefault();

    if (hiddenLngInput.value.length < 2 && hiddenLatInput.value.length < 2) {
        alert('error, ingrese una direccion');
        return false;
    }
    let shippingTypeInput = Array.from(this.elements.tipoReparto).find(radio => radio.checked);

    const coordenadasDB = await getCoordinates();
    let gMapsPolygons = [];
    for (let i = 0; i < coordenadasDB.length; i++) {
        const polyObject = {
            polygon: new google.maps.Polygon({ paths: JSON.parse(coordenadasDB[i].coords) }),
            price: coordenadasDB[i].price,
            store: coordenadasDB[i].idTienda,
            deliveryZoneId: coordenadasDB[i].id
        }
        gMapsPolygons.push(polyObject);
    }
    setTimeout(async function () {

        let polygonsContainAddress = false;
        for (let i = 0; i < gMapsPolygons.length; i++) {

            if (google.maps.geometry.poly.containsLocation(new google.maps.LatLng(hiddenLatInput.value * 1, hiddenLngInput.value * 1), gMapsPolygons[i].polygon)) {
                polygonsContainAddress = true;
                if (localStorage.getItem('addressIsSelected') === '1' && localStorage.getItem('store') * 1 !== gMapsPolygons[i].store * 1) {
                    let local = '';
                    /* local = gMapsPolygons[i].store * 1 === 1 ? 'Lince' : 'Surco'; */
                    if (gMapsPolygons[i].store * 1 === 1) {
                        local = 'Lince';
                    } else if (gMapsPolygons[i].store * 1 === 2) {
                        local = 'Surco';
                    } else {
                        local = 'Jesus Maria';
                    }

                    console.log(coordenadasDB);
                    const isConfirmed = await Swal.fire({
                        title: 'Está seguro?',
                        text: "La direccion ingresada es cercana a nuestro local de " + local + ", esto provocara que se cambien los productos disponibles, \n" +
                            "por lo tanto se eliminaran los productos del carrito",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dd3333',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Continuar',
                        cancelButtonText: 'Cancelar'
                    })

                    if (isConfirmed.value) {
                        let cartIsDeleted = await destroyCart();
                        console.warn(cartIsDeleted);
                        if (cartIsDeleted) {
                            saveDataToStorage('1', gMapsPolygons[i].store, storeSelectorInput.value,
                                shippingTypeInput.value, hiddenLatInput.value, hiddenLngInput.value, gMapsPolygons[i].deliveryZoneId)
                            window.location.reload();
                        }
                    }
                } else {
                    saveDataToStorage('1', gMapsPolygons[i].store, storeSelectorInput.value,
                        shippingTypeInput.value, hiddenLatInput.value, hiddenLngInput.value, gMapsPolygons[i].deliveryZoneId)
                    window.location.reload();
                }

                break;
            }
        }
        if (!polygonsContainAddress) {
            Swal.fire(
                'Lo sentimos',
                'No te encuentras en nuestra zona de reparto',
                'info'
            )
            console.log('Fuera de la zona');
        }
    }, 1000);
    return false;
})

function saveDataToStorage(addressIsSelected, store, formatedAddress, shippingType, lat, lng, deliveryZoneId) {
    localStorage.setItem('addressIsSelected', addressIsSelected);
    localStorage.setItem('address', formatedAddress);
    localStorage.setItem('store', store);
    localStorage.setItem('shippingType', shippingType);
    localStorage.setItem('lat', lat);
    localStorage.setItem('lng', lng);
    localStorage.setItem('deliveryZoneId', deliveryZoneId);
    Promise.all([setMetodoDenvio(localStorage.getItem('shippingType')), setDeliveryZoneId(localStorage.getItem('deliveryZoneId'))])
        .then(value => value.map(value1 => value1.text())).then();
}

function getCoordinates() {
    return fetch('script/delivery/getDeliveryZones.php').then(value => {
        return value.json();
    }).then(value => value.data);
}

function openAddressSelectorModal() {
    let addressIsSelected = localStorage.getItem('addressIsSelected');
    $('#modalStoreSelector').modal('show');
    if (!addressIsSelected) {
        btnCloseAddressSelectorModal.style.display = 'none';
    }
    if (addressIsSelected !== '1') {
        btnCloseAddressSelectorModal.style.display = 'none';
    }
}

async function destroyCart() {
    return fetch('./script/cart/destroyCart.php').then(value => value.text()).then(value => value);
}

function setDeliveryZoneId(id) {
    const data = new FormData();

    data.append('deliveryZone', id.toString());

    return fetch('./utils/setDeliveryZoneId.php', { method: 'POST', body: data })
}

function setMetodoDenvio(metodo) {
    const data = new FormData();
    if (metodo === 'RECOJO') {
        data.append('code', 'recojo')
    }
    if (metodo === 'DELIVERY') {
        data.append('code', 'reparto')
    }
    return fetch('./utils/cambiarMetodoDeEnvio.php', { method: 'POST', body: data })
}

function buyProductAndValidate(event) {
    event.preventDefault();
    console.log(event.target.href)
    if (isNull(localStorage.getItem('address')).length > 2
        && isNull(localStorage.getItem('lat')).length > 2
        && isNull(localStorage.getItem('lng')).length > 0) {
        window.location = event.target.href;
        return false;
    }
    openAddressSelectorModal();

}

function isNull(stringData) {
    return stringData ? stringData : '';

}

selectStoreSelectorElement.addEventListener('change', (ev) => {
    if (ev.target.value * 1 === 1) {
        hiddenLatInput.value = '-12.08656225960654';
        hiddenLngInput.value = '-77.04190387146318';

        storeSelectorInput.value = 'Julio Cesar Tello 872 - Lince';
    }
    if (ev.target.value * 1 === 2) {
        hiddenLatInput.value = '-12.109648733552977';
        hiddenLngInput.value = '-76.97506836692882';
        storeSelectorInput.value = 'Av. El Polo 121 - Surco';
    }
    if (ev.target.value * 1 === 3) {
        hiddenLatInput.value = '-12.0748571';
        hiddenLngInput.value = '-77.0894599';

        storeSelectorInput.value = 'Intisuyo 187 - San Miguel';
    }
    /* if (ev.target.value * 1 === 3) {
        hiddenLatInput.value = '-12.0753237';
        hiddenLngInput.value = '-77.0516966';

        storeSelectorInput.value = 'Av. Mello Franco 246 - Jesús María';
    } */


})

function selectShippinMethodClick(element) {
    console.log(element.value);
    if (element.value === 'DELIVERY') {
        deliveryInputContainer.classList.remove('d-none');
        recojoInputContainer.classList.add('d-none');

        hiddenLatInput.value = '';
        hiddenLngInput.value = '';

        storeSelectorInput.value = '';
    }
    if (element.value === 'RECOJO') {
        recojoInputContainer.classList.remove('d-none');
        deliveryInputContainer.classList.add('d-none');

        if (selectStoreSelectorElement.value * 1 === 1) {
            hiddenLatInput.value = '-12.08656225960654';
            hiddenLngInput.value = '-77.04190387146318';

            storeSelectorInput.value = 'Julio Cesar Tello 872 - Lince';
        }
        if (selectStoreSelectorElement.value * 1 === 2) {
            hiddenLatInput.value = '-12.109648733552977';
            hiddenLngInput.value = '-76.97506836692882';
            storeSelectorInput.value = 'Av. El Polo 121 - Surco';
        }
        if (selectStoreSelectorElement.value * 1 === 3) {
            hiddenLatInput.value = '-12.0748571';
            hiddenLngInput.value = '-77.0894599';

            storeSelectorInput.value = 'Intisuyo 187 - San Miguel';
        }
        /* if (selectStoreSelectorElement.value * 1 === 3) {
            hiddenLatInput.value = '-12.0753237';
            hiddenLngInput.value = '-77.0516966';

            storeSelectorInput.value = 'Av. Mello Franco 246 - Jesús María';
        } */

    }
}
