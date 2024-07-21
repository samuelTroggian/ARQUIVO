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
                <input type="file" class="form-control" id="arquivo" name = "arquivo" aria-describedby="arquivo" aria-label="Upload" required>
                <button class="btn btn-primary" type="submit" id="enviar" name="enviar">Enviar</button>
            </div>
        </form>
    </div>    


    <?php
       //VALIDAÇÃO DO FORMULÁRIO
       if (isset($_POST['enviar'])){
            echo "<pre>";
            var_dump($_FILES);
            echo "</pre>";

            //VALIDAÇÕES
            $tamanhoMaximo = 2097152; //2MB
            $permitido = ["jpg", "png", "jpeg", "mp4"];
            $extension = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

            //VERIFICAR SE O TAMANHA DO ARQUIVO É PERMITIDO
            if($_FILES['arquivo']['size'] > $tamanhoMaximo){
                echo '<div class="alert alert-danger" role="alert">
               "Erro: Tamanho máximo de 2 MB. Não foi possivel fazer UPLOAD"
                </div>';
            }else{
                //VERIFICAR SE EXTENSÃO É PERMITIDA
                if(in_array($extension,$permitido)){
                    //echo "Permitido";
                    $pasta = "imagem/";
                    if(!idis_r($pasta)){
                        mkdir($pasta, 0755);
                    }

                    $tmp = $_FILES['arquivo']['tmp_name'];
                    $novoNome = uniqid().".$extension";

                if(move_uploaded_file($tmp,$pasta.$novoNome)){
                    echo '<div class="alert alert-success" role="alert">
                    "Upload realizado com sucesso."
                     </div>';
                }else{
                     echo '<div class="alert alert-danger" role="alert">
                    "Erro: Não foi possivel fazer o upload."
                     </div>';
                }
            
                }else{
                     echo '<div class="alert alert-danger" role="alert">
                    "Erro: Extensão ('.$extension.') não permitida";
                     </div>';
                }
            }
       } 
    ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>