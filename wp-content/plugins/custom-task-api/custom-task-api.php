<?php
/*
Plugin Name: Custom Task API
Description: Plugin tạo API dựa trên JWT để đăng nhập, đăng xuất, lấy thông tin người dùng, tạo công việc và gán công việc.
Version: 1.0
Author: Giang Đoàn
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-jwt-handler.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-task-manager.php';
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

class Custom_Task_API {

    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
        add_action('init', array($this, 'register_task_post_type')); // Đăng ký post type tại đây
    }

    public function register_routes() {
        // Đăng ký route đăng nhập
        register_rest_route('custom-task-api/v1', '/login', array(
            'methods' => 'POST',
            'callback' => array('JWT_Handler', 'handle_login'),
        ));

        // Đăng ký route đăng xuất
        register_rest_route('custom-task-api/v1', '/logout', array(
            'methods' => 'POST',
            'callback' => array('JWT_Handler', 'handle_logout'),
        ));

        // Đăng ký route lấy thông tin người dùng
        register_rest_route('custom-task-api/v1', '/user-info', array(
            'methods' => 'GET',
            'callback' => array('JWT_Handler', 'get_user_info'),
            'permission_callback' => array('JWT_Handler', 'validate_token'),
        ));

        // Đăng ký route tạo công việc
        register_rest_route('custom-task-api/v1', '/create-task', array(
            'methods' => 'POST',
            'callback' => array('Task_Manager', 'create_task'),
            'permission_callback' => array('JWT_Handler', 'validate_token'),
        ));

        // Đăng ký route gán công việc
        register_rest_route('custom-task-api/v1', '/assign-task', array(
            'methods' => 'POST',
            'callback' => array('Task_Manager', 'assign_task'),
            'permission_callback' => array('JWT_Handler', 'validate_token'),
        ));
    }

    public function register_task_post_type() {
        register_post_type('task', array(
            'labels' => array(
                'name' => 'Công việc',
                'singular_name' => 'Công việc',
                'menu_name' => 'Công việc',
                'all_items' => 'Tất cả công việc',
                'add_new' => 'Thêm công việc',
                'add_new_item' => 'Thêm mới công việc',
                'edit_item' => 'Chỉnh sửa công việc',
                'new_item' => 'Công việc mới',
                'view_item' => 'Xem công việc',
                'search_items' => 'Tìm kiếm công việc',
                'not_found' => 'Không tìm thấy',
                'not_found_in_trash' => 'Không tìm thấy trong thùng rác'
            ),
            'public' => true,
            'has_archive' => true,
            'show_ui' => true,  // Đảm bảo hiển thị trong trang quản trị
            'show_in_menu' => true,  // Hiển thị trong menu
            'supports' => array('title', 'editor'),
        ));
    }
}

new Custom_Task_API();
