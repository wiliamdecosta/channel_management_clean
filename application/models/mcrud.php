<?php

/**
 * Description of mcrud
 * class ini digunakan untuk melakukan manipulasi  data sederhana
 */
class mcrud extends CI_Model
{

    public function getList($tables, $limit, $page, $by, $sort)
    {
        $this->db->order_by($by, $sort);
        $this->db->limit($limit, $page);
        return $this->db->get($tables);
    }

    // menampilkan semua data dari sebuah tabel.
    public function getAll($tables)
    {
        return $this->db->get($tables);
    }

    public function getCombo($table,$field){
        $this->db->order_by($field, 'asc');
        return $this->db->get($table);
    }
    public function getComboByID($table,$field,$pk,$where){
        $this->db->select($pk,$field);
        $this->db->where($where);
        $this->db->order_by($field, 'desc');
        $this->db->get($table);
    }

    // menghitun jumlah record dari sebuah tabel.
    public function countAll($tables)
    {
        return $this->db->count_all_results($tables);
    }

    // menghitun jumlah record dari sebuah query.
    public function countQuery($query)
    {
        return $this->db->query($query)->num_rows();
    }

    // menampilkan satu record brdasarkan parameter.
    public function kondisi($tables, $where)
    {
        $this->db->where($where);
        return $this->db->get($tables);
    }

    //menampilkan satu record brdasarkan parameter.
    public function getByID($tables, $pk, $id)
    {
        $this->db->where($pk, $id);
        return $this->db->get($tables);
    }

    // Menampilkan data dari sebuah query dengan pagination.
    public function queryList($query, $limit, $page)
    {

        return $this->db->query($query . " limit " . $page . "," . $limit . "");
    }

    public function queryBiasa($query, $by, $sort)
    {
        // $this->db->order_by($by,$sort);
        return $this->db->query($query);
    }

    // memasukan data ke database.
    public function insert($tables, $data)
    {
        $this->db->insert($tables, $data);
    }

    // update data kedalalam sebuah tabel
    public function update($tables, $data, $pk, $id)
    {
        $this->db->where($pk, $id);
        $this->db->update($tables, $data);
    }

    // menghapus data dari sebuah tabel
    public function delete($tables, $pk, $id)
    {
        $this->db->where($pk, $id);
        $this->db->delete($tables);
    }


}