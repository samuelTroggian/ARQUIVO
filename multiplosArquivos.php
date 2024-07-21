<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class = "container">
        <h1 class="mt-5 text-center">Upload de Arquivos</h1>
        <form method = "post" enctype = "multipart/form-data" action="" class="m-3">
            <div class="input-group">
                <input multiple type="file" class="form-control" id="arquivo" name = "arquivo[]" aria-describedby="arquivo" aria-label="Upload" required>
                <button class="btn btn-primary" type="submit" id="enviar" name="enviar">Enviar</button>
            </div>
        </form>
    </div>    


    <?php
       //VALIDAÇÃO DO FORMULÁRIO
       if (isset($_POST['enviar'])){
           $arquivoArray = reArrayFiles($_FILES['arquivo']);
            //echo "<pre>";
            // var_dump($_FILES);
            //echo "</pre>";

            //FOREACH PARA PERCORRER ARRAY CRIADO ($ARQUIVOARRAY)
            foreach ($arquivoArray as $arquivo) {
                //OS TRES PRINTS É PARA VERIFICAÇÃO DA ORDENAÇÃO DO ARRAY $ARQUIVOARRAY APÓS EXECUÇÃO DA FUNÇÃO
                print 'Nome do arquivo: ' . $arquivo['name'] ."<br>";
                print 'Tipo do  arquivo: ' . $arquivo['type'] . "<br>";
                print 'Tamanho do arquivo: ' . $arquivo['size'] . "<br>";
                
                //VALIDAÇÕES CRIADA PARA UPLOAD DE UM OU MAIS ARQUIVOS
                $tamanhoMaximo = 2097152; //2MB
                $permitido = ["jpg", "png", "jpeg", "mp4"];
                $extension = pathinfo($arquivo['name'], PATHINFO_EXTENSION);

                //VERIFICAR SE O TAMANHA DO ARQUIVO É PERMITIDO
                if($arquivo['size'] > $tamanhoMaximo){
                    echo '<div class="alert alert-danger" role="alert">
                    <b>'.$arquivo['name'].'</b>"Erro: Tamanho máximo de 2 MB. Não foi possivel fazer UPLOAD"
                    </div>';
                }else{
                    //VERIFICAR SE EXTENSÃO É PERMITIDA
                    if(in_array($extension,$permitido)){
                        //CRIA PASTA SE NÃO EXISTE
                        $pasta = "imagem/";
                        if(!is_dir($pasta)){
                            mkdir($pasta, 0755);
                        }
                        //PEGA NOVE TEMPORARIO DO ARQUIVO
                        $tmp = $arquivo['tmp_name'];
                        //ATRIBUI UM NOVO NOME CONCATENADO COM A EXTENSÃO FINAL DO ARQUIVO
                        $novoNome = uniqid().".$extension";
                    //PEGA O NOME TEMPORARIO E  MOVE O ARQUIVO PARA A PASTA COM O NOVO NOME
                    if(move_uploaded_file($tmp,$pasta.$novoNome)){
                        echo '<div class="alert alert-success" role="alert">
                        <b>'.$arquivo['name'].'</b>"Upload realizado com sucesso."
                        </div>';
                    }else{
                        echo '<div class="alert alert-danger" role="alert">
                        <b>'.$arquivo['name'].'</b>"Erro: Não foi possivel fazer o upload."
                        </div>';
                    }
                
                    }else{
                        echo '<div class="alert alert-danger" role="alert">
                        <b>'.$arquivo['name'].'</b>"Erro: Extensão ('.$extension.') não permitida";
                        </div>';
                    }
                }

            }
       }
       //FUNÇÃO PADRÃO PARA UPLOAD DE MULTIPLOS ARQUIVOS
       function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
    
        return $file_ary;
    }
           
    ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>