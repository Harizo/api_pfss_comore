<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_presence_model extends CI_Model {
    protected $table = 'see_fichepresence';

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
            'activite_id'        => $fiche_pres['activite_id'],
            'id_annee'  => $fiche_pres['id_annee'],                      
            'id_sous_projet'  => $fiche_pres['id_sous_projet'],                      
            'etape_id'      => $fiche_pres['etape_id'],                      
            'agex_id' => $fiche_pres['agex_id'],                      
            'fichepaiement_id' => $fiche_pres['fichepaiement_id'],                      
            'inapte' => $fiche_pres['inapte'],                      
            'datedu' => $fiche_pres['datedu'],                      
            'datefin' => $fiche_pres['datefin'],                      
            'observation' => $fiche_pres['observation'],                      
            'nombrejourdetravail' => $fiche_pres['nombrejourdetravail'],                      
            'village_id' => $fiche_pres['village_id'],                      
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
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id', $id)
                        ->order_by('id')
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