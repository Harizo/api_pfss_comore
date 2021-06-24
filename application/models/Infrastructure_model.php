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
            'code_numero'                      =>      $infrastructure['code_numero'],
            'code_passation'                   =>      $infrastructure['code_passation'],
            'libelle'                   =>      $infrastructure['libelle'],
            'id_type_infrastructure'    =>      $infrastructure['id_type_infrastructure'] ,
            'id_village'             =>      $infrastructure['id_village'] ,
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
            'code_numero'                      =>      $infrastructure['code_numero'],
            'code_passation'                   =>      $infrastructure['code_passation'],
            'libelle'                   =>      $infrastructure['libelle'],
            'id_type_infrastructure'    =>      $infrastructure['id_type_infrastructure'] ,
            'id_village'             =>      $infrastructure['id_village'] ,
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
                        ->order_by('code_numero')
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
                        ->order_by('code_numero')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getinfrastructurebyvillageandchoisi($id_village)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_village',$id_village)
                        ->where('statu','CHOISI')
                        ->order_by('code_numero')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getinfrastructurebyvillageandeligible($id_village)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_village',$id_village)
                        ->where('statu','ELIGIBLE')
                        ->order_by('code_numero')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getinfrastructurebyvillage($id_village)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_village',$id_village)
                        //->where('statu','ELIGIBLE')
                        ->order_by('code_numero')
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

    public function findByIdwithtype($id)
    {
        $this->db->select("infrastructure.*,type_infrastructure.code as code_type,type_infrastructure.libelle as libelle_type")
                ->join('type_infrastructure','type_infrastructure.id=infrastructure.id_type_infrastructure')
                ->where("infrastructure.id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    
    public function getinfrastructurebyvillageandchoisitype($id_village)
    {
        $result =  $this->db->select('infrastructure.*,type_infrastructure.code as code_type,type_infrastructure.libelle as libelle_type')
                        ->from($this->table)
                        ->join('type_infrastructure','type_infrastructure.id=infrastructure.id_type_infrastructure')
                        ->where('id_village',$id_village)
                        ->where('statu','CHOISI')
                        ->order_by('code_numero')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

}
