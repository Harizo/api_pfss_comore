<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_agr_maraichere_model extends CI_Model {
    protected $table = 'mdp_agr_maraichere';

    public function add($mdp_agr_maraichere)  {
        $this->db->set($this->_set($mdp_agr_maraichere))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_agr_maraichere)  {
        $this->db->set($this->_set($mdp_agr_maraichere))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_agr_maraichere) 
    {
        return array
        (
            'id_mdp' => $mdp_agr_maraichere['id_mdp'],
            'type'       => $mdp_agr_maraichere['type'],
            'localite'       => $mdp_agr_maraichere['localite'],
            'activite'       => $mdp_agr_maraichere['activite'],
            'unite'       => $mdp_agr_maraichere['unite'],
            'quantite'       => $mdp_agr_maraichere['quantite']
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