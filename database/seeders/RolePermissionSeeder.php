<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Permission List as array
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                ]
            ],
            [
                'group_name' => 'user',
                'permissions' => [
                    // user Permissions
                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                    'user.approve',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ]
            ],
            [
                'group_name' => 'profile',
                'permissions' => [
                    // profile Permissions
                    'profile.view',
                    'profile.edit',
                    'profile.delete',
                    'profile.update',
                ]
            ],
            [
                'group_name' => 'category',
                'permissions' => [
                    // category Permissions
                    'category.create',
                    'category.view',
                    'category.edit',
                    'category.delete',
                ]
            ],
            [
                'group_name' => 'student',
                'permissions' => [
                    // category Permissions
                    'student.create',
                    'student.view',
                    'student.edit',
                    'student.delete',
                ]
            ],
            [
                'group_name' => 'studentClass',
                'permissions' => [
                    // studentClass Permissions
                    'studentClass.create',
                    'studentClass.view',
                    'studentClass.edit',
                    'studentClass.delete',
                ]
            ],
            [
                'group_name' => 'admissionFee',
                'permissions' => [
                    // admissionFee Permissions
                    'admissionFee.create',
                    'admissionFee.view',
                    'admissionFee.edit',
                    'admissionFee.delete',
                ]
            ],
            [
                'group_name' => 'admissionPayment',
                'permissions' => [
                    // admissionPayment Permissions
                    'admissionPayment.create',
                    'admissionPayment.view',
                    'admissionPayment.edit',
                    'admissionPayment.delete',
                ]
            ],
            [
                'group_name' => 'monthlyFee',
                'permissions' => [
                    // monthlyFee Permissions
                    'monthlyFee.create',
                    'monthlyFee.view',
                    'monthlyFee.edit',
                    'monthlyFee.delete',
                ]
            ],
            [
                'group_name' => 'monthlyFeeStudent',
                'permissions' => [
                    // monthlyFeeStudent Permissions
                    'monthlyFeeStudent.create',
                    'monthlyFeeStudent.view',
                    'monthlyFeeStudent.edit',
                    'monthlyFeeStudent.delete',
                ]
            ],
            [
                'group_name' => 'monthlyFeePaymentStudent',
                'permissions' => [
                    // monthlyFeePaymentStudent Permissions
                    'monthlyFeePaymentStudent.create',
                    'monthlyFeePaymentStudent.view',
                    'monthlyFeePaymentStudent.edit',
                    'monthlyFeePaymentStudent.delete',
                ]
            ],
            [
                'group_name' => 'stationaryFee',
                'permissions' => [
                    // stationaryFee Permissions
                    'stationaryFee.create',
                    'stationaryFee.view',
                    'stationaryFee.edit',
                    'stationaryFee.delete',
                ]
            ],
            [
                'group_name' => 'stationaryFeeBuy',
                'permissions' => [
                    // stationaryFeeBuy Permissions
                    'stationaryFeeBuy.create',
                    'stationaryFeeBuy.view',
                    'stationaryFeeBuy.edit',
                    'stationaryFeeBuy.delete',
                ]
            ],
            // [
            //     'group_name' => 'subCategory',
            //     'permissions' => [
            //         // subCategory Permissions
            //         'subCategory.create',
            //         'subCategory.view',
            //         'subCategory.edit',
            //         'subCategory.delete',
            //     ]
            // ],
            // [
            //     'group_name' => 'product',
            //     'permissions' => [
            //         // product Permissions
            //         'product.create',
            //         'product.view',
            //         'product.edit',
            //         'product.delete',
            //     ]
            // ],
            // [
            //     'group_name' => 'transaction',
            //     'permissions' => [
            //         // transaction Permissions
            //         'transaction.view',
            //     ]
            // ],
        ];

        $roleSuperAdmin = Role::create(['name' => 'superadmin']);


        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {                
                $permission = Permission::create(
                        [
                            'name' => $permissions[$i]['permissions'][$j],
                            'group_name' => $permissionGroup,
                        ]
                    );
                    $roleSuperAdmin->givePermissionTo($permission);
                    $permission->assignRole($roleSuperAdmin);
                
            }
        }
        $user = User::where('email', 'admin@gmail.com')->first();
        if($user){
            $user->assignRole($roleSuperAdmin);
        }
    }
}