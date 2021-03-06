<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_duree_planning_model extends CI_Model {
    protected $table = 'mdp_duree_planning';

    public function add($mdp_duree_planning)  {
        $this->db->set($this->_set($mdp_duree_planning))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_duree_planning)  {
        $this->db->set($this->_set($mdp_duree_planning))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_duree_planning) 
    {
        return array
        (
            'id_mere' => $mdp_duree_planning['id_mere'],
            'designation_activite'       => $mdp_duree_planning['designation_activite'],
            'numero_semaine_deb'       => $mdp_duree_planning['numero_semaine_deb'],
            'numero_jour_deb'       => $mdp_duree_planning['numero_jour_deb'],
            
            'numero_semaine_fin'       => $mdp_duree_planning['numero_semaine_fin'],
            'numero_jour_fin'       => $mdp_duree_planning['numero_jour_fin']
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
    public function findByMere($id_mere)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_mere", $id_mere)
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