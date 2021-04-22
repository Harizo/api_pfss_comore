<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infrastructure_model extends CI_Model
{
    protected $table = 'infrastructure';


    public function add($infrastructure)
    {
        $this->db->set($this->_set($infrastructure))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $infrastructure)
    {
        $this->db->set($this->_set($infrastructure))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($infrastructure)
    {
        return array(
            'code'                      =>      $infrastructure['code'],
            'libelle'                   =>      $infrastructure['libelle'],
            'id_type_infrastructure'    =>      $infrastructure['id_type_infrastructure'] ,
            'id_communaute'             =>      $infrastructure['id_communaute'] ,
            'statu'                     =>      $infrastructure['statu']                      
        );
    }

    public function add_down($infrastructure, $id)  {
        $this->db->set($this->_set_down($infrastructure, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($infrastructure, $id)
    {
        return array(
            'id' => $id,
            'code'                      =>      $infrastructure['code'],
            'libelle'                   =>      $infrastructure['libelle'],
            'id_type_infrastructure'    =>      $infrastructure['id_type_infrastructure'] ,
            'id_communaute'             =>      $infrastructure['id_communaute'] ,
            'statu'                     =>      $infrastructure['statu']
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

    public function getinfrastructurebytype($id_type_infrastructure)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_type_infrastructure',$id_type_infrastructure)
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

    public function getinfrastructurebycommunauteandchoisi($id_communaute)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_communaute',$id_communaute)
                        ->where('statu','CHOISI')
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

    public function getinfrastructurebycommunauteandeligible($id_communaute)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_communaute',$id_communaute)
                        ->where('statu','ELIGIBLE')
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
