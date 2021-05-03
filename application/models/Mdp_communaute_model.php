<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_communaute_model extends CI_Model {
    protected $table = 'mdp_communaute';

    public function add($mdp_communaute)  {
        $this->db->set($this->_set($mdp_communaute))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp_communaute)  {
        $this->db->set($this->_set($mdp_communaute))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp_communaute) 
    {
        return array
        (
            'id_mdp' => $mdp_communaute['id_mdp'],
            'id_communaute'       => $mdp_communaute['id_communaute'],
            'nbr_beneficiaire'       => $mdp_communaute['nbr_beneficiaire']
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

    public function findAll_by_mdp($id_mdp) 
    {
        $sql = 
        "
            select 

                mdpc.id as id,
                mdpc.id_mdp as id_mdp,

                mdpc.id_communaute as id_communaute,
                mdpc.nbr_beneficiaire as nbr_beneficiaire,

                c.code as code_communaute,
                c.libelle as libelle_communaute,

                c.id_commune as id_commune,
                sc.Commune as nom_commune,

                sr.id as id_region,
                sr.Region as nom_region

            FROM 
                mdp_communaute as mdpc,
                communaute as c,
                see_region as sr,
                see_commune as sc

            WHERE 
                mdpc.id_communaute = c.id
                and c.id_commune = sc.id 
                and sc.region_id = sr.id
                and mdpc.id_mdp = ".$id_mdp."
        ";
        return $this->db->query($sql)->result();               
    }

    public function findAll_communaute() 
    {
        $sql = 
        "
            select 

                c.id as id,
                c.code as code_communaute,
                c.libelle as libelle_communaute,

                c.id_commune as id_commune,
                sc.Commune as nom_commune,

                sr.id as id_region,
                sr.Region as nom_region

            FROM 
               
                communaute as c,
                see_region as sr,
                see_commune as sc

            WHERE 
             
               c.id_commune = sc.id 
                and sc.region_id = sr.id
        ";
        return $this->db->query($sql)->result();               
    }

   
}
?>