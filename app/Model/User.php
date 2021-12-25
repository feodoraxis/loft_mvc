<?php
namespace App\Model;

use Base\Session as Session;
use Base\Db as DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Flight;

/**
 * Class User
 *
 * @package App\Model
 *
 * @property-read $name
 * @property-read $password
 * @property-read $is_admin
 * @property-read $email
 */

class User extends Model
{
    protected $session;
    protected static $salt = 'yid]9e0wu]8^()97eyw';
    protected $table = 'users';
    protected $fillable = [
        'name',
        'password',
        'is_admin',
        'email',
    ];

    public function authUser(int $user_id)
    {
        $this->session = new Session();
        $this->session->authUser($user_id);
    }

    public function auth()
    {
        $user = $_POST['user'];

        if (empty($user['email']) || empty($user['password'])) {
            return "You must set email and password";
        }

        if (strlen($user['password']) < 4) {
            return "your password is small";
        }

        $user_data = self::getByEmail($user['email']);

        if (empty($user_data) || $user_data['password'] !== self::hash_password($user['password'])) {
            return "incorrect user email or password";
        }

        $this->authUser($user_data['id']);

        return "You're succesfully authorized";
    }

    /**
     * Store a new flight in the database.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $user = (array) $_POST['user'];

        if (empty($user['name']) || empty($user['email'])) {
            return "You must set name and email";
        }

        if (mb_strlen($user['password']['1']) < 5) {
            return "your password is small";
        }

        if ($user['password']['1'] !== $user['password']['2']) {
            return "Passwords is incorrect";
        }

        if (self::getByEmail($user['email'])) {
            return "User with this email is already exists";
        }

        $this->name     = $user['name'];
        $this->password = self::hash_password($user['password'][ 1 ]);
        $this->is_admin = '0';
        $this->email    = $user['email'];

        if ($this->save()) {
            return 'Registration success. You can auth';
        }

        return 'Error';
    }

    public static function getByEmail($email): array
    {
        $res = self::query()->where('email', '=', $email)->first();//->toArray();

        if ($res) {
            return $res->toArray();
        } else {
            return [];
        }
    }

    public static function getById(int $id, bool $as_array = false)
    {
        if ($as_array === true) {
            return self::query()->where('id', '=', $id)->first()->toArray();
        }

        return self::query()->find($id);
    }

    public static function currentUserIsAdmin(): bool
    {
        $user_id = self::getCurrentUserId();
        $res = self::query()->where("id", '=', $user_id)->first()->toArray();

        if ($res['is_admin'] == 1) {
            return true;
        }

        return false;
    }

    public static function getCurrentUser(): array
    {
        $user_id = self::getCurrentUserId();
        return self::query()->where("id", '=', $user_id)->first()->toArray();
    }

    public static function getCurrentUserId()
    {
        return Session::getUserId();
    }

    public static function hash_password($password): string
    {
        return sha1($password . self::$salt);
    }

    public static function isAuthorized():bool
    {
        return Session::isAuthorized();
    }
}