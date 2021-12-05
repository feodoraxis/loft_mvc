<?php
namespace App\Model;

use Base\Db as DB;
use App\Model\User as UserModel;
use http\Header;

class Blog
{
    public function getPosts()
    {
        $DB = DB::getInstance();
        $res = $DB->fetchAll(
            "SELECT blog.id as post_id, blog.user_id, blog.text, users.id, users.name FROM `blog` INNER JOIN `users` ON blog.user_id = users.id ORDER BY blog.id DESC LIMIT 20",
            []
        );

        return array_map(function($item) {
            $output = [
                'text' => $item['text'],
                'author' => $item['name'],
            ];

            if (UserModel::currentUserIsAdmin()) {
                $output['actions'] = '<form method="post">
                                           <button>remove</button>
                                           <input type="hidden" name="action" value="remove">
                                           <input type="hidden" name="post_id" value="' . $item['post_id'] . '">
                                      </form>';
            } else {
                $output['actions'] = '';
            }

            return $output;
        }, $res);
    }

    public static function getUsersPosts(int $user_id)
    {
        $DB = DB::getInstance();
        $res = $DB->fetchAll(
            "SELECT blog.id as post_id, blog.user_id, blog.text, users.id, users.name FROM `blog` INNER JOIN `users` ON blog.user_id = users.id WHERE blog.user_id = :user_id ORDER BY blog.id DESC LIMIT 20",
            [
                ':user_id' => $user_id
            ]
        );

        array_walk($res, function($item) {
            $item = [
                'text' => $item['text'],
                'author' => $item['name'],
                'post_id' => $item['post_id'],
            ];
        });

        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    public function remove()
    {
        if (!UserModel::currentUserIsAdmin()) {
            return "You're can not remove posts";
        }

        $post_id = intval($_POST['post_id']);

        $DB = DB::getInstance();
        $res = $DB->exec(
            "DELETE FROM `blog` WHERE `id` = :post_id",
            [
                ':post_id' => $post_id,
            ]
        );

        if ($res) {
            Header("Location: /");
        } else {
            return $post_id;
        }
    }

    public function add()
    {
        if (empty($_POST['message'])) {
            return "white some text";
        }

        $message = nl2br($_POST['message']);
        $user_id = UserModel::getCurrentUserId();
        $DB = DB::getInstance();

        $res = $DB->exec(
            "INSERT INTO `blog` (`text`,`date`,`user_id`) VALUES ( :text, :date, :user_id)",
            [
                ':text' => $message,
                ':date' => date("Y-m-d"),
                ':user_id' => $user_id,
            ]
        );

        if ($res) {
            return "Message sended";
        } else {
            return "Some error";
        }
    }

    public static function getBlogName()
    {
        return 'Andrey';
    }
}