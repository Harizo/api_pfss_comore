<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_estimation_depense_model extends CI_Model {
    protected $table = 'mdp_estimation_depense';

    public function add($mdp_estimation_depense)  {
        $this->db->set($this->_set($mdp_estimation_depense))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_estimation_depense)  {
        $this->db->set($this->_set($mdp_estimation_depense))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_estimation_depense) 
    {
        return array
        (
            'id_mdp' => $mdp_estimation_depense['id_mdp'],
            'designation'       => $mdp_estimation_depense['designation'],
            'unite'       => $mdp_estimation_depense['unite'],
            'quantite'       => $mdp_estimation_depense['quantite'],
            'dziani'       => $mdp_estimation_depense['dziani'],
            'kiyo'       => $mdp_estimation_depense['kiyo'],
            'komoni'       => $mdp_estimation_depense['komoni'],
            'trindrini'       => $mdp_estimation_depense['trindrini'],
            'prix_unitaire'       => $mdp_estimation_depense['prix_unitaire'],
            'total'       => $mdp_estimation_depense['total']
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