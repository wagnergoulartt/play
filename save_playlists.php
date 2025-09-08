<?php
// Define o nome do ficheiro que irá armazenar os dados das playlists.
$file = 'playlists.json';

// Obtém os dados JSON brutos enviados pelo JavaScript através do método POST.
$json_data = file_get_contents('php://input');

// Tenta descodificar a string JSON para um objeto ou array PHP.
$data = json_decode($json_data);

// Verifica se a descodificação JSON foi bem-sucedida e não houve erros.
if (json_last_error() === JSON_ERROR_NONE) {
    // Se os dados forem válidos, guarda-os no ficheiro.
    // JSON_PRETTY_PRINT formata o ficheiro JSON para ser facilmente legível por humanos.
    // JSON_UNESCAPED_UNICODE garante que caracteres especiais (como acentos) são guardados corretamente.
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    // Envia uma resposta HTTP 200 (OK) para o JavaScript, indicando que tudo correu bem.
    http_response_code(200);
    echo "Playlists guardadas com sucesso.";
} else {
    // Se os dados JSON recebidos estiverem corrompidos ou inválidos, envia uma resposta de erro.
    // HTTP 400 (Bad Request) indica que o pedido do cliente foi malformado.
    http_response_code(400);
    echo "Erro: Dados JSON inválidos.";
}
?>

