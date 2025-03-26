<?php

require_once(__DIR__ . '/../../core/DB.php');
require_once(__DIR__ . '/../../core/TemplateEngine.php');

class UserController
{
    public function getUserJson($id)
    {
        $user = DB::query('SELECT * FROM users WHERE id = ?', [$id]);
        // JSON formatında döndür
        header('Content-Type: application/json');
        echo json_encode($user);
    }

    public function show($id) //HTML formatı
    {
        $user = DB::query('SELECT * FROM users WHERE id = ?', [$id]);

        // İstemcinin Accept header'ına göre dönecek formatı belirleyelim
        //Eğer URL'de ?format=json parametresi varsa veya Accept başlığı application/json olarak gelirse, veriyi JSON formatında döndürür.
        if (isset($_GET['format']) && $_GET['format'] === 'json') {
            header('Content-Type: application/json');
            echo json_encode($user);
        } else {
            // HTML formatı için TemplateEngine ile view dosyasını render et
            $templateEngine = new TemplateEngine();
            $content = $templateEngine->render('Views/show.php', ['user' => $user]);
            // Render edilen içeriği ekrana bas
            echo $content;
        }
    }
}
