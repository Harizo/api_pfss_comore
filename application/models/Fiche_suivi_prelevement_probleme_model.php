<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_suivi_prelevement_probleme_model extends CI_Model {
    protected $table = 'fiche_suivi_prelevement_probleme';

    public function add($fiche_suivi_prelevement_probleme)  {
        $this->db->set($this->_set($fiche_suivi_prelevement_probleme))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_suivi_prelevement_probleme)  {
        $this->db->set($this->_set($fiche_suivi_prelevement_probleme))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_suivi_prelevement_probleme) 
    {
        return array
        (
            

            'id_fspr'             => $fiche_suivi_prelevement_probleme['id_fspr'],
            'probleme'            => $fiche_suivi_prelevement_probleme['probleme'],
            'solution'            => $fiche_suivi_prelevement_probleme['solution'],
            'observation'         => $fiche_suivi_prelevement_probleme['observation']
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