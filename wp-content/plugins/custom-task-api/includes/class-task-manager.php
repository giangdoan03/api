<?php

class Task_Manager {

    public static function create_task( $request ) {
        $title = sanitize_text_field($request->get_param('title'));
        $description = sanitize_textarea_field($request->get_param('description'));

        $task_id = wp_insert_post(array(
            'post_type' => 'task',
            'post_title' => $title,
            'post_content' => $description,
            'post_status' => 'publish',
        ));

        if (is_wp_error($task_id)) {
            return new WP_Error('task_creation_failed', 'Tạo công việc thất bại', array('status' => 500));
        }

        return array('task_id' => $task_id, 'message' => 'Công việc đã được tạo thành công');
    }

    public static function assign_task( $request ) {
        $task_id = absint($request->get_param('task_id'));
        $user_id = absint($request->get_param('user_id'));

        if (!get_post($task_id) || !get_userdata($user_id)) {
            return new WP_Error('invalid_input', 'ID công việc hoặc người dùng không hợp lệ', array('status' => 400));
        }

        update_post_meta($task_id, 'assigned_user', $user_id);

        return array('message' => 'Gán công việc thành công');
    }
}
