<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);
        $createBlogPermission = Permission::create(['name' => 'Create Blog']);
        $updateBlogPermission = Permission::create(['name' => 'Update Blog']);
        $deleteBlogPermission = Permission::create(['name' => 'Delete Blog']);
        $createRoleAndPermission = Permission::create(['name' => 'Create Role And Permission']);
        $updateRoleAndPermission = Permission::create(['name' => 'Update Role And Permission']);
        $deleteRoleAndPermission = Permission::create(['name' => 'Delete Role And Permission']);
        $createCategory = Permission::create(['name' => 'Create Category']);
        $updateCategory = Permission::create(['name' => 'Update Category']);
        $deleteCategory = Permission::create(['name' => 'Delete Category']);
        $createProject = Permission::create(['name' => 'Create Project']);
        $updateProject = Permission::create(['name' => 'Update Project']);
        $deleteProject = Permission::create(['name' => 'Delete Project']);
        $super->givePermissionTo([$createBlogPermission, $updateBlogPermission, $deleteBlogPermission, $createRoleAndPermission, $updateRoleAndPermission, $deleteRoleAndPermission,$createCategory,$updateCategory,$deleteCategory,$createProject,$updateProject,$deleteProject]);
        $admin->givePermissionTo([$createBlogPermission, $updateBlogPermission, $deleteBlogPermission,$createCategory,$updateCategory,$deleteCategory,$createProject,$updateProject,$deleteProject]);
        $editor->givePermissionTo([$updateBlogPermission,$updateProject,$createBlogPermission]);
    }
}
