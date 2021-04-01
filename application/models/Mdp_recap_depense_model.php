<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_recap_depense_model extends CI_Model {
    protected $table = 'mdp_recap_depense';

    public function add($mdp_recap_depense)  {
        $this->db->set($this->_set($mdp_recap_depense))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_recap_depense)  {
        $this->db->set($this->_set($mdp_recap_depense))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_recap_depense) 
    {
        return array
        (
            'id_mdp' => $mdp_recap_depense['id_mdp'],
            'categorie'       => $mdp_recap_depense['categorie'],
            'libelle'       => $mdp_recap_depense['libelle'],
            'montant'       => $mdp_recap_depense['montant'],
            'pourcentage'       => $mdp_recap_depense['pourcentage']
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