<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Depense_agex_model extends CI_Model {
    protected $table = 'depense_agex';

    public function add($depense_agex)  {
        $this->db->set($this->_set($depense_agex))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $depense_agex)  {
        $this->db->set($this->_set($depense_agex))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($depense_agex) 
    {
        return array
        (
            'id_contrat_ugp_agex' => $depense_agex['id_contrat_ugp_agex'],
            'date'       => $depense_agex['date'],
            'objet_depense'     => $depense_agex['objet_depense'],
            'montant_categ_un'     => $depense_agex['montant_categ_un'],
            'montant_categ_deux'     => $depense_agex['montant_categ_deux']
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
                        ->order_by('id', 'asc')
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