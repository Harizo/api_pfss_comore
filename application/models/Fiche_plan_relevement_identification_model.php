<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_plan_relevement_identification_model extends CI_Model {
    protected $table = 'fiche_plan_relevement_identification';

    public function add($fiche_pres)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($fiche_pres))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $fiche_pres)   {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($fiche_pres))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_pres)  {
		// Affectation des valeurs
        return array(
            'id_village'                            => $fiche_pres['id_village'],
            'id_menage'                             => $fiche_pres['id_menage'],                      
            'id_agex'                               => $fiche_pres['id_agex'],                      
            'nbr_enfant_moin_quinze_ans'            => $fiche_pres['nbr_enfant_moin_quinze_ans'],      
            'composition_menage'                    => $fiche_pres['composition_menage'],                      
            'nom_prenom'                            => $fiche_pres['nom_prenom'],                      
            'age'                                   => $fiche_pres['age'],                      
            'representant_comite_protection_social' => $fiche_pres['representant_comite_protection_social'],                      
            'representant_agex'                     => $fiche_pres['representant_agex']        
        );
   }
    public function delete($id)  {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll()  {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id)  {
		// Selection par id
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
 
}
?>