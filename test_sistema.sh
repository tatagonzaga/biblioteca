#!/bin/bash

# Script para testar o sistema de biblioteca

echo "=== Testando o Sistema de Biblioteca ==="
echo

echo "1. Verificando se o servidor está rodando..."
curl -s http://localhost:8000 > /dev/null
if [ $? -eq 0 ]; then
    echo "✓ Servidor está rodando"
else
    echo "✗ Servidor não está rodando. Execute: php artisan serve"
    exit 1
fi

echo

echo "2. Verificando tabelas do banco de dados..."
php artisan tinker --execute="
echo 'Tabelas criadas:';
try {
    \$books = App\Models\Book::count();
    echo 'Books: ' . \$books . ' registros';
} catch (Exception \$e) {
    echo 'Erro em Books: ' . \$e->getMessage();
}

try {
    \$categories = App\Models\BookCategory::count();
    echo 'Categories: ' . \$categories . ' registros';
} catch (Exception \$e) {
    echo 'Erro em Categories: ' . \$e->getMessage();
}

try {
    \$users = App\Models\User::count();
    echo 'Users: ' . \$users . ' registros';
} catch (Exception \$e) {
    echo 'Erro em Users: ' . \$e->getMessage();
}
"

echo

echo "3. Teste concluído!"
echo
echo "Para testar a aplicação:"
echo "1. Acesse http://localhost:8000"
echo "2. Faça login com: admin@biblioteca.com / admin123"
echo "3. Navegue para a seção de livros"
echo "4. Teste criar, editar e excluir livros"
