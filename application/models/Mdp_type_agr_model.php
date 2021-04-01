<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_type_agr_model extends CI_Model {
    protected $table = 'mdp_type_agr';

    public function add($mdp_type_agr)  {
        $this->db->set($this->_set($mdp_type_agr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_type_agr)  {
        $this->db->set($this->_set($mdp_type_agr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_type_agr) 
    {
        return array
        (
            'id_mdp' => $mdp_type_agr['id_mdp'],
            'localite'       => $mdp_type_agr['localite'],
            'type_agr'     => $mdp_type_agr['type_agr'],
            'beneficiaire'     => $mdp_type_agr['beneficiaire']
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