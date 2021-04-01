<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_indicateur_model extends CI_Model {
    protected $table = 'mdp_indicateur';

    public function add($mdp_indicateur)  {
        $this->db->set($this->_set($mdp_indicateur))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_indicateur)  {
        $this->db->set($this->_set($mdp_indicateur))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_indicateur) 
    {
        return array
        (
            'id_mdp' => $mdp_indicateur['id_mdp'],
            'categorie_travailleur'       => $mdp_indicateur['categorie_travailleur'],
            'numero_semaine'       => $mdp_indicateur['numero_semaine'],
            'nombre'       => $mdp_indicateur['nombre'],
            'lieu'       => $mdp_indicateur['lieu']
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