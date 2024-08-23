$('#nocoinciden').hide();
$(document).ready(function () {
    $("#resetPasswordForm").submit(function () {
        $pass1 = $('#passwordReset').val();
        $pass2 = $('#passwordReset2').val();

        if ($pass1 !== $pass2) {
            $('#nocoinciden').show();
            return false
        } else {
            return true
        }

    })
});
