<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_delai_model extends CI_Model {
    protected $table = 'mdp_delai';

    public function add($mdp_delai)  {
        $this->db->set($this->_set($mdp_delai))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_delai)  {
        $this->db->set($this->_set($mdp_delai))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_delai) 
    {
        return array
        (
            'id_mdp' => $mdp_delai['id_mdp'],
            'localite'       => $mdp_delai['localite'],
            'nbr_beneficiaire'     => $mdp_delai['nbr_beneficiaire'],
            'personne_jour'     => $mdp_delai['personne_jour']
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
    public function findByMdp($id_mdp)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_mdp", $id_mdp)
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