<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avenant_agep_model extends CI_Model {
    protected $table = 'avenant_agep';

    public function add($avenant_agep)  {
        $this->db->set($this->_set($avenant_agep))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $avenant_agep)  {
        $this->db->set($this->_set($avenant_agep))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avenant_agep) 
    {
        return array
        (
            'numero_avenant'    => $avenant_agep['numero_avenant'],
            //'id_agep'           => $avenant_agep['id_agep'],
            'id_contrat_agep'    => $avenant_agep['id_contrat_agep'],
            'objet_avenant'     => $avenant_agep['objet_avenant'],
            'montant_avenant'    => $avenant_agep['montant_avenant'],
            'modalite_avenant'  => $avenant_agep['modalite_avenant'],
            'date_signature'    => $avenant_agep['date_signature'],
            'date_prevu_fin'    => $avenant_agep['date_prevu_fin'],
            'noms_signataires'  => $avenant_agep['noms_signataires'],
            'statu'             => $avenant_agep['statu']
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
    public function getavenant_agepBycontrat($id_contrat_agep)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_agep", $id_contrat_agep)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    
    /*public function countAllById_contrat_agep_encours($id_contrat_agep)  {
        $result =  $this->db->select('COUNT(*) as nbr_avenant')
                        ->from($this->table)
                        ->where("id_contrat_agep", $id_contrat_agep)
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
    }*/
    /*public function getavenant_agepBysousprojet($id_contrat_agep)  {
        $requete= "select *,DATEDIFF(now(),DATE(date_signature)) as diff, now() as no from avenant_agep where id_contrat_agep='".$id_contrat_agep."'";
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