function fileValidation(param) {

    let fileInput = document.getElementById('pdf');
    let filePath = fileInput.value;

    let allowedExtensions = /(.pdf|.docx)$/i;
    let size = param.files[0].size;
    console.log(size);
    if (!allowedExtensions.exec(filePath)) {
        alert('Solo archivos pdf o word');
        fileInput.value = '';
        return false;
    }
    if (size > 5000000) {

        alert('archivo muy grande, el tamaño máximo es 5MB');
        fileInput.value = '';
        return false;

    }

}
