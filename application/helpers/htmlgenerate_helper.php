<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('generatehtml')) {

    function inputan($type, $names, $class, $placeholder, $required, $values, $tags)
    {
        if (empty($tags)) {
            $tagtemp = "";
        } else {
            $tagtemp = "";
            foreach ($tags as $name => $tag) {
                $tagtemp = $tagtemp . " $name='$tag' ";
            }
        }
        $requred = $required == 0 ? '' : "required='required'";
        return "<div class='$class'><input type='$type' name='$names' placeholder='$placeholder' class='form-control' $requred value='$values' $tagtemp></div>";
    }


    // ---------------------------------- Textarea --------------------------------------------
    function textarea($name, $id, $class, $rows, $values)
    {
        return "<div class='$class'><textarea name='" . $name . "' id='" . $id . "' rows='" . $rows . "' class='form-control'>" . $values . "</textarea></div>";
    }


    function email($name, $placeholder, $required, $value)
    {
        $requred = $required == 0 ? '' : "required='required'";
        return "<input type='email' placeholder='$placeholder' name='$name' $required class='input-large' value='$value'>";
    }

    function combodumy($name, $id)
    {
        return "<select name='$name' id='$id' class='form-control'><option value='0'>Pilih data</option></select>";
    }

    function bulan()
    {
        $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        echo "<select name='bulan' class='input-large'>";
        for ($i = 0; $i <= 11; $i++) {
            echo " <option value=" . $i . ">" . strtoupper($bulan[$i]) . "</option>";
        }
        echo "</select>";
    }


    function buatcombo($nama, $id, $table, $field, $pk, $kondisi, $default_select)
    {
        $CI =& get_instance();
        $CI->load->model('mcrud');

        if ($kondisi == null) {
            $data = $CI->mcrud->getCombo($table, $field)->result();
        } else {
            $data = $CI->mcrud->getComboByID($table, $field, $pk, $kondisi)->result();
        }
        echo "<select name='" . $nama . "' id='" . $id . "'  class='form-control'>";

        if ($default_select != "") {
            echo "<option value=''> " . $default_select . " </option> ";
        }

        foreach ($data as $r) {
            echo " <option value=" . $r->$pk . ">" . strtoupper($r->$field) . "</option>";
        }
        echo "</select>";
    }

    function combo_segmen()
    {
        $CI =& get_instance();
        $CI->load->model('mcrud');

        $q = $CI->db->query("SELECT DISTINCT(segmen) as SEGMENS,segmen||' - ' ||segment_6_lname as SEGMEN_NAME FROM cbase_dives_2016@DWHMART_AON")->result();

        echo "<select name='segment' id='segment'  class='form-control'>";

        echo "<option value=''> Pilih Segmen </option> ";


        foreach ($q as $r) {
            echo " <option value=" . $r->SEGMENS . ">" . $r->SEGMEN_NAME . "</option>";
        }
        echo "</select>";
    }


    function editcombo($nama, $table, $class, $field, $pk, $kondisi, $tags, $value)
    {
        $CI =& get_instance();
        $CI->load->model('mcrud');
        if (empty($tags)) {
            $tagtemp = "";
        } else {
            $tagtemp = "";
            foreach ($tags as $name => $tag) {
                $tagtemp = $tagtemp . " $name='$tag' ";
            }
        }
        if ($kondisi == null) {
            $data = $CI->mcrud->getAll($table)->result();
        } else {
            $data = $CI->db->get_where($table, $kondisi)->result();
        }
        echo "<div class='$class'><select class='form-control' name='" . $nama . "' $tagtemp>";
        foreach ($data as $r) {
            echo "<option value='" . $r->$pk . "' ";
            echo $r->$pk == $value ? "selected='selected'" : "";
            echo ">" . strtoupper($r->$field) . "</option>";
        }
        echo "</select></div>";
    }

}
