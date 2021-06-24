<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_formation_ebe_conclusion_model extends CI_Model {
    protected $table = 'fiche_supervision_formation_ebe_conclusion';

    public function add($fiche_supervision_formation_ebe_conclusion)  {
        $this->db->set($this->_set($fiche_supervision_formation_ebe_conclusion))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_supervision_formation_ebe_conclusion)  {
        $this->db->set($this->_set($fiche_supervision_formation_ebe_conclusion))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_supervision_formation_ebe_conclusion) 
    {
        return array
        (            
            'id_fiche_supervision'     => $fiche_supervision_formation_ebe_conclusion['id_fiche_supervision'],
            'description'      => $fiche_supervision_formation_ebe_conclusion['description']
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
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {		
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
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
    
    
    public function get_conclusionbyfiche($id_fiche_supervision)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_fiche_supervision", $id_fiche_supervision)
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