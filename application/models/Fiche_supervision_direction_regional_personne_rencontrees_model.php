<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_direction_regional_personne_rencontrees_model extends CI_Model {
    protected $table = 'fiche_supervision_direction_regional_personne_rencontrees';

    public function add($fiche_supervision_direction_regional_personne_rencontrees)  {
        $this->db->set($this->_set($fiche_supervision_direction_regional_personne_rencontrees))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_supervision_direction_regional_personne_rencontrees)  {
        $this->db->set($this->_set($fiche_supervision_direction_regional_personne_rencontrees))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_supervision_direction_regional_personne_rencontrees) 
    {
        return array
        (
            'id_fsdr'                       => $fiche_supervision_direction_regional_personne_rencontrees['id_fsdr'],
            'personne_rencontree'           => $fiche_supervision_direction_regional_personne_rencontrees['personne_rencontree'],
            'entite'                        => $fiche_supervision_direction_regional_personne_rencontrees['entite']
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
    
 
    public function findBy_id_fsdr($id_fsdr)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_fsdr", $id_fsdr)
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