<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_suivi_indicateur_model extends CI_Model 
{
    protected $table = 'mdp_suivi_indicateur';

    public function add($mdp_suivi_indicateur)  {
        $this->db->set($this->_set($mdp_suivi_indicateur))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_suivi_indicateur)  {
        $this->db->set($this->_set($mdp_suivi_indicateur))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_suivi_indicateur) 
    {
        return array
        (
            'id_mdp'                    => $mdp_suivi_indicateur['id_mdp'],
            'type_indicateur'           => $mdp_suivi_indicateur['type_indicateur'],
            'indicateur'                => $mdp_suivi_indicateur['indicateur'],
            'lieu'                      => $mdp_suivi_indicateur['lieu'],
            'valeur_reference'          => $mdp_suivi_indicateur['valeur_reference'],
            'valeur_mesure'             => $mdp_suivi_indicateur['valeur_mesure'],
            'explications'              => $mdp_suivi_indicateur['explications']
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