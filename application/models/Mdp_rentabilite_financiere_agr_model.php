<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_rentabilite_financiere_agr_model extends CI_Model {
    protected $table = 'mdp_rentabilite_financiere_agr';

    public function add($mdp_rentabilite_financiere_agr)  {
        $this->db->set($this->_set($mdp_rentabilite_financiere_agr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_rentabilite_financiere_agr)  {
        $this->db->set($this->_set($mdp_rentabilite_financiere_agr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_rentabilite_financiere_agr) 
    {
        return array
        (
            'id_mdp' => $mdp_rentabilite_financiere_agr['id_mdp'],
            'designation'       => $mdp_rentabilite_financiere_agr['designation'],
            'investissement'       => $mdp_rentabilite_financiere_agr['investissement'],
            'estimation_quantitatif'       => $mdp_rentabilite_financiere_agr['estimation_quantitatif'],
            'estimation_recette'       => $mdp_rentabilite_financiere_agr['estimation_recette'],
            'benefice_attends'       => $mdp_rentabilite_financiere_agr['benefice_attends']
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