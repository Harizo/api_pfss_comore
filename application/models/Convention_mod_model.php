<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_mod_model extends CI_Model
{
    protected $table = 'convention_mod';


    public function add($convention_mod)
    {
        $this->db->set($this->_set($convention_mod))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $convention_mod)
    {
        $this->db->set($this->_set($convention_mod))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($convention_mod)
    {
        return array(
            'deux_parti_concernee' => $convention_mod['deux_parti_concernee'],
            'objet' => $convention_mod['objet'],
            'montant_travaux' => $convention_mod['montant_travaux'],
            'nom_signataire' => $convention_mod['nom_signataire'],
            'date_signature' => $convention_mod['date_signature'],
            'date_prevu_recep' => $convention_mod['date_prevu_recep'],
            'id_sous_projet' =>      $convention_mod['id_sous_projet']                      
        );
    }

    public function add_down($convention_mod, $id)  {
        $this->db->set($this->_set_down($convention_mod, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($convention_mod, $id)
    {
        return array(
            'deux_parti_concernee' => $convention_mod['deux_parti_concernee'],
            'objet' => $convention_mod['objet'],
            'montant_travaux' => $convention_mod['montant_travaux'],
            'nom_signataire' => $convention_mod['nom_signataire'],
            'date_signature' => $convention_mod['date_signature'],
            'date_prevu_recep' => $convention_mod['date_prevu_recep'],
            'id_sous_projet' =>      $convention_mod['id_sous_projet'] 
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
    

    public function getconvention_modbysousprojet($id_sous_projet)
    {
        $result =  $this->db->select("*")
                        ->from($this->table)
                        ->where('id_sous_projet',$id_sous_projet)
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
