<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_resultat_attendu_model extends CI_Model 
{
    protected $table = 'mdp_resultat_attendu';

    public function add($mdp_resultat_attendu)  {
        $this->db->set($this->_set($mdp_resultat_attendu))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_resultat_attendu)  {
        $this->db->set($this->_set($mdp_resultat_attendu))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_resultat_attendu) 
    {
        return array
        (
            'id_mdp_description_activite' => $mdp_resultat_attendu['id_mdp_description_activite'],
            'description'       => $mdp_resultat_attendu['description'],
            'unite'       => $mdp_resultat_attendu['unite'],
            'prevu'       => $mdp_resultat_attendu['prevu'],
            'realise'       => $mdp_resultat_attendu['realise'],
            'lieu'       => $mdp_resultat_attendu['lieu']
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
    public function findByMdp($id_mdp_description_activite)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_mdp_description_activite", $id_mdp_description_activite)
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