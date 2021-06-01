<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_duree_planning_mere_model extends CI_Model {
    protected $table = 'mdp_duree_planning_mere';

    public function add($mdp_duree_planning_mere)  {
        $this->db->set($this->_set($mdp_duree_planning_mere))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_duree_planning_mere)  {
        $this->db->set($this->_set($mdp_duree_planning_mere))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_duree_planning_mere) 
    {
        return array
        (
            'id_mdp' => $mdp_duree_planning_mere['id_mdp'],
            'libelle'       => $mdp_duree_planning_mere['libelle']
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