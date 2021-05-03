<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_entretien_model extends CI_Model
{
    protected $table = 'convention_entretien';


    public function add($convention_entretien)
    {
        $this->db->set($this->_set($convention_entretien))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $convention_entretien)
    {
        $this->db->set($this->_set($convention_entretien))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($convention_entretien)
    {
        return array(
            'deux_parti_concernee' => $convention_entretien['deux_parti_concernee'],
            'objet' => $convention_entretien['objet'],
            'montant_travaux' => $convention_entretien['montant_travaux'],
            'nom_signataire' => $convention_entretien['nom_signataire'],
            'date_signature' => $convention_entretien['date_signature'],
            'id_sous_projet_localisation' =>      $convention_entretien['id_sous_projet_localisation']                      
        );
    }

    public function add_down($convention_entretien, $id)  {
        $this->db->set($this->_set_down($convention_entretien, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($convention_entretien, $id)
    {
        return array(
            'deux_parti_concernee' => $convention_entretien['deux_parti_concernee'],
            'objet' => $convention_entretien['objet'],
            'montant_travaux' => $convention_entretien['montant_travaux'],
            'nom_signataire' => $convention_entretien['nom_signataire'],
            'date_signature' => $convention_entretien['date_signature'],
            'id_sous_projet_localisation' =>      $convention_entretien['id_sous_projet_localisation'] 
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
    

    public function getconvention_entretienbysousprojet_localisation($id_sous_projet_localisation)
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
