<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Login extends Seeder
{
    public function run()
    {
        $this->db->table('rol')->insert([
            'idrol'        => 1,
            'nombre'       => 'super_admin'
        ]);

        $this->db->table('empresa')->insert([
            'idempresa'     => 1,
            'nombre'        => 'admin'
        ]);

        $this->db->table('usuario')->insert([
            'idempresa'        => 1,
            'idrol'        => 1,
            'usuario'        => "super_admin",
            'email'        => "gquintanam@unemi.edu.ec",
            'pass'        => password_hash("admin2025", PASSWORD_BCRYPT)
        ]);
    }
}
