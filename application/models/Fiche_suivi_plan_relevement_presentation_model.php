<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_suivi_plan_relevement_presentation_model extends CI_Model {
    protected $table = 'fiche_suivi_plan_relevement_presentation';

    public function add($fiche_suivi_plan_relevement_presentation)  {
        $this->db->set($this->_set($fiche_suivi_plan_relevement_presentation))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_suivi_plan_relevement_presentation)  {
        $this->db->set($this->_set($fiche_suivi_plan_relevement_presentation))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_suivi_plan_relevement_presentation) 
    {
        return array
        (
            'id_fspr'                       => $fiche_suivi_plan_relevement_presentation['id_fspr'],
            'date_suivi'                    => $fiche_suivi_plan_relevement_presentation['date_suivi'],
            'activite'                      => $fiche_suivi_plan_relevement_presentation['activite'],
            'date_demarage_activite'        => $fiche_suivi_plan_relevement_presentation['date_demarage_activite'],
            'objectif'                      => $fiche_suivi_plan_relevement_presentation['objectif'],
            'stade_realisation_activite'    => $fiche_suivi_plan_relevement_presentation['stade_realisation_activite']
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