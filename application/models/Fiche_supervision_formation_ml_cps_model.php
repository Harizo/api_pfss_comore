<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_formation_ml_cps_model extends CI_Model {
    protected $table = 'fiche_supervision_formation_ml_cps';

    public function add($fiche_supervision_formation_ml_cps)  {
        $this->db->set($this->_set($fiche_supervision_formation_ml_cps))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_supervision_formation_ml_cps)  {
        $this->db->set($this->_set($fiche_supervision_formation_ml_cps))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_supervision_formation_ml_cps) 
    {
        return array
        (
            'id_village'     => $fiche_supervision_formation_ml_cps['id_village'],
            'date_supervision'   => $fiche_supervision_formation_ml_cps['date_supervision'],
            'nom_missionaire'       => $fiche_supervision_formation_ml_cps['nom_missionaire'],
            'id_agex'     => $fiche_supervision_formation_ml_cps['id_agex'],
            'nom_ml_cps'   => $fiche_supervision_formation_ml_cps['nom_ml_cps']
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
    
    
    public function get_supervision_formationbyvillage($id_village)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_village", $id_village)
                        ->order_by('date_supervision', 'asc')
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