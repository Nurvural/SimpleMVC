<?php

class Route
{
    private static $routes = []; // Tüm route'ları tutan statik dizi

    // Yeni bir route eklemek için kullanılan metod
    public static function add($method, $uri, $action, $middlewares = [])
    {
        // Route bilgilerini 'routes' dizisine ekler
        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'middlewares' => $middlewares
        ];
    }
    // Gelen istek ile route'ları karşılaştıran ve eşleşen route'u döndüren metod
    public static function match($method, $uri)
    {
        foreach (self::$routes as $route) {
            // HTTP metoduyla eşleşme kontrolü yapılır ve URI eşleşmesi kontrol edilir
            if ($route['method'] == $method && self::uriMatches($uri, $route['uri'], $params)) {
                return [  // Eşleşen route bulunursa, ilgili aksiyon ve parametreler döndürülür
                    'action' => $route['action'],
                    'params' => $params,
                    'middlewares' => $route['middlewares']
                ];
            }
        }
        return null;
    }

    // Bu metod, URI'nin route ile eşleşip eşleşmediğini kontrol eder. Route'da parametre varsa (örneğin {id}), bu parametreyi regex ile kontrol eder ve eşleşirse parametreleri alır. Sabit kısımlar eşleşmezse false döndürür.
    private static function uriMatches($uri, $routeUri, &$params)
    {

        $routeUriParts = explode('/', $routeUri);
        $uriParts = explode('/', $uri);

        if (count($uriParts) != count($routeUriParts)) {

            return false;
        }

        $params = [];
        for ($i = 0; $i < count($uriParts); $i++) {

            if (preg_match('/^{(.+)}$/', $routeUriParts[$i], $matches)) {

                $pattern = '\d+';
                if (preg_match('/^' . $pattern . '$/', $uriParts[$i])) {
                    $params[] = $uriParts[$i];
                } else {

                    return false;
                }
            } elseif ($routeUriParts[$i] != $uriParts[$i]) {

                return false;
            }
        }

        return true;
    }




    private static function handleMiddleware($middlewares)
    {
        foreach ($middlewares as $middleware) {
            $middlewareInstance = new $middleware();
            $middlewareInstance->handle();
        }
    }
    //Bu metod, gelen istekleri işler. match() metodunu kullanarak route eşleşmesi yapar. Eğer bir eşleşme bulunursa, ilgili middleware'leri çalıştırır ve sonra controller'ın metodunu çalıştırır. Eğer eşleşme bulunmazsa "Route not found!" mesajı verir.
    public static function handleRequest($method, $uri)
    {

        $result = self::match($method, $uri);
        if ($result) {
            if (!empty($result['middlewares'])) {
                self::handleMiddleware($result['middlewares']);
            }

            list($controller, $method) = explode('@', $result['action']);
            $controller = new $controller();
            call_user_func_array([$controller, $method], $result['params']);
        } else {
            echo "Route not found!";
        }
    }
}
