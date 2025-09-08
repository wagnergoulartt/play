<?php
// Define o diretório principal das músicas
$music_directory = 'musicas';

// Função para escanear os diretórios recursivamente
function scan_directory($dir) {
    $files = [];
    // scandir lista todos os arquivos e pastas, o array_diff remove '.' e '..'
    $items = array_diff(scandir($dir), array('..', '.'));

    foreach ($items as $item) {
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            // Se for um diretório, chama a função novamente para entrar nele
            // e mescla os resultados
            $files = array_merge($files, scan_directory($path));
        } else {
            // Se for um arquivo e terminar com .mp3, adiciona à lista
            if (pathinfo($path, PATHINFO_EXTENSION) == 'mp3') {
                // Remove o diretório principal do caminho para ficar relativo
                // ex: musicas/funk/musica.mp3 -> funk/musica.mp3
                $files[] = substr($path, strlen($GLOBALS['music_directory']) + 1);
            }
        }
    }
    return $files;
}

// Verifica se o diretório de músicas existe para evitar erros
if (!is_dir($music_directory)) {
    // Se não existir, retorna um array JSON vazio
    header('Content-Type: application/json');
    echo json_encode([]);
    exit;
}


// Inicia o escaneamento
$music_list = scan_directory($music_directory);

// Define o cabeçalho como JSON para o JavaScript entender a resposta
header('Content-Type: application/json');

// Imprime a lista de músicas no formato JSON
echo json_encode($music_list);
?>

