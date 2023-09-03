<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->removeAdmin();
        $this->storeAdmin();

    }

    public function storeAdmin()
    {
        $admin = new Admin();
        $admin->id = 1;
        $admin->name = "e-book super admin";
        $admin->email = "hala.n.nofal@gmail.com";
        $admin->password = "Hala123!@#";

        $result = $admin->save();
        if ($admin) {
            $admin->syncRoles(Role::findById(1, 'admin'));
        }
    }

    public function removeAdmin()
    {
        $admin = Admin::where('id',1)->first();
        if (!(is_null($admin))) {
            $result = $admin->ForceDelete();

        }
    }
}
