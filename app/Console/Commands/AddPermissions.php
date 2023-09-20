<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auth\PermissionGroup;
use App\Models\Auth\Permission;
use App\Models\Auth\User;
use App\Models\Auth\Role;
use App\Models\Auth\UserRole;

class AddPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->addPermission(['name' => 'roles-permissions', 'label' => 'Allow users to add roles and their permissions', 'opt_group' => 'Users & Rights']);
        $this->addPermission(['name' => 'manage-users', 'label' => 'Allow one to add/update user', 'opt_group' => 'Users & Rights']);
        $this->addPermission(['name' => 'users', 'label' => 'Allow to see all users', 'opt_group' => 'Users & Rights']);
        $this->addPermission(['name' => 'modify-user-password', 'label' => 'Allow one to update user password', 'opt_group' => 'Users & Rights']);

        $this->addPermission(['name' => 'roles', 'label' => 'Allow to see all roles', 'opt_group' => 'Users & Rights']);
        $this->addPermission(['name' => 'role-modify', 'label' => 'Allow to add/update role', 'opt_group' => 'Users & Rights']);


        $this->addPermission(['name' => 'file-openings', 'label' => 'Allow to see all file openings', 'opt_group' => 'Matters']);
        $this->addPermission(['name' => 'file-opening-modify', 'label' => 'Allow to add/update file opening', 'opt_group' => 'Matters']);

        $this->addPermission(['name' => 'real-estate-agent-list', 'label' => 'Allow to see all real-estate-agents', 'opt_group' => 'Masters']);
        $this->addPermission(['name' => 'real-estate-agent-modify', 'label' => 'Allow to add/update real-estate-agents', 'opt_group' => 'Masters']);

        $this->addPermission(['name' => 'employees-list', 'label' => 'Allow to see all solicitors', 'opt_group' => 'Masters']);
        $this->addPermission(['name' => 'employees-modify', 'label' => 'Allow to add/update solicitors', 'opt_group' => 'Masters']);
        $this->addPermission(['name' => 'employee-delete', 'label' => 'Allow to add/update solicitors', 'opt_group' => 'Masters']);

        $this->addPermission(['name' => 'cities-list', 'label' => 'Allow to see all cities list', 'opt_group' => 'Maintenance']);
        $this->addPermission(['name' => 'cities-modify', 'label' => 'Allow to add/update cities', 'opt_group' => 'Maintenance']);

        $this->addPermission(['name' => 'city-departments-list', 'label' => 'Allow to all see city departments', 'opt_group' => 'Maintenance']);
        $this->addPermission(['name' => 'city-departments-modify', 'label' => 'Allow to add/update city departmets', 'opt_group' => 'Maintenance']);


        $this->addPermission(['name' => 'contacts-list', 'label' => 'Allow to see all contacts list', 'opt_group' => 'Maintenance']);
        $this->addPermission(['name' => 'contacts-modify', 'label' => 'Allow to add/update contacts', 'opt_group' => 'Maintenance']);

        $this->addPermission(['name' => 'transaction-type-list', 'label' => 'Allow to see all transaction types list', 'opt_group' => 'Masters']);
        $this->addPermission(['name' => 'transaction-type-modify', 'label' => 'Allow to add/update transaction types', 'opt_group' => 'Masters']);


        $this->addPermission(['name' => 'brokerage-list', 'label' => 'Allow to see all brokerage list', 'opt_group' => 'Masters']);
        $this->addPermission(['name' => 'brokerage-modify', 'label' => 'Allow to add/update brokerage', 'opt_group' => 'Masters']);


        $this->addPermission(['name' => 'solicitor-list', 'label' => 'Allow to see all solicitor list', 'opt_group' => 'Masters']);
        $this->addPermission(['name' => 'solicitor-modify', 'label' => 'Allow to add/update solicitor', 'opt_group' => 'Masters']);

        $this->addPermission(['name' => 'law-firms-list', 'label' => 'Allow to see all law-firms list', 'opt_group' => 'Masters']);
        $this->addPermission(['name' => 'law-firms-modify', 'label' => 'Allow to add/update law-firms', 'opt_group' => 'Masters']);

        $this->addPermission(['name' => 'download-documents-list', 'label' => 'Allow to download documents', 'opt_group' => 'Download Documents']);


        $this->addPermission(['name' => 'make-payment', 'label' => 'Allow to make payment', 'opt_group' => 'Payment']);

        $this->addRole(['name' => 'Admin']);
        $this->addRole(['name' => 'Super Admin']);
        $this->addRole(['name' => 'Law Clerk']);

        $this->addUser(['name' => 'Infoway', 'email' => 'infowayit@infowayindia.com', 'email_verified_at' => today(), 'password' => bcrypt(123456)]);


        echo 'permissions saved' . PHP_EOL;
    }


    private function addPermission($permission)
    {
        $opt_group_id = 0;
        if (isset($permission['opt_group'])) {
            $g = PermissionGroup::updateOrCreate(['opt_group' => $permission['opt_group']]);
            $opt_group_id = $g->id;
        }

        $p = Permission::updateOrCreate(['name' => $permission['name']], $permission + ['opt_group_id' => $opt_group_id]);
    }

    private function addUser($user_data)
    {
        $user = User::where('email', $user_data['email'])->first();
        if (!$user) {
            $user = User::create($user_data);
        }
        $role = Role::where('name', 'Admin')->first();
        $user_role =  UserRole::updateOrCreate(['user_id' => $user['id'], 'role_id' => $role['id']]);
    }


    private function addRole($role)
    {
        $user = Role::updateOrCreate(['name' => $role['name']], $role);
    }
}
