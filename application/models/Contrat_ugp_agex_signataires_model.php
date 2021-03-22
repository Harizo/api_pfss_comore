<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_ugp_agex_signataires_model extends CI_Model {
    protected $table = 'contrat_ugp_agex_signataires';

    public function add($contrat_ugp_agex_signataires)  {
        $this->db->set($this->_set($contrat_ugp_agex_signataires))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $contrat_ugp_agex_signataires)  {
        $this->db->set($this->_set($contrat_ugp_agex_signataires))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_ugp_agex_signataires) 
    {
        return array
        (
            'id_contrat_ugp_agex' => $contrat_ugp_agex_signataires['id_contrat_ugp_agex'],
            'nom_signataire'       => $contrat_ugp_agex_signataires['nom_signataire'],
            'titre_signatire'     => $contrat_ugp_agex_signataires['titre_signatire']
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
    public function findByContrat_ugp_agex($id_contrat_ugp_agex)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_ugp_agex", $id_contrat_ugp_agex)
                        ->order_by('nom_signataire', 'asc')
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