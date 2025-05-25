<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // //creating permission for users
        // Permission::create(['guard_name'=>'admin','name'=>'user-index','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-create','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-update','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-delete','group_name'=>'User Permissions']);

        // //creating permission for users
        // Permission::create(['guard_name'=>'admin','name'=>'instructor-index','group_name'=>'Instructor Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'instructor-create','group_name'=>'Instructor Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'instructor-update','group_name'=>'Instructor Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'instructor-delete','group_name'=>'Instructor Permissions']);

        // //permission for role
        // Permission::create(['guard_name'=>'admin','name'=>'admin-role-permission-index','group_name'=>'Admin Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'admin-role-permission-create','group_name'=>'Admin Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'admin-role-permission-update','group_name'=>'Admin Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'admin-role-permission-delete','group_name'=>'Admin Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'admin-specific-permission-create','group_name'=>'Admin Roles And Permissions']);

        // //permission for language
        // Permission::create(['guard_name'=>'admin','name'=>'language-index','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-create','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-update','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-delete','group_name'=>'Language Permissions']);

        // //backend language permission
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-generate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-translate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-update','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-index','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-api-accesskey','group_name'=>'Backend Language Permissions']);

        // //backend settings permission
        // Permission::create(['guard_name'=>'admin','name'=>'maintenance-mode-index','group_name'=>'Settings Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-translate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-update','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-index','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-api-accesskey','group_name'=>'Backend Language Permissions']);

        // //backend settings permission
        // Permission::create(['guard_name'=>'admin','name'=>'course-category-index','group_name'=>'Course Category']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-category-create','group_name'=>'Course Category']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-category-update','group_name'=>'Course Category']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-category-delete','group_name'=>'Course Category']);

        // //backend settings permission
        // Permission::create(['guard_name'=>'admin','name'=>'course-subcategory-index','group_name'=>'Course Sub-Category']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-subcategory-create','group_name'=>'Course Sub-Category']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-subcategory-update','group_name'=>'Course Sub-Category']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-subcategory-delete','group_name'=>'Course Sub-Category']);

        // //backend settings permission
        // Permission::create(['guard_name'=>'admin','name'=>'course-index','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-create','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-update','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-delete','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-cuppon-apply','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-cuppun-remove','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-batch-create','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-batch-update','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-batch-delete','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-video-create','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-video-update','group_name'=>'Course']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-video-delete','group_name'=>'Course']);

        // Permission::create(['guard_name'=>'admin','name'=>'course-coupon-index','group_name'=>'Course Coupon']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-coupon-create','group_name'=>'Course Coupon']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-coupon-update','group_name'=>'Course Coupon']);
        // Permission::create(['guard_name'=>'admin','name'=>'course-coupon-delete','group_name'=>'Course Coupon']);

        // Permission::create(['guard_name'=>'admin','name'=>'purchase-history-index','group_name'=>'Purchase History']);
        // Permission::create(['guard_name'=>'admin','name'=>'purchase-history-create','group_name'=>'Purchase History']);
        // Permission::create(['guard_name'=>'admin','name'=>'purchase-history-update','group_name'=>'Purchase History']);
        // Permission::create(['guard_name'=>'admin','name'=>'purchase-history-delete','group_name'=>'Purchase History']);


        // Permission::create(['guard_name'=>'admin','name'=>'logo-index','group_name'=>'Logos']);
        // Permission::create(['guard_name'=>'admin','name'=>'logo-create','group_name'=>'Logos']);
        // Permission::create(['guard_name'=>'admin','name'=>'logo-update','group_name'=>'Logos']);
        // Permission::create(['guard_name'=>'admin','name'=>'logo-delete','group_name'=>'Logos']);

        // Permission::create(['guard_name'=>'admin','name'=>'homepage-slider-index','group_name'=>'Homepage Sliders']);
        // Permission::create(['guard_name'=>'admin','name'=>'homepage-slider-create','group_name'=>'Homepage Sliders']);
        // Permission::create(['guard_name'=>'admin','name'=>'homepage-slider-update','group_name'=>'Homepage Sliders']);
        // Permission::create(['guard_name'=>'admin','name'=>'homepage-slider-delete','group_name'=>'Homepage Sliders']);

        // Permission::create(['guard_name'=>'admin','name'=>'other-content-index','group_name'=>'Homepage Other Contents']);
        // Permission::create(['guard_name'=>'admin','name'=>'other-content-update','group_name'=>'Homepage Other Contents']);

        // Permission::create(['guard_name'=>'admin','name'=>'comments-index','group_name'=>'Homepage Comments']);
        // Permission::create(['guard_name'=>'admin','name'=>'comments-update','group_name'=>'Homepage Comments']);
        // Permission::create(['guard_name'=>'admin','name'=>'comments-store','group_name'=>'Homepage Comments']);
        // Permission::create(['guard_name'=>'admin','name'=>'comments-delete','group_name'=>'Homepage Comments']);


    }
}
