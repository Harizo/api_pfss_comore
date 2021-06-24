<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicateur_model extends CI_Model
{
    protected $table = 'indicateur';


    public function add($indicateur)
    {
        $this->db->set($this->_set($indicateur))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $indicateur)
    {
        $this->db->set($this->_set($indicateur))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($indicateur)
    {
        return array(
            'code'    =>      $indicateur['code'],
            'libelle' =>      $indicateur['libelle'],
            'frequence' =>      $indicateur['frequence'],
            'utilisation' =>      $indicateur['utilisation'],
            'unite' =>      $indicateur['unite'],
            'id_composante_indicateur' =>      $indicateur['id_composante_indicateur']                      
        );
    }

    public function add_down($indicateur, $id)  {
        $this->db->set($this->_set_down($indicateur, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($indicateur, $id)
    {
        return array(
            'code'    =>      $indicateur['code'],
            'libelle' =>      $indicateur['libelle'],
            'frequence' =>      $indicateur['frequence'],
            'utilisation' =>      $indicateur['utilisation'],
            'unite' =>      $indicateur['unite'],
            'id_composante_indicateur' =>      $indicateur['id_composante_indicateur']  
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
                        ->order_by('code')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    public function getindicateurbycomposante($id_composante_indicateur)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_composante_indicateur',$id_composante_indicateur)
                        ->order_by('code')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    public function findById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return array();
    }

}
