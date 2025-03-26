<?php

class AuthMiddleware
{
    public function handle()
    {
        // kullanıcı oturumunun kontrol edilmesi
        if (!isset($_SESSION['user'])) {
            // Oturum yoksa hata mesajı ver ama işlem devam etsin
            echo "You need to be logged in to access this page.";
        }
    }
}

