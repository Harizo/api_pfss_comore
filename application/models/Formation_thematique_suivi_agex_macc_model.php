<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formation_thematique_suivi_agex_macc_model extends CI_Model {
    protected $table = 'formation_thematique_suivi_agex_macc';

    public function add($formation_thematique_agex)  {
        $this->db->set($this->_set($formation_thematique_agex))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $formation_thematique_agex)  {
        $this->db->set($this->_set($formation_thematique_agex))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($formation_thematique_agex) 
    {
        return array
        (
            'id_theme_sensibilisation'    => $formation_thematique_agex['id_theme_sensibilisation'],
            'periode_prevu'         => $formation_thematique_agex['periode_prevu'],
            'periode_realisation'   => $formation_thematique_agex['periode_realisation'],
            'beneficiaire'     => $formation_thematique_agex['beneficiaire'],
            'nbr_beneficiaire_cible'         => $formation_thematique_agex['nbr_beneficiaire_cible'],
            'nbr_participant'         => $formation_thematique_agex['nbr_participant'],
            'nbr_femme'         => $formation_thematique_agex['nbr_femme'],
            'formateur'         => $formation_thematique_agex['formateur'],
            'observation'       => $formation_thematique_agex['observation'],
            'id_contrat_agex'   => $formation_thematique_agex['id_contrat_agex']


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
    public function findAll() {
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
    public function findById($id) {		
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    public function findByIdArray($id)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }    
    
    public function getformation_thematique_suivi_agex_macc()  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        //->where("id_sous_projet", $id_sous_projet) 
                        //->order_by('contrat_ugp_agex.id', 'asc')
                        //->order_by('date_debut_prevu', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }

    
    public function findAlltheme_sensibilisation() {
        $result =  $this->db->select('*')
                        ->from('theme_sensibilisation')
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function findTheme_sensibilisationById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get("theme_sensibilisation");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
}
?>