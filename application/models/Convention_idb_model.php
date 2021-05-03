<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_idb_model extends CI_Model
{
    protected $table = 'convention_idb';


    public function add($convention_idb)
    {
        $this->db->set($this->_set($convention_idb))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $convention_idb)
    {
        $this->db->set($this->_set($convention_idb))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($convention_idb)
    {
        return array(
            'deux_parti_concernee' => $convention_idb['deux_parti_concernee'],
            'objet' => $convention_idb['objet'],
            'montant_financement' => $convention_idb['montant_financement'],
            'nom_signataire' => $convention_idb['nom_signataire'],
            'date_signature' => $convention_idb['date_signature'],
            'litige_conclusion' => $convention_idb['litige_conclusion'],
            'id_sous_projet_localisation' =>      $convention_idb['id_sous_projet_localisation']                      
        );
    }

    public function add_down($convention_idb, $id)  {
        $this->db->set($this->_set_down($convention_idb, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($convention_idb, $id)
    {
        return array(
            'deux_parti_concernee' => $convention_idb['deux_parti_concernee'],
            'objet' => $convention_idb['objet'],
            'montant_financement' => $convention_idb['montant_financement'],
            'nom_signataire' => $convention_idb['nom_signataire'],
            'date_signature' => $convention_idb['date_signature'],
            'litige_conclusion' => $convention_idb['litige_conclusion'],
            'id_sous_projet_localisation' =>      $convention_idb['id_sous_projet_localisation'] 
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
    

    public function getconvention_idbbysousprojet_localisation($id_sous_projet_localisation)
    {
        $result =  $this->db->select("*")
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
