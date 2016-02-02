/**
 * Created by Gery on 02/02/2016.
 */

    function returnValue(retVal) {
        var divID = $("#lov_value").val();
        var arrDivID = divID.split('#~#');
        var arrVal = retVal.split('#~#');

        if (arrDivID.length == arrVal.length) {
            for (var x=0;x<arrVal.length;x++) {
                $("#"+arrDivID[x]+"").val(arrVal[x]) ;
                $("#myModal").modal("hide");
            }
        } else {
            var msg = "";
            msg += "Jumlah parameter tidak sesuai\n";
            msg += " - Jumlah id = " + arrDivID.length + "\n";
            msg += " - Jumlah value lov = " + arrVal.length + "\n";
            alert(msg);
            return false;
        }
    }
