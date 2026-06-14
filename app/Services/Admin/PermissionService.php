<?php

namespace App\Services\Admin;

use App\Enums\AdminRole;
use App\Enums\AuthGuard;
use App\Models\Admin;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{
    private string $guard = AuthGuard::Admins->value;
    public function authorizeSuperAdmin(): void{
        if (! auth(AuthGuard::Admins->value)->user()?->hasRole(AdminRole::SuperAdmin->value)) {
            throw new AuthorizationException('Access denied.');
        }
    }
    public function ensureDefaults(): void{
        app(RolesAndPermissionsSeeder::class)->run();
    }
    public function getAdmins(): Collection{
        return Admin::with(['roles', 'permissions'])->get();
    }
    public function getAdmin(Admin $admin): Admin{
        return $admin->load(['roles', 'permissions']);
    }
    public function getRoles(): Collection{
        return Role::where('guard_name', $this->guard)->get();
    }
    public function getPermissions(): Collection{
        return Permission::where('guard_name', $this->guard)->get();
    }
    public function sync(Admin $admin, array $data): void{
        $admin->syncRoles($data['roles'] ?? []);
        $admin->syncPermissions($data['permissions'] ?? []);
    }
}
