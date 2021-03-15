<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resultat_plainte_model extends CI_Model {
    protected $table = 'resultat_plainte';

    public function add($resultatplainte)  {
        $this->db->set($this->_set($resultatplainte))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function add_down($resultatplainte, $id)  {
        $this->db->set($this->_set_down($resultatplainte, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $resultatplainte)  {
        $this->db->set($this->_set($resultatplainte))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($resultatplainte) {
        return array(
            'code'             => $resultatplainte['code'],
            'libelle'      => $resultatplainte['libelle'],
            'a_ete_modifie'    => $resultatplainte['a_ete_modifie'],
            'supprime'         => $resultatplainte['supprime'],
            'userid'           => $resultatplainte['userid'],
            'datemodification' => $resultatplainte['datemodification'],
        );
    }

    public function _set_down($resultatplainte, $id) {
        return array(
            'id'               => $id,
            'code'             => $resultatplainte['code'],
            'libelle'      => $resultatplainte['libelle'],
            'a_ete_modifie'    => $resultatplainte['a_ete_modifie'],
            'supprime'         => $resultatplainte['supprime'],
            'userid'           => $resultatplainte['userid'],
            'datemodification' => $resultatplainte['datemodification'],
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('code')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByIdArray($id)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
}
?>