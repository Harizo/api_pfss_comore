<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Livrable_mlpl_model extends CI_Model {
    protected $table = 'livrable_mlpl';

    public function add($livrable)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($livrable))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $livrable)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($livrable))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($livrable) {
		// Affectation des valeurs
        return array(            
            'id_contrat_consultant'     => $livrable['id_contrat_consultant'],
			'id_groupemlpl'             => $livrable['id_groupemlpl'],
			'activite_concernee'        => $livrable['activite_concernee'],
			'intitule_livrable'         => $livrable['intitule_livrable'],
			'date_prevue_remise'        => $livrable['date_prevue_remise'],
			'date_effective_reception'  => $livrable['date_effective_reception'],
			'intervenant'               => $livrable['intervenant'],
			'nbr_commune_touchee'       => $livrable['nbr_commune_touchee'],
			'nbr_village_touchee'       => $livrable['nbr_village_touchee'],
			'observation'               => $livrable['observation']
         );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
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
    public function findByGoupemlpl($id_groupemlpl) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_groupemlpl", $id_groupemlpl)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {
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