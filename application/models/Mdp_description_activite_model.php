<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_description_activite_model extends CI_Model {
    protected $table = 'mdp_description_activite';

    public function add($mdp_description_activite)  {
        $this->db->set($this->_set($mdp_description_activite))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_description_activite)  {
        $this->db->set($this->_set($mdp_description_activite))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_description_activite) 
    {
        return array
        (
            'id_mdp' => $mdp_description_activite['id_mdp'],
            'description_activite'       => $mdp_description_activite['description_activite']
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