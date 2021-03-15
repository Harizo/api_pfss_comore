<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Composante_indicateur_model extends CI_Model
{
    protected $table = 'composante_indicateur';


    public function add($composante_indicateur)
    {
        $this->db->set($this->_set($composante_indicateur))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $composante_indicateur)
    {
        $this->db->set($this->_set($composante_indicateur))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($composante_indicateur)
    {
        return array(
            'code'    =>      $composante_indicateur['code'],
            'libelle' =>      $composante_indicateur['libelle'],
            'id_type_indicateur' =>      $composante_indicateur['id_type_indicateur']                      
        );
    }

    public function add_down($composante_indicateur, $id)  {
        $this->db->set($this->_set_down($composante_indicateur, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($composante_indicateur, $id)
    {
        return array(
            'id' => $id,
            'code' => $composante_indicateur['code'],
            'libelle' => $composante_indicateur['libelle'],
            'id_type_indicateur' =>      $composante_indicateur['id_type_indicateur'] 
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
            return null;
        }                 
    }

    public function getcomposante_indicateurbytype($id_type_indicateur)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_type_indicateur',$id_type_indicateur)
                        ->order_by('code')
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
