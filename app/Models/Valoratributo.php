<?php

namespace App\Models;

use CodeIgniter\Model;

class Valoratributo extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'valoratributo';
    protected $primaryKey       = 'idvaloratributo';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['idvaloratributo','nombre','idatributo'];

    // Dates
    protected $updateDate = true;
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function existe($tabla, $name, $text) {
        try {
            $db = db_connect();
            $query = $db->query('SELECT * FROM '.$tabla.' WHERE '.$text.' = "'.$name.'"');
            return (count($query->getResult('array')) > 0) ? true : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function existe_editar($tabla, $idtabla, $id, $array=array()) {
        $db = db_connect();
        $tamanioList = count($array);
        $listar = (object) $array;
        $str = '';
        $i = 0;
        foreach ($listar as $key => $value) {
            $str .= '('.$key.'="'.$value.'")' . (($i + 1) == $tamanioList ? '' : ' and ');
            $i++;
        }
        $query = $db->query('select * from ' . $tabla . ' where ' . $idtabla . '!=' . $id . ' and ' . $str);
        return (count($query->getResult('array')) > 0) ? true : false;
    }

    public function countActive(){
        return $this->where('deleted_at', null)->countAllResults();
    }

    public function countDelete(){
        return $this->onlyDeleted()->countAllResults();
    }
}
