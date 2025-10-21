<?php

namespace App\Models;

use CodeIgniter\Model;

class Compra extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'compra';
    protected $primaryKey       = 'idcompra';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['idcompra','idpersona','idusuario','fecha','estado','created_at','updated_at'];

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
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            return null;
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

    public function getSumCompra($idcompra){
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_compra');

            // Calculamos total sin IVA y con IVA
            $builder->select("
                count(*) AS productos,
                SUM(precio_compra * cantidad) AS total_sin_iva,
                SUM((precio_compra * cantidad) * (1 + (iva / 100))) AS total_con_iva
            ");
            $builder->where('idcompra', $idcompra);

            $query = $builder->get();
            $result = $query->getRowArray();

            return [
                'resp'  => true,
                'data'  => [
                    'total_sin_iva' => $result['total_sin_iva'] ?? 0,
                    'total_con_iva' => $result['total_con_iva'] ?? 0,
                    'productos' => $result['productos'] ?? 0,
                ]
            ];
        } catch (\Exception $e) {
            return [
                'resp'  => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function comprasDelMes()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_compra');
            $builder->select('
            SUM(detalle_compra.cantidad * detalle_compra.precio_compra) AS total_compras
        ');
            $builder->join('compra', 'compra.idcompra = detalle_compra.idcompra');
            $builder->where('compra.estado', 1);
            $builder->where('compra.deleted_at', null);

            // 🔹 Filtrar por el mes y año actual
            $builder->where('MONTH(compra.fecha)', date('m'));
            $builder->where('YEAR(compra.fecha)', date('Y'));

            $query = $builder->get();

            if ($query->getNumRows() == 0 || !$query->getRow()->total_compras) {
                return [
                    'resp'  => false,
                    'error' => "No existen compras registradas este mes"
                ];
            }

            return [
                'resp'  => true,
                'data'  => [
                    'mes' => date('F Y'),
                    'total_compras' => (float) $query->getRow()->total_compras
                ]
            ];
        } catch (\Exception $e) {
            return [
                'resp'  => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function totalComprado()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_compra');
            $builder->select('
            SUM(detalle_compra.cantidad * detalle_compra.precio_compra) AS total_gastado
        ');
            $builder->join('compra', 'compra.idcompra = detalle_compra.idcompra');
            $builder->where('compra.estado', 1);
            $builder->where('compra.deleted_at', null);

            $query = $builder->get();

            if ($query->getNumRows() == 0 || !$query->getRow()->total_gastado) {
                return [
                    'resp'  => false,
                    'error' => "No existen compras registradas"
                ];
            }

            return [
                'resp'  => true,
                'data'  => [
                    'total_comprado' => (float) $query->getRow()->total_gastado
                ]
            ];
        } catch (\Exception $e) {
            return [
                'resp'  => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function totalProductosComprados()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_compra');
            $builder->select('
            SUM(detalle_compra.cantidad) AS total_productos
        ');
            $builder->join('compra', 'compra.idcompra = detalle_compra.idcompra');
            $builder->where('compra.estado', 1);
            $builder->where('compra.deleted_at', null);

            $query = $builder->get();

            if ($query->getNumRows() == 0 || !$query->getRow()->total_productos) {
                return [
                    'resp'  => false,
                    'error' => "No existen productos comprados"
                ];
            }

            return [
                'resp'  => true,
                'data'  => [
                    'productos' => (int) $query->getRow()->total_productos
                ]
            ];
        } catch (\Exception $e) {
            return [
                'resp'  => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getCompraProducto($idcompra) {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_compra');
            $builder->select('detalle_compra.*, compra.fecha as fecha, compra.estado as estado_compra, producto.nom_producto');
            $builder->join('compra', 'compra.idcompra = detalle_compra.idcompra');
            $builder->join('producto', 'producto.idproducto = detalle_compra.idproducto');
            $builder->where('compra.idcompra', $idcompra);
            $query = $builder->get();
            $resp = $query->getResult('array') ?? [];
            return [
                'resp'  => true,
                'data'  => $resp
            ];
        } catch (\Exception $e) {
            return [
                'resp'  => false,
                'error' => $e->getMessage()
            ];
        }
    }

}
