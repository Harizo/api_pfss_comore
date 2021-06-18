<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_formation_ebe_model extends CI_Model {
    protected $table = 'fiche_supervision_formation_ebe';

    public function add($fiche_supervision_formation_ebe)  {
        $this->db->set($this->_set($fiche_supervision_formation_ebe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_supervision_formation_ebe)  {
        $this->db->set($this->_set($fiche_supervision_formation_ebe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_supervision_formation_ebe) 
    {
        return array
        (
            'id_village'     => $fiche_supervision_formation_ebe['id_village'],
            'date_supervision'   => $fiche_supervision_formation_ebe['date_supervision'],
            'nom_missionaire'       => $fiche_supervision_formation_ebe['nom_missionaire'],
            'id_agex'     => $fiche_supervision_formation_ebe['id_agex'],
            'id_theme_sensibilisation'     => $fiche_supervision_formation_ebe['id_theme_sensibilisation'],
            'nom_ml_cps'   => $fiche_supervision_formation_ebe['nom_ml_cps']
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