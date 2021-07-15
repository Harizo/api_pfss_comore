<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_plan_relevement_plan_production_deux_model extends CI_Model {
    protected $table = 'fiche_plan_relevement_plan_production_deux';

    public function add($fiche_plan_relevement_plan_production_deux)  {
        $this->db->set($this->_set($fiche_plan_relevement_plan_production_deux))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_plan_relevement_plan_production_deux)  {
        $this->db->set($this->_set($fiche_plan_relevement_plan_production_deux))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_plan_relevement_plan_production_deux) 
    {
        return array
        (
            

            'id_identification'             => $fiche_plan_relevement_plan_production_deux['id_identification'],
            'type'                          => $fiche_plan_relevement_plan_production_deux['type'],
            'designation'                   => $fiche_plan_relevement_plan_production_deux['designation'],
            'unite'                         => $fiche_plan_relevement_plan_production_deux['unite'],
            'quantite'                      => $fiche_plan_relevement_plan_production_deux['quantite'],
            'prix_unitaire'                 => $fiche_plan_relevement_plan_production_deux['prix_unitaire'],
            'montant'                       => $fiche_plan_relevement_plan_production_deux['montant'],
            'numero_materiel'                    => $fiche_plan_relevement_plan_production_deux['numero_materiel']
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
    
 
    public function findBy_id_identification($id_identification, $type)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_identification", $id_identification)
                        ->where("type", $type)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }


    public function get_total($id_identification, $type)
    {



        $sql = 
        "
            select
                SUM(fp_prod_deux.montant) AS total
            FROM
                fiche_plan_relevement_plan_production_deux AS fp_prod_deux,
                fiche_plan_relevement_identification AS fp
            WHERE 
                fp.id = fp_prod_deux.id_identification
                AND fp_prod_deux.type = '".$type."'
                and fp.id = ".$id_identification."
                
        ";
        return $this->db->query($sql)->result(); 
    }

}
?>