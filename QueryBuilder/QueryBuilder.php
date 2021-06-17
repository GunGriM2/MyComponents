<?php

class QueryBuilder
{

    private static $instance = null;
    private $pdo, $query, $error = false, $results, $count;

    // конструктор класса, подключается к БД и передает это в приватную переменную класса
    private function __construct()
    {
        try
        {
            $this->pdo = new PDO('mysql:host=mysql;dbname=app3;charset=utf8', 'root', 'secret');
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    // статический метод который создает объект класса и присвает его в приватную переменную этого же класса
    // возвращает объект класса 
    // реализует шаблон синглтон
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new QueryBuilder;
        }

        return self::$instance;
    }

    // метод для подготовки и выполнения запроса для БД, записывает результат запроса и количество строк в соответствующие переменные
    // на вход поступают запрос и параметры к нему, если есть
    // возвращает объект класса
    public function query($sql, $params = [])
    {
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);

        if (count($params)) {
            $i = 1;
            foreach ($params as $param) {
                $this->query->bindValue($i++, $param);
            }
        }

        if ($this->query->execute() === false) {
            $this->error = true;
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_ASSOC);
            $this->count = $this->query->rowCount();
        }

        return $this;
    }

    // возвращает информацию о ошибках
    public function error()
    {
        return $this->error;
    }

    // возвращает результат выполнения последнего запроса
    public function results()
    {
        return $this->results;
    }

    // возвращает количество строк в результате выполнения последнеднего запроса 
    public function count()
    {
        return $this->count;
    }

    // метод получения информации из БД
    // на вход идут таблица и критерии отбора
    // реализуется с помощью метода action, которую возвращает
    public function get($table, $where = [])
    {
        return $this->action("SELECT *", $table, $where);
    }

    // метод удаления информации из БД
    // на вход идут таблица и критерии отбора
    // реализуется с помощью метода action, которую возвращает
    public function delete($table, $where = [])
    {
        return $this->action("DELETE", $table, $where);
    }

    // метод который формирует строку запроса и выполняет ее с помощью метода query
    // на вход постпает действие, таблица, и критерии отбора
    // в случае успешного выполнения возвращает объект класса, в обратном случае false
    private function action($action, $table, $where = [])
    {
        if (count($where) === 3) {
            $operators = ['=', '>', '<', '>=', '<='];

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM `{$table}` WHERE {$field} {$operator} ? ";
                if (!$this->query($sql, [$value])->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    // метод для добавления строки информации в БД
    // на вход идут таблица и информация о строке в виде массива
    // в случае успешного выполнения возвращает true, в обратном случае false
    public function insert($table, $fields = [])
    {
        $values = '';
        foreach ($fields as $field) {
            $values .= "?,";
        }
        $val = rtrim($values, ',');

        $sql = "INSERT INTO {$table} (" . '`' . implode('`, `', array_keys($fields)) . '`' . ") VALUES ({$val})";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    // метод для обновления строки информации в БД
    // на вход идут таблица, id строки для изменения и информация о строке в виде массива
    // в случае успешного выполнения возвращает true, в обратном случае false
    public function update($table, $id, $fields = [])
    {
        $set = '';
        foreach ($fields as $key => $field) {
            $set .= "{$key} = ?,";
        }
        $set = rtrim($set, ',');

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }


    // метод для получения первой строки из результата выполнения запроса
    public function first()
    {
        return $this->results()[0];
    }
}
