<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_ugp_agex_model extends CI_Model {
    protected $table = 'contrat_ugp_agex';

    public function add($contrat_ugp_agex)  {
        $this->db->set($this->_set($contrat_ugp_agex))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $contrat_ugp_agex)  {
        $this->db->set($this->_set($contrat_ugp_agex))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_ugp_agex) 
    {
        return array
        (
            'numero_contrat'            => $contrat_ugp_agex['numero_contrat'],
            'id_agex'                   => $contrat_ugp_agex['id_agex'],
            'id_sous_projet'            => $contrat_ugp_agex['id_sous_projet'],
            'objet_contrat'             => $contrat_ugp_agex['objet_contrat'],
            'montant_contrat'           => $contrat_ugp_agex['montant_contrat'],
            'date_signature'            => $contrat_ugp_agex['date_signature'],
            'date_prevu_fin_contrat'    => $contrat_ugp_agex['date_prevu_fin_contrat'],
            'status_contrat'            => $contrat_ugp_agex['status_contrat'],
            'note_resiliation'          => $contrat_ugp_agex['note_resiliation'],
            'etat_validation'           => $contrat_ugp_agex['etat_validation']
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
    public function findAll() 
    {
        $sql = 
        "
            select 
                cua.id AS id,
                cua.numero_contrat AS numero_contrat,
                
                cua.id_agex AS id_agex, 
                a.Nom AS nom_agex,
                a.intervenant_agex AS intervenant_agex,
                a.nom_contact_agex AS nom_contact_agex,
                a.numero_phone_contact AS numero_phone_contact,
                a.adresse_agex AS adresse_agex,
                
                cua.id_sous_projet AS  id_sous_projet,
                sp.description AS description_sous_projet,
                
                
                cua.objet_contrat AS objet_contrat,
                cua.montant_contrat AS montant_contrat,
                cua.date_signature AS date_signature,
                cua.date_prevu_fin_contrat AS date_prevu_fin_contrat,
                cua.status_contrat as status_contrat,
                cua.note_resiliation as note_resiliation,
                cua.etat_validation AS etat_validation
            FROM 
                contrat_ugp_agex AS cua,
                see_agex AS a,
                sous_projet AS sp
            WHERE 
                cua.id_agex = a.id
                AND cua.id_sous_projet = sp.id
        ";
        return $this->db->query($sql)->result();               
    }
    public function findById($id) {
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

    public function get_mdp_en_retard()
    {


        $now_date = date("Y-m-d") ;

       // $array = array('date_prevu_fin_contrat >=' => $now_date, 'date_prevu_fin_contrat <=' => $now_date);

        $sql = 
        "
            select 
                
                cua.numero_contrat,
                cua.date_prevu_fin_contrat
            FROM 
                contrat_ugp_agex as cua
            WHERE 
                cua.date_prevu_fin_contrat < '".$now_date."'
                and cua.status_contrat = 'En cours'
                
        ";
        return $this->db->query($sql)->result(); 
    }
    
    public function findById_sous_projet($id_sous_projet)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_sous_projet", $id_sous_projet)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function findByIdobjet($id) {		
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
}
?>