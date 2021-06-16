# MyComponents

## Router

Для работы компонента нужен постоянный список путей в виде массива, который нельзя поместить в глобальную переменную, как сообщения в сессию. Поэтому для этого в отдельном файле (в моем случае в индексе чисто для примера) нужно будет создавать массив, как для конфигурации, который потом будет подключатся в index.php.

В компоненте всего один статический (для удобства, смысла создавать объект нет) метод, который просто подключает файл по входному запросу сверяясь с массивом запросов, который также поступает на вход в метод. Изменение массива с путями производится вручную в соответствубщим файле, поэтому нет методов с добавлением или удалением путей.

### Содержание:

- controllers - папка со страницами для примера
    - about.php - вывод 'about'
    - homepage.php - вывод 'homepage'
- public
    - index.php - точка входа с массивом и использованным методом
- Router.php - компонент маршрутизатор

### Использование 

1. Пишем массив с путями в начальном файле либо в отдельном.
```
    $routes = [
        '/' => 'functions/homepage.php',
        '/about' => 'functions/about.php',
    ];
```

2. Получаем url запрос.
```
    $route = $_SERVER['REQUEST_URI'];
```
3. Используем статический метод route компонента Router.
```
    Router::route($route, $routes);
```

