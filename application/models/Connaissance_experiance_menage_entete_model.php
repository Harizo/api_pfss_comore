<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Connaissance_experiance_menage_entete_model extends CI_Model {
    protected $table = 'connaissance_experience_menage_entete';

   /* public function getAll(controller) {                               
            $this->db->set($this)

        } */

    public function add($Connaissance_experiance_menage_entete)  {
        $this->db->set($this->_set($Connaissance_experiance_menage_entete))

                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $Connaissance_experiance_menage_entete)  {
        $this->db->set($this->_set($Connaissance_experiance_menage_entete))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($Connaissance_experiance_menage_entete) { 
        return array(           
            'niveau_formation' => $Connaissance_experiance_menage_entete['niveau_formation'],
            'autre_niveau_formation' => $Connaissance_experiance_menage_entete['autre_niveau_formation'],
            'id_fiche_profilage_orientation' => $Connaissance_experiance_menage_entete['id_fiche_profilage_orientation']
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
    public function findByficheprofilage($cle_etrangere)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_fiche_profilage_orientation',$cle_etrangere)
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        //->order_by('niveau_formation')
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
    
    public function findByprofilage_objet($id_fiche_profilage_orientation) {
        $this->db->where("id_fiche_profilage_orientation", $id_fiche_profilage_orientation);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
}
?>