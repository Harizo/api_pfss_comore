<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_plan_relevement_plan_production_un_model extends CI_Model {
    protected $table = 'fiche_plan_relevement_plan_production_un';

    public function add($fiche_plan_relevement_plan_production_un)  {
        $this->db->set($this->_set($fiche_plan_relevement_plan_production_un))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_plan_relevement_plan_production_un)  {
        $this->db->set($this->_set($fiche_plan_relevement_plan_production_un))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_plan_relevement_plan_production_un) 
    {
        return array
        (
            'id_identification'             => $fiche_plan_relevement_plan_production_un['id_identification'],
            'numero'                        => $fiche_plan_relevement_plan_production_un['numero'],
            'materiel_entrant'              => $fiche_plan_relevement_plan_production_un['materiel_entrant'],
            'unite'                         => $fiche_plan_relevement_plan_production_un['unite'],
            'disponible'                    => $fiche_plan_relevement_plan_production_un['disponible'],
            'achercher'                     => $fiche_plan_relevement_plan_production_un['achercher'],
            'acheter_ou'                    => $fiche_plan_relevement_plan_production_un['acheter_ou']
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
    
 
    public function findBy_id_identification($id_identification)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_identification", $id_identification)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }

}
?>