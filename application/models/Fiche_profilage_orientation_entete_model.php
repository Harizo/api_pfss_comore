<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_profilage_orientation_entete_model extends CI_Model {
    protected $table = 'fiche_profilage_orientation_entete';

    public function add($fiche_profilage_orientation_entete)  {
        $this->db->set($this->_set($fiche_profilage_orientation_entete))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_profilage_orientation_entete)  {
        $this->db->set($this->_set($fiche_profilage_orientation_entete))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_profilage_orientation_entete) 
    {
        return array
        (
            'id_village'       => $fiche_profilage_orientation_entete['id_village'],
            'id_agex'     => $fiche_profilage_orientation_entete['id_agex'],
            'id_menage'  => $fiche_profilage_orientation_entete['id_menage'],
            'date_remplissage'     => $fiche_profilage_orientation_entete['date_remplissage']
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
    
    
    public function getfiche_profilage_orientation_enteteByvillage($id_village)  {
        $result =  $this->db->select('fiche_profilage_orientation_entete.*')
                        ->from($this->table)
                        ->where("id_village", $id_village)
                        ->order_by('date_remplissage', 'asc')
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