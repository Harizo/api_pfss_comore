<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_formation_model extends CI_Model {
    protected $table = 'mdp_formation';

    public function add($mdp_formation)  {
        $this->db->set($this->_set($mdp_formation))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_formation)  {
        $this->db->set($this->_set($mdp_formation))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_formation) 
    {
        return array
        (
            'id_mdp' => $mdp_formation['id_mdp'],
            'theme'       => $mdp_formation['theme'],
            'duree'       => $mdp_formation['duree'],
            'lieu'       => $mdp_formation['lieu'],
            'nbr_beneficiaire'       => $mdp_formation['nbr_beneficiaire']
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