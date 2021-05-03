<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Communaute_model extends CI_Model
{
    protected $table = 'communaute';


    public function add($communaute)
    {
        $this->db->set($this->_set($communaute))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update_statu($id, $communaute)
    {
        $this->db->set($this->_set_statu($communaute))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function update($id, $communaute)
    {
        $this->db->set($this->_set($communaute))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }


    public function _set($communaute)
    {
        return array(
            'code'    =>      $communaute['code'],
            'libelle' =>      $communaute['libelle'],
            'nbr_population' => $communaute['nbr_population'],
            //'representant' => $communaute['representant'],
            //'telephone' => $communaute['telephone'],
            //'statut' => $communaute['statut'],
            'id_zip' =>      $communaute['id_zip'],
            'id_commune' =>      $communaute['id_commune']                      
        );
    }

    public function _set_statu($communaute)
    {
        return array(
            'statut' => $communaute['statut']
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

    /*public function getcommunautebeneficiaire()
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('statut',"BENEFICIAIRE")
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
    public function getcommunauteinscrit()
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('statut',"INSCRIT")
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

    public function getcommunautepreselection()
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('statut',"PRESELECTIONNE")
                        ->order_by('code')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

    public function getcommunautebycommune($id_commune)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_commune',$id_commune)
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
