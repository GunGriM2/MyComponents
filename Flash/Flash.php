<?php

class Flash
{
    // метод добавления сообщения в сессию
    // на вход идет название сообщения и его занчение
    public static function put($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    // метод для проверки наличия сообщения сообщения в сессии по имени
    // на вход идет имя сообщения
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    // метод удаления сообщения из сессии по имени
    // на вход идет имя сообщения
    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }

    }

    // метод получения занения сообщения по имени
    // на вход идет имя сообщения
    public static function get($name)
    {
        return $_SESSION[$name];
    }

    // метод получения и последующего удаления или записи флэш сообщения
    // на вход поступает имя сообщения при намерении получения значения существующего сообщения
    // на вход поступает имя и значение сообщения при намерении добавить сообщение в сессию
    public static function flashMessage($name, $string = '')
    {
        if (self::exists($name) and self::get($name) != '') {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
    }
}
