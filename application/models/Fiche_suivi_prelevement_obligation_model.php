<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_suivi_prelevement_obligation_model extends CI_Model {
    protected $table = 'fiche_suivi_prelevement_obligation';

    public function add($fiche_suivi_prelevement_obligation)  {
        $this->db->set($this->_set($fiche_suivi_prelevement_obligation))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_suivi_prelevement_obligation)  {
        $this->db->set($this->_set($fiche_suivi_prelevement_obligation))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_suivi_prelevement_obligation) 
    {
        return array
        (
            

            'id_fspr'               => $fiche_suivi_prelevement_obligation['id_fspr'],
            'designation'           => $fiche_suivi_prelevement_obligation['designation'],
            'respect_obligation'    => $fiche_suivi_prelevement_obligation['respect_obligation'],
            'observation'           => $fiche_suivi_prelevement_obligation['observation']
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
    
 
    public function findBy_id_fspr($id_fspr)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_fspr", $id_fspr)
                      
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