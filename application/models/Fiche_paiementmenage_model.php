<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_paiementmenage_model extends CI_Model {
    protected $table = 'see_fichepaiementmenage';

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
            'fiche_paiement_id'        => $fiche_pres['fiche_paiement_id'],
            'menage_id'  => $fiche_pres['menage_id'],                      
            'village_id'  => $fiche_pres['village_id'],                      
            'fiche_presence_id'        => $fiche_pres['fiche_presence_id'],
            'travailleurpresent'      => $fiche_pres['travailleurpresent'],                      
            'suppliantpresent' => $fiche_pres['suppliantpresent'],                      
            'montanttotalapayer' => $fiche_pres['montanttotalapayer'],                      
            'montanttotalpaye' => $fiche_pres['montanttotalpaye'],                      
            'montantapayertravailleur' => $fiche_pres['montantapayertravailleur'],                      
            'montantpayetravailleur' => $fiche_pres['montantpayetravailleur'],                      
            'montantapayersuppliant' => $fiche_pres['montantapayersuppliant'],                      
            'montantpayesuppliant' => $fiche_pres['montantpayesuppliant'],                      
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