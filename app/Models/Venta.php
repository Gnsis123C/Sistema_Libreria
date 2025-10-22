<?php

namespace App\Models;

use CodeIgniter\Model;

class Venta extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'venta';
    protected $primaryKey       = 'idventa';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['idventa','idpersona','idusuario','fecha','estado','numero_factura','precio_total','created_at','updated_at'];

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

    public function getSumVenta($idventa){
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_venta');

            // Calculamos total sin IVA y con IVA
            $builder->select("
                count(*) AS productos,
                SUM(precio_venta * cantidad) AS total_sin_iva,
                SUM((precio_venta * cantidad) * (1 + (iva / 100))) AS total_con_iva
            ");
            $builder->where('idventa', $idventa);

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

    public function ventasDelMes()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_venta');
            $builder->select('
            SUM(detalle_venta.cantidad * detalle_venta.precio_venta) AS total_ventas
        ');
            $builder->join('venta', 'venta.idventa = detalle_venta.idventa');
            $builder->where('venta.estado', 1);
            $builder->where('venta.deleted_at', null);

            // 🔹 Filtrar por el mes y año actual
            $builder->where('MONTH(venta.fecha)', date('m'));
            $builder->where('YEAR(venta.fecha)', date('Y'));

            $query = $builder->get();

            if ($query->getNumRows() == 0 || !$query->getRow()->total_ventas) {
                return [
                    'resp'  => false,
                    'error' => "No existen ventas registradas este mes"
                ];
            }

            return [
                'resp'  => true,
                'data'  => [
                    'mes' => date('F Y'),
                    'total_ventas' => (float) $query->getRow()->total_ventas
                ]
            ];
        } catch (\Exception $e) {
            return [
                'resp'  => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function totalVentas()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_venta');
            $builder->select('
            SUM(detalle_venta.cantidad * detalle_venta.precio_venta) AS total_gastado
        ');
            $builder->join('venta', 'venta.idventa = detalle_venta.idventa');
            $builder->where('venta.estado', 1);
            $builder->where('venta.deleted_at', null);

            $query = $builder->get();

            if ($query->getNumRows() == 0 || !$query->getRow()->total_gastado) {
                return [
                    'resp'  => false,
                    'error' => "No existen ventas registradas"
                ];
            }

            return [
                'resp'  => true,
                'data'  => [
                    'total_vendido' => (float) $query->getRow()->total_gastado
                ]
            ];
        } catch (\Exception $e) {
            return [
                'resp'  => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function totalProductosVentas()
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_venta');
            $builder->select('
            SUM(detalle_venta.cantidad) AS total_productos
        ');
            $builder->join('venta', 'venta.idventa = detalle_venta.idventa');
            $builder->where('venta.estado', 1);
            $builder->where('venta.deleted_at', null);

            $query = $builder->get();

            if ($query->getNumRows() == 0 || !$query->getRow()->total_productos) {
                return [
                    'resp'  => false,
                    'error' => "No existen productos ventados"
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

    public function getVentaProducto($idventa) {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('detalle_venta');
            $builder->select('detalle_venta.*, venta.fecha as fecha, venta.estado as estado_venta, producto.nom_producto');
            $builder->join('venta', 'venta.idventa = detalle_venta.idventa');
            $builder->join('producto', 'producto.idproducto = detalle_venta.idproducto');
            $builder->where('venta.idventa', $idventa);
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
