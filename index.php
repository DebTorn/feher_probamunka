<?php

    session_start();

    $GLOBALS['allapotok'] = [
        'egyedulallo',
        'hazas',
        'elvalt'
    ];
    $GLOBALS['errors'] = [];
    $GLOBALS['datas'] = [];

    // Az URL-címből kinyert útvonal meghatározása
    $url = isset($_GET['url']) ? $_GET['url'] : 'home';
    $url = rtrim($url, '/');
    $segments = explode('/', $url);

    $publicRoutes = [
        'home',
        'login',
        'register'
    ];

        $controllerName = ucfirst($segments[0]) . 'Controller';

        $controllerLink = 'controllers\\'. $controllerName;

        $controllerFile = 'controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {

            $db = 0;
            foreach($publicRoutes as $route){
                if($segments[0] != $route){
                    $db++;
                }
            }  

            if($db == count($publicRoutes)){    //Ha olyan route ami nincs benne a public routeban
                if(!empty($_SESSION['email'])){ //Be van jelentkezve a felhasználó
                    require_once($controllerFile);
                    $controller = new $controllerLink();
        
                    $action = isset($segments[1]) ? $segments[1] : 'index';
                    if (method_exists($controller, $action)) {
                        unset($segments[0]);
                        unset($segments[1]);
                        $params = array_values($segments);
                        call_user_func_array([$controller, $action], $params);
                    } else {
                        echo "404 - Page not found";
                        die;
                    }
                }else{
                    echo "403 : Forbidden";
                    die;
                }
            }else{  //Ha public a route
                if(count($segments) > 1){
                    if(!empty($_SESSION['email']) && ($segments[1] == "login" || $segments[1] == "register")){   //Ha be van jelentkezve és el akar navigálni loginra vagy registerre
                        header("Location: /probamunka/");
                        die;
                    }
                }

                $i = 0;
                while($i < count($publicRoutes) && $publicRoutes[$i] != $segments[0]){
                    $i++;
                }

                if($i < count($publicRoutes)){
                    require_once($controllerFile);
                    $controller = new $controllerLink();
        
                    $action = isset($segments[1]) ? $segments[1] : 'index';
                    if (method_exists($controller, $action)) {
                        unset($segments[0]);
                        $params = array_values($segments);
                        call_user_func_array([$controller, $action], $params);
                    } else {
                        echo "404 - Page not found";
                        die;
                    }
                }else{
                    echo "403 : Forbidden";
                    die;
                }

            }

        } else {
            echo "404 - Page not found";
            die;
        }


?>

