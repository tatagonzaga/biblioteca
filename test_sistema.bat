@echo off
echo === Testando o Sistema de Biblioteca ===
echo.

echo 1. Verificando configuracao do banco de dados...
php artisan tinker --execute="echo 'Testando conexao com banco:'; try { $users = App\Models\User::count(); echo 'Users: ' . $users . ' registros'; $categories = App\Models\BookCategory::count(); echo 'Categories: ' . $categories . ' registros'; echo 'Conexao OK!'; } catch (Exception $e) { echo 'Erro: ' . $e->getMessage(); }"

echo.
echo 2. Para testar a aplicacao completa:
echo    - Execute: php artisan serve
echo    - Acesse: http://localhost:8000
echo    - Login: admin@biblioteca.com / admin123
echo    - Teste criar, editar e excluir livros
echo.
echo 3. Se houver erros, execute:
echo    - php artisan migrate:fresh --seed
echo    - npm run build
echo.
pause
