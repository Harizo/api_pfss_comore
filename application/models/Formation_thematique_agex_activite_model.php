<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formation_thematique_agex_activite_model extends CI_Model {
    protected $table = 'formation_thematique_agex_activite';

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
            'id_theme_formation'    => $formation_thematique_agex['id_theme_formation'],
            'id_theme_formation_detail'    => $formation_thematique_agex['id_theme_formation_detail'],
            'contenu'         => $formation_thematique_agex['contenu'],
            'objectif'           => $formation_thematique_agex['objectif'],
            'methodologie'   => $formation_thematique_agex['methodologie'],
            'materiel'     => $formation_thematique_agex['materiel'],
            'date'         => $formation_thematique_agex['date'],
            'duree'         => $formation_thematique_agex['duree'],
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
    
    public function getformation_thematique_agex()  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                       // ->join("contrat_ugp_agex","contrat_ugp_agex.id=formation_thematique_agex.id_contrat_agex")
                        //->where("id_sous_projet", $id_sous_projet) 
                        //->order_by('contrat_ugp_agex.id', 'asc')
                        //->order_by('contenu', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
        
    public function gettheme_formation() {
        $result =  $this->db->select('*')
                        ->from('theme_formation')
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
      
    public function gettheme_formation_datailBytheme($id_theme_formation) {
        $result =  $this->db->select('*')
                        ->from('theme_formation_detail')
                        ->where('id_theme_formation',$id_theme_formation)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findTheme_formationById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get("theme_formation");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    public function findTheme_formation_detailById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get("theme_formation_detail");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
}
?>