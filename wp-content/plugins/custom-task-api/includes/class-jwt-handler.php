<?php
use \Firebase\JWT\JWT;

class JWT_Handler {

    private static $secret_key = 'your_secret_key_here';

    public static function handle_login( $request ) {
        $username = sanitize_text_field($request->get_param('username'));
        $password = sanitize_text_field($request->get_param('password'));

        $user = wp_authenticate($username, $password);

        if ( is_wp_error($user) ) {
            return new WP_Error('invalid_credentials', 'Tên đăng nhập hoặc mật khẩu không chính xác', array('status' => 403));
        }

        $token = array(
            'iss' => get_bloginfo('url'),  // Issuer
            'iat' => time(),               // Thời gian phát hành
            'exp' => time() + (60 * 60),   // Thời gian hết hạn (1 giờ)
            'data' => array(
                'user_id' => $user->ID,
                'username' => $user->user_login,
            )
        );

        // Sử dụng đúng 3 tham số: payload, secret key, và thuật toán
        $jwt = JWT::encode($token, self::$secret_key, 'HS256');

        return array('token' => $jwt);
    }

    public static function validate_token( $request ) {
        $token = $request->get_header('Authorization');
        if (!$token) {
            return new WP_Error('no_token', 'Không có token', array('status' => 403));
        }

        // Xóa phần tham chiếu không cần thiết
        try {
            // Giải mã JWT chỉ với 3 tham số: token, secret key, và danh sách thuật toán
            $decoded = JWT::decode($token, new \Firebase\JWT\Key(self::$secret_key, 'HS256'));
            return true;
        } catch (Exception $e) {
            return new WP_Error('invalid_token', 'Token không hợp lệ', array('status' => 403));
        }
    }


    public static function get_user_info( $request ) {
        $token = $request->get_header('Authorization');

        if (!$token) {
            return new WP_Error('no_token', 'Không có token', array('status' => 403));
        }

        // Loại bỏ "Bearer " khỏi chuỗi token nếu có
        $token = str_replace('Bearer ', '', $token);

        try {
            // Giải mã JWT với khóa bí mật và thuật toán
            $decoded = JWT::decode($token, new \Firebase\JWT\Key(self::$secret_key, 'HS256'));

            // Lấy thông tin người dùng từ payload
            $user_id = $decoded->data->user_id;

            $user = get_user_by('id', $user_id);
            if (!$user) {
                return new WP_Error('user_not_found', 'Không tìm thấy người dùng', array('status' => 404));
            }

            // Lấy thêm các trường thông tin người dùng khác
            $first_name = get_user_meta($user_id, 'first_name', true);
            $last_name = get_user_meta($user_id, 'last_name', true);
            $roles = $user->roles; // Vai trò của người dùng
            $registered_date = $user->user_registered; // Ngày đăng ký
            $website = $user->user_url; // URL của người dùng (nếu có)

            // Trả về thông tin người dùng bao gồm các trường mở rộng
            return array(
                'ID' => $user->ID,
                'username' => $user->user_login,
                'email' => $user->user_email,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'roles' => $roles,
                'registered_date' => $registered_date,
                'website' => $website,
            );
        } catch (Exception $e) {
            return new WP_Error('invalid_token', 'Token không hợp lệ', array('status' => 403));
        }
    }



    public static function handle_logout() {
        return array('message' => 'Đăng xuất thành công');
    }
}
