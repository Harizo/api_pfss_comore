<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_agep_model extends CI_Model {
    protected $table = 'contrat_agep';

    public function add($contrat_agep)  {
        $this->db->set($this->_set($contrat_agep))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $contrat_agep)  {
        $this->db->set($this->_set($contrat_agep))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_agep) 
    {
        return array
        (
            'numero_contrat'    => $contrat_agep['numero_contrat'],
            'id_agep'           => $contrat_agep['id_agep'],
            'id_sous_projet'    => $contrat_agep['id_sous_projet'],
            'objet_contrat'     => $contrat_agep['objet_contrat'],
            'montant_contrat'    => $contrat_agep['montant_contrat'],
            'montant_a_effectue_prevu'    => $contrat_agep['montant_a_effectue_prevu'],
            'modalite_contrat'  => $contrat_agep['modalite_contrat'],
            'date_signature'    => $contrat_agep['date_signature'],
            'date_prevu_fin'    => $contrat_agep['date_prevu_fin'],
            'noms_signataires'  => $contrat_agep['noms_signataires'],
            'statu'             => $contrat_agep['statu']
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
    public function getcontrat_agepBysousprojet($id_sous_projet)  {
        $result =  $this->db->select('*,DATEDIFF(date_prevu_fin,now()) as nbr_jour_restant')
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
    
    public function getallcontrat_alert()  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("statu",'EN COURS')                        
                        ->where("DATEDIFF(date_prevu_fin,now())<=",5)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function countAllById_sous_projet_encours($id_sous_projet)  {
        $result =  $this->db->select('COUNT(*) as nbr_contrat')
                        ->from($this->table)
                        ->where("id_sous_projet", $id_sous_projet)
                        ->where("statu",'EN COURS')                        
                        ->where("DATEDIFF(date_prevu_fin,now())<=",5)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    /*public function getcontrat_agepBysousprojet($id_sous_projet)  {
        $requete= "select *,DATEDIFF(now(),DATE(date_signature)) as diff, now() as no from contrat_agep where id_sous_projet='".$id_sous_projet."'";
		$query = $this->db->query($requete);
        $result= $query->result();				
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }*/
}
?>