<?php
    class CategoryModel {
        private $db;

        function __construct() {
            $this->db = new Database();
        }

        function all_cate() {
            $sql = "SELECT * FROM category ORDER BY stt ASC";
            return $this->db->getAll($sql);
        }

        function get_name_cate($id) {
            $sql = "SELECT name_cate FROM category where id=?";
            return $this->db->getOne($sql, $id);
        }

        function get_sethome_cate($id) {
            $sql = "SELECT sethome FROM category WHERE id=?";
            return $this->db->getOne($sql,$id);
        }

        function get_dssp_limit($limit) {
            $sql = "SELECT * FROM product LIMIT ".$limit;
            return $this->db->getAll($sql);
        }
    }
?>