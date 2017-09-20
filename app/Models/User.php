<?php

namespace App\Models;

use \Shared\Model;
use App\Service\Rights;
use App\Service\Sms;
use App\Traits\HasPhotos;
use App\Service\Log;
use Illuminate\Support\Facades\Redis;

class User extends Model
{
    use HasPhotos;

    protected $fillable = [
        'login',
        'new_password',
        'first_name',
        'last_name',
        'middle_name',
        'phone',
        'rights'
    ];

    protected $hidden = ['password'];

    protected $commaSeparated = ['rights'];

    # Fake system user
    const SYSTEM_USER = [
        'id'    => 0,
        'login' => 'system',
    ];

    public function setNewPasswordAttribute($value)
    {
        $this->attributes['password'] = static::_password($value);
        unset($this->new_password);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = cleanNumber($value);
    }

    /**
     * Вход пользователя
     */
    public static function login($data)
    {
        $User = User::active()->where([
            'login'         => $data['login'],
            'password'      => static::_password($data['password']),
        ]);

        if ($User->exists()) {
            $user = $User->first();
            // Дополнительная СМС-проверка, если пользователь логинится если не из офиса
            if (! User::fromOffice()) {
                $sent_code = Redis::get("tcms:codes:{$user->id}");
                // если уже был отправлен – проверяем
                if (! empty($sent_code)) {
                    if (@$data['code'] != $sent_code) {
                        self::log($user->id, 'failed_login', 'неверный смс-код');
                        return false;
                    } else {
                        Redis::del("tcms:codes:{$user->id}");
                    }
                } else {
                    // иначе отправляем код
                    self::log($user->id, 'sms_code_sent');
                    Sms::verify($user);
                    return 'sms';
                }
            }
            self::log($user->id, 'success_login');
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public static function logout()
    {
        unset($_SESSION['user']);
    }

    /*
	 * Проверяем, залогинен ли пользователь
	 */
	public static function loggedIn()
	{
		return isset($_SESSION["user"]) // пользователь залогинен
            && ! User::isBlocked()      // и не заблокирован
            && User::notChanged();      // и данные не изменились
	}

    /**
     * Данные по пользователю не изменились
     * если поменяли в настройках хоть что-то, сразу выкидывает, чтобы перезайти
     */
    public static function notChanged()
    {
        return User::fromSession()->updated_at == self::whereId(User::fromSession()->id)->value('updated_at');
    }

    /*
	 * Пользователь из сессии
	 * @boolean $init – инициализировать ли соединение с БД пользователя
	 * @boolean $update – обновлять данные из БД
	 */
	public static function fromSession($upadte = false)
	{
		// Если обновить данные из БД, то загружаем пользователя
		if ($upadte) {
			$User = User::find($_SESSION["user"]->id);
			$User->toSession();
		} else {
			// Получаем пользователя из СЕССИИ
			$User = $_SESSION['user'];
		}

		// Возвращаем пользователя
		return $User;
	}

    /**
     * Текущего пользователя в сессию
     */
    public function toSession()
    {
        $_SESSION['user'] = $this;
    }

    /**
     * Вернуть системного пользователя
     */
    public static function getSystem()
    {
        return (object)static::SYSTEM_USER;
    }

    /**
	 * Вернуть пароль, как в репетиторах
	 *
	 */
	private static function _password($password)
	{
		$password = md5($password."_rM");
        $password = md5($password."Mr");

		return $password;
	}

    /**
     * Get real users
     *
     */
    public static function scopeActive($query)
    {
        return $query->whereRaw('NOT FIND_IN_SET(' . Rights::BANNED . ', rights)');
    }

    public static function scopeBanned($query)
    {
        return $query->whereRaw('FIND_IN_SET(' . Rights::BANNED . ', rights)');
    }

    public static function isBlocked()
    {
        return User::whereId(User::fromSession()->id)
                ->whereRaw('FIND_IN_SET(' . Rights::BANNED . ', rights)')
                ->exists();
    }

    /**
     * Логин из офиса
     */
    public static function fromOffice()
    {
        if (app('env') === 'local') {
            return true;
        }
        $current_ip = @$_SERVER['HTTP_X_REAL_IP'];
        foreach(['213.184.130.', '77.37.220.250'] as $ip) {
            if (strpos($current_ip, $ip) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * User has rights to perform the action
     */
    public function allowed($right)
    {
        return in_array($right, $this->rights);
    }

    public static function log($user_id, $type, $message = '', $data = [])
    {
        $data = array_merge($data, [
            $type => $message,
            'user_agent' => @$_SERVER['HTTP_USER_AGENT']
        ]);
        Log::custom('authorization', $user_id, $data);
    }
}
