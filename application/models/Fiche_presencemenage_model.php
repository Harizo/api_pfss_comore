<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_presencemenage_model extends CI_Model {
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
            'fiche_presence_id'        => $fiche_pres['fiche_presence_id'],
            'menage_id'  => $fiche_pres['menage_id'],                      
            'village_id'  => $fiche_pres['village_id'],                      
            'travailleurpresent'      => $fiche_pres['travailleurpresent'],                      
            'suppliantpresent' => $fiche_pres['suppliantpresent'],                      
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
		// Selection de tous les enregitrements
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
    public function findByFiche_presence_id($fiche_presence_id)  {
		// Selection de tous les enregitrements
		 $requete="select fpm.fiche_presence_id,fpm.menage_id,fpm.village_id,m.inapte,m.nomchefmenage,"
				."m.NumeroEnregistrement,m.NomTravailleur,m.SexeTravailleur,m.NomTravailleurSuppliant,m.SexeTravailleurSuppliant,"
				."fpm.travailleurpresent,fpm.suppliantpresent"
				." from see_fichepresencemenage as fpm"
				." left outer join menage as m on m.id=fpm.menage_id"
				." where fpm.fiche_presence_id=".$fiche_presence_id;
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
 
}
?>