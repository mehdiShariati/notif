<?php

        $container = $app->getContainer();

		// $container['db'] = function ($container) {
        //     try {
        //         $settings = $container->get('settings')['db'];
        //         $dsn = "mysql:host={$settings['host']};dbname={$settings['database']}";
        //         $PDO = new PDO($dsn, $settings['username'], $settings['password']);
        //         // set the PDO error mode to exception


        //         $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //         return $PDO;


        //     } catch (PDOException $e) {
        //         echo "Connection failed: " . $e->getMessage();

        //     }

        // };
		// $container["DataAccess"]=function($container){
        //     return new \App\DataAccess\Data($container);
        // };
		



