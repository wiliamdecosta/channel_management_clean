/**
 * Created by Gery on 02/02/2016.
 */

function returnValue(retVal) {
    var lov_id = $("#lov_id").val();
    var modal_id = $("#modal_id").val();
    var divID = $("#lov_value").val();
    var arrDivID = divID.split('#~#');
    var arrVal = retVal.split('#~#');

    if (arrDivID.length == arrVal.length) {
        for (var x = 0; x < arrVal.length; x++) {
            $("#" + arrDivID[x] + "").val(arrVal[x]);
        }
        $("#" + modal_id).modal("hide");
        // $("#"+lov_id).html("");
    } else {
        var msg = "";
        msg += "Jumlah parameter tidak sesuai\n";
        msg += " - Jumlah id = " + arrDivID.length + "\n";
        msg += " - Jumlah value lov = " + arrVal.length + "\n";
        swal("", msg, "warning");
        return false;
    }
}

function blank() {
    var lov_id = $("#lov_id").val();
    var modal_id = $("#modal_id").val();
    var divID = $("#lov_value").val();
    var arrDivID = divID.split('#~#');
    for (var x = 0; x < arrDivID.length; x++) {
        $("#" + arrDivID[x] + "").val("");
    }
    $("#" + modal_id).modal("hide");

}
