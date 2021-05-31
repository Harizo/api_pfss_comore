<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_rubrique_model extends CI_Model {
    protected $table = 'sous_rubrique';

    public function add($sous_rubrique)  {
        $this->db->set($this->_set($sous_rubrique))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $sous_rubrique)  {
        $this->db->set($this->_set($sous_rubrique))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($sous_rubrique) 
    {
        return array
        (
            'code' => $sous_rubrique['code'],
            'libelle'       => $sous_rubrique['libelle'],
            'montant'       => $sous_rubrique['montant']
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

    public function findAll() //Fonction pour la récupération de tous les enregistrement 
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('code')
                        ->get()
                        ->result();
        if($result) 
        {
            return $result;
        }
        else
        {
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

}
?>