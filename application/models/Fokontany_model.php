<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fokontany_model extends CI_Model {
    protected $table = 'fokontany';

    public function add($fokontany) {
        $this->db->set($this->_set($fokontany))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $fokontany) {
        $this->db->set($this->_set($fokontany))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fokontany) {
        return array(
            'code'           =>      $fokontany['code'],
            'nom'            =>      $fokontany['nom'],
            'id_commune'    =>       $fokontany['id_commune']                       
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('nom')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }    
	public function find_Fokontany_avec_Commune_et_District_et_Region($id=null) {
		$requete='select f.id,f.nom,f.code,f.id_commune,c.nom as commune,c.district_id,d.nom as district,d.region_id,r.nom as region
                from fokontany as f
                left outer join commune as c on c.id=f.id_commune
				left outer join district as d on d.id=c.district_id
				left outer join region as r on r.id=d.region_id '
				.($id !=null ? ' where f.id='.$id : '')
				.' order by f.nom,c.nom,d.nom,r.nom	';				
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return array();
        }  
	}
	public function find_Liste_Fokontany_avec_Commune_et_District_et_Region($id_commune=null) {
		$requete='select f.id,f.nom,f.code,f.id_commune,c.nom as commune,c.district_id,d.nom as district,d.region_id,r.nom as region
                from fokontany as f
                left outer join commune as c on c.id=f.id_commune
				left outer join district as d on d.id=c.district_id
				left outer join region as r on r.id=d.region_id '
				.($id_commune !=null ? ' where f.id_commune='.$id_commune : '')
				.' order by f.nom,c.nom,d.nom,r.nom ';				
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return array();
        }  
	}
    public function findAllByCommune($id_commune) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('nom')
                        ->where("id_commune", $id_commune)
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
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
            return array();
        }                 
    }	
    /*public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
		if(isset($id)) {
			$requete='select c.id,c.nom,c.code,c.district_id,d.nom as nomdistrict,r.nom as region,r.site_id,s.nom as nom_site
			from commune as c
			left outer join district as d on d.id=c.district_id
			left outer join region as r on r.id=d.region_id
			left outer join site as s on s.id=r.site_id where c.id='.$id
			.' order by r.site_id,c.nom,d.nom	';				
			$query= $this->db->query($requete);
			if($query->result())
			{
				return $query->row();
				// return $result;
			}else{
				return null;
			}   
		} else {
			return null;
		}	
    }*/
}
