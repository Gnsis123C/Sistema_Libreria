<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Login extends Seeder
{
    public function run()
    {
        $this->db->table('pagina')->insertBatch([
            [
                'idpagina'  => 1,
                'nombre'    => 'usuario',
                'estado'    => '1',
            ],
            [
                'idpagina'  => 2,
                'nombre'    => 'empresa',
                'estado'    => '1',
            ],
            [
                'idpagina'  => 3,
                'nombre'    => 'rol',
                'estado'    => '1',
            ]
        ]);

        $this->db->table('empresa')->insert([
            'idempresa'   => 1,
            'nombre'      => 'Gen&Car',
            'direccion'   => 'El Deseo, Santa Rosa #2',
            'logo'        => '/assets/img/logolibreria.jpg',
            'estado'      => '1',
        ]);

        $this->db->table('rol')->insert([
            'idrol'        => 1,
            'nombre'       => 'super_admin',
            'estado'       => '1',
        ]);

        $this->db->table('usuario')->insert([
            'idusuario'  => 1,
            'idempresa'  => 1,
            'idrol'      => 1,
            'usuario'    => "admin_genesis",
            'nombre'     => "Génesis",
            'email'      => "gquintanam@unemi.edu.ec",
            'pass'       => password_hash("admin2025", PASSWORD_BCRYPT)
        ]);
    }
}
