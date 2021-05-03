<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_env_model extends CI_Model
{
    protected $table = 'fiche_env';


    public function add($fiche_env)
    {
        $this->db->set($this->_set($fiche_env))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $fiche_env)
    {
        $this->db->set($this->_set($fiche_env))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($fiche_env)
    {
        return array(            
            //'intitule_sousprojet'=> $fiche_env['intitule_sousprojet'],      
            'bureau_etude'=> $fiche_env['bureau_etude'],      
            'ref_contrat'=> $fiche_env['ref_contrat'],
            //'id_ile'=> $fiche_env['id_ile'],      
            //'id_region'=> $fiche_env['id_region'],      
            //'id_commune'=> $fiche_env['id_commune'],       
            'composante_sousprojet'=> $fiche_env['composante_sousprojet'],      
            //'localisation_sousprojet'=> $fiche_env['localisation_sousprojet'],      
            //'localisation_geo'=> $fiche_env['localisation_geo'],      
            'composante_zone_susce'=> $fiche_env['composante_zone_susce'],      
            'probleme_env'=> $fiche_env['probleme_env'],      
            'mesure_envisage'=> $fiche_env['mesure_envisage'],    
            'justification_classe_env'=> $fiche_env['justification_classe_env'],     
            'observation'=> $fiche_env['observation'],      
            'date_visa_rt'=> $fiche_env['date_visa_rt'],     
            'date_visa_ugp'=> $fiche_env['date_visa_ugp'],     
            'date_visa_be'=> $fiche_env['date_visa_be'],
            'id_sous_projet_localisation' => $fiche_env['id_sous_projet_localisation']
        );
    }

    public function add_down($fiche_env, $id)  {
        $this->db->set($this->_set_down($fiche_env, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($fiche_env, $id)
    {
        return array(
            //'intitule_sousprojet'=> $fiche_env['intitule_sousprojet'],      
            'bureau_etude'=> $fiche_env['bureau_etude'],      
            'ref_contrat'=> $fiche_env['ref_contrat'],
            //'id_ile'=> $fiche_env['id_ile'],      
            //'id_region'=> $fiche_env['id_region'],      
            //'id_commune'=> $fiche_env['id_commune'],       
            'composante_sousprojet'=> $fiche_env['composante_sousprojet'],      
            //'localisation_sousprojet'=> $fiche_env['localisation_sousprojet'],      
            //'localisation_geo'=> $fiche_env['localisation_geo'],      
            'composante_zone_susce'=> $fiche_env['composante_zone_susce'],      
            'probleme_env'=> $fiche_env['probleme_env'],      
            'mesure_envisage'=> $fiche_env['mesure_envisage'],    
            'justification_classe_env'=> $fiche_env['justification_classe_env'],     
            'observation'=> $fiche_env['observation'],      
            'date_visa_rt'=> $fiche_env['date_visa_rt'],     
            'date_visa_ugp'=> $fiche_env['date_visa_ugp'],     
            'date_visa_be'=> $fiche_env['date_visa_be'],
            'id_sous_projet_localisation' => $fiche_env['id_sous_projet_localisation'] 
        );
    }

    public function delete($id)
    {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }


    public function findAll()
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id_sous_projet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    

    public function getfiche_envbysousprojet_localisation($id_sous_projet_localisation)
    {
        $result =  $this->db->select("
        id as id,      
        bureau_etude as bureau_etude,      
        ref_contrat as ref_contrat,       
        composante_sousprojet as composante_sousprojet,      
        composante_zone_susce as composante_zone_susce,      
        probleme_env as probleme_env,      
        mesure_envisage as mesure_envisage,    
        justification_classe_env as justification_classe_env,     
        observation as observation,      
        DATE_FORMAT(date_visa_rt, '%d/%m/%Y') as date_visa_rt,     
        DATE_FORMAT(date_visa_ugp, '%d/%m/%Y') as date_visa_ugp,     
        DATE_FORMAT(date_visa_be, '%d/%m/%Y') as date_visa_be,
        id_sous_projet_localisation as id_sous_projet_localisation")
                        ->from($this->table)
                        ->where('id_sous_projet_localisation',$id_sous_projet_localisation)
                        ->order_by('id_sous_projet_localisation')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }

}
