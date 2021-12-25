<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\User as UserModel;

/**
 * Class Blog
 *
 * @package App\Model
 *
 * @property-read $message
 * @property-read $user_id
 * @property-read $text
 * @property-read $email
 * @property-read $date
 */
class Blog extends Model
{
    protected $table = 'blog';
    public $timestamps = false;

    public function getPosts()
    {
        $query = self::query()
            ->join('users', 'users.id', '=', 'blog.user_id')
            ->select("{$this->table}.*", "users.name")
            ->limit(20)
            ->orderBy('id', 'DESC')
            ->get();

        $res = [];
        foreach ($query as $item) {
            $res[] = $item->toArray();
        }


        return array_map(function($item) {
            $output = [
                'text' => $item['text'],
                'author' => $item['name'],
            ];

            if (UserModel::currentUserIsAdmin()) {
                $output['actions'] = '<form method="post">
                                           <button>remove</button>
                                            <input type="hidden" name="action" value="remove">
                                           <input type="hidden" name="post_id" value="' . $item['id'] . '">
                                      </form>';
            } else {
                $output['actions'] = '';
            }

            return $output;
        }, $res);
    }

     public static function getUsersPosts(int $user_id)
     {
         $query = self::query()
            ->join('users', 'users.id', '=', 'blog.user_id')
            ->select("blog.*", "users.name")
            ->where('user_id', '=', $user_id)
            ->limit(20)
            ->orderBy('id', 'DESC')
            ->get();

         $res = [];
         foreach ($query as $item) {
             $res[] = $item->toArray();
         }

         array_walk($res, function($item) {
              $item = [
                  'text' => $item['text'],
                  'author' => $item['name'],
                  'post_id' => $item['id'],
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
         $res = self::destroy($post_id);

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

         $this->text = $message;
         $this->date = date("Y-m-d");
         $this->user_id = $user_id;

         if ($this->save()) {
             return "Message sended";
         } else {
             return "Some error";
         }
     }
}