<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gestion_financiere_model extends CI_Model {
    protected $table = 'gestion_financiere';

    public function add($gestion_financiere)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($gestion_financiere))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $gestion_financiere)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($gestion_financiere))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($gestion_financiere) {
		// Affectation des valeurs
        return array(
            'date'                  => $gestion_financiere['date'],
            'id_composante'         => $gestion_financiere['id_composante'],
            'id_sous_projet'        => $gestion_financiere['id_sous_projet'],
            'id_village'            => $gestion_financiere['id_village'],
            'montant_engage'        => $gestion_financiere['montant_engage'],
            'montant_paye'          => $gestion_financiere['montant_paye']
       );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('date')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAll_detail($date_debut, $date_fin)
    {


       

        $sql = 
        "
            select
                gf.id as id,
                gf.date ,
                
                gf.id_composante,
                cmp.code AS code_composante,
                cmp.libelle AS libelle_composante,
                
                gf.id_sous_projet,
                sp.code AS code_sous_projet,
                
                gf.id_village,
                sv.Village ,
                
                sc.id AS id_commune,
                sc.Commune,
                
                sr.id AS id_region,
                sr.Region,
                
                si.id AS id_ile,
                si.Ile,
                
                
                gf.montant_engage,
                gf.montant_paye
            FROM
                gestion_financiere AS gf,
                composante_pfss AS cmp,
                sous_projet AS sp,
                see_village AS sv,
                see_commune AS sc,
                see_region AS sr,
                see_ile AS si
            WHERE 
                gf.id_composante = cmp.id
                AND gf.id_sous_projet = sp.id
                AND gf.id_village = sv.id
                AND sv.commune_id = sc.id
                AND sc.region_id = sr.id
                AND sr.ile_id = si.id 
                AND gf.date BETWEEN '".$date_debut."' AND '".$date_fin."'
            ORDER BY gf.date
    
                
        ";
        return $this->db->query($sql)->result(); 
    }

    public function situtation_composante($date_debut, $date_fin)
    {
        $sql = 
        '
            select
                cp.CODE AS '."'Composante'".',
                cp.montant_prevu AS '."'Montant prévu (KMF)'".',
                
                SUM(gf.montant_engage) AS '."'Cumule des engagement (KMF)'".',
                ROUND(((SUM(gf.montant_engage) * 100)/cp.montant_prevu),2) AS '."'Taux d\'engagement (%)'".',
                
                SUM(gf.montant_paye) AS '."'Cumule des paiement (KMF)'".',
                ROUND(((SUM(gf.montant_paye) * 100)/cp.montant_prevu),2) AS '."'Taux de décaissement (%)'".'
                
            FROM 
                gestion_financiere AS gf,
                see_village AS sv,
                composante_pfss AS cp
            WHERE 
                gf.id_village = sv.id
                AND gf.id_composante = cp.id
                AND gf.date BETWEEN "'.$date_debut.'" AND "'.$date_fin.'"
            GROUP BY cp.id

        ';


        return $this->db->query($sql)->result(); 
    }

    public function situtation_activite($date_debut, $date_fin, $id_village)
    {
        $sql = 
        '
            select
                sp.CODE AS Activité,
                sp.montant AS '."'Montant prévu (KMF)'".',
                
                SUM(gf.montant_engage) AS '."'Cumule des engagement (KMF)'".',
                ROUND(((SUM(gf.montant_engage) * 100)/sp.montant),2) AS '."'Taux d\'engagement (%)'".',
                
                SUM(gf.montant_paye) AS '."'Cumule des paiement (KMF)'".',
                ROUND(((SUM(gf.montant_paye) * 100)/sp.montant),2) AS '."'Taux de décaissement (%)'".'
                
            FROM 
                gestion_financiere AS gf,
                see_village AS sv,
                sous_projet AS sp
            WHERE 
                gf.id_village = sv.id
                AND gf.id_sous_projet = sp.id
                AND gf.date BETWEEN "'.$date_debut.'" AND "'.$date_fin.'"
                AND sv.id = '.$id_village.'
            GROUP BY sp.id

        ';


        return $this->db->query($sql)->result(); 
    }

}
?>