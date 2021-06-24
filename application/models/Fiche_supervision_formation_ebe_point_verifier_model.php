<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_formation_ebe_point_verifier_model extends CI_Model {
    protected $table = 'fiche_supervision_formation_ebe_point_verifier';

    public function add($fiche_supervision_formation_ebe_point_verifier)  {
        $this->db->set($this->_set($fiche_supervision_formation_ebe_point_verifier))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_supervision_formation_ebe_point_verifier)  {
        $this->db->set($this->_set($fiche_supervision_formation_ebe_point_verifier))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_supervision_formation_ebe_point_verifier) 
    {
        return array
        (            
            'id_fiche_supervision'     => $fiche_supervision_formation_ebe_point_verifier['id_fiche_supervision'],
            'point_verifier'      => $fiche_supervision_formation_ebe_point_verifier['point_verifier'],
            'appreciation'       => $fiche_supervision_formation_ebe_point_verifier['appreciation'],
            'solution'       => $fiche_supervision_formation_ebe_point_verifier['solution'],
            'observation'       => $fiche_supervision_formation_ebe_point_verifier['observation']
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
    
    
    public function get_point_verifierbyfiche($id_fiche_supervision)  {
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