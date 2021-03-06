<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Individu_model extends CI_Model
{
    protected $table = 'individu';


    public function add($individu)
    {
        $this->db->set($this->_set($individu))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $individu)
    {
        $this->db->set($this->_set($individu))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($individu)
    {
        return array(
            'id_serveur_centrale'  =>      $individu['id_serveur_centrale'],
            'menage_id'            =>      $individu['menage_id'],
            'nom'                  =>      $individu['nom'],                      
            'prenom'               =>      $individu['prenom'],                      
            'date_naissance'       =>      $individu['date_naissance'],                      
            'activite'             =>      $individu['activite'],                      
            'travailleur'          =>      $individu['travailleur'],                      
            'sexe'                 =>      $individu['sexe'],
            'lienparental'         =>      $individu['lienparental'],                   
            'a_ete_modifie'        =>      $individu['a_ete_modifie'],                   
            'scolarise'            =>      $individu['scolarise'],                   
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
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    public function findAllByMenage($menage_id)
    {
       $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id')
                        ->where("menage_id", $menage_id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
	 public function findByMenage($menage_id) {
		$requete="select ind.id_serveur_centrale,ind.menage_id,concat_ws(' ',ind.prenom,ind.nom) as nom,DATE_FORMAT(ind.date_naissance, '%d/%m/%Y') as date_naissance,"
				." floor((datediff(now(),IFNULL(ind.date_naissance, now())) / 365)) as age,"
				." ind.activite,ind.aptitude,ind.lienparental,ind.travailleur,ind.scolarise,ind.sexe,lp.description as liendeparente"
				." from individu as ind"
				." left outer join liendeparente as lp on lp.id=ind.lienparental"
				." where (ind.nom>'' or ind.prenom >'') and "
				." lower(lp.description) in('fils','fille','enfant') and ind.menage_id =".$menage_id;
				$result = $this->db->query($requete)->result();
        if($result) {
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
