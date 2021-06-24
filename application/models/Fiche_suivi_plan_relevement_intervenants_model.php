<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_suivi_plan_relevement_intervenants_model extends CI_Model {
    protected $table = 'fiche_suivi_plan_relevement_intervenants';

    public function add($fiche_suivi_plan_relevement_intervenants)  {
        $this->db->set($this->_set($fiche_suivi_plan_relevement_intervenants))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_suivi_plan_relevement_intervenants)  {
        $this->db->set($this->_set($fiche_suivi_plan_relevement_intervenants))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_suivi_plan_relevement_intervenants) 
    {
        return array
        (
            'id_fspr'                       => $fiche_suivi_plan_relevement_intervenants['id_fspr'],
            'bureau_regional'               => $fiche_suivi_plan_relevement_intervenants['bureau_regional'],
            'cps'                           => $fiche_suivi_plan_relevement_intervenants['cps'],
            'adc'                           => $fiche_suivi_plan_relevement_intervenants['adc'],
            'id_mere_leader'                => $fiche_suivi_plan_relevement_intervenants['id_mere_leader'],
            'autres'                        => $fiche_suivi_plan_relevement_intervenants['autres']
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
    
 
    /*public function findBy_id_fspr($id_fspr)  {
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
    }*/

    public function findBy_id_fspr($id_fspr)  {
        
        $sql = 
        "
            select
                fspri.id,
                
                gmp.id AS id_mere_leader,
                gmp.nom_prenom_ml_pl,
                
                fspri.bureau_regional,
                fspri.cps,
                fspri.adc,
                fspri.autres
            FROM
                fiche_suivi_plan_relevement AS fspr ,
                fiche_suivi_plan_relevement_intervenants AS fspri,
                groupe_ml_pl AS gmp
            WHERE 
                fspr.id = fspri.id_fspr
                AND fspri.id_mere_leader = gmp.id
                and fspr.id = ".$id_fspr."
        ";
        return $this->db->query($sql)->result();               
    }

}
?>