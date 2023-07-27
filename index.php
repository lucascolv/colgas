<?php
$conexao = new mysqli("localhost", "root", "", "colgas");
$dados = filter_input_array(INPUT_POST,FILTER_DEFAULT);

if(isset($dados['Logar'])){
    $query_cpf = "SELECT Nome, CPF, senha 
        FROM login
        WHERE CPF = ? AND senha = ?
        LIMIT 1";
    $resultado_cpf = $conexao->prepare($query_cpf);
    $senha = $dados['senhaLogin'];
    $cpf = $dados['cpfLogin'];
    $desincripta = hash('sha512', $senha.$cpf);
    $resultado_cpf->bind_param("ss", $cpf, $desincripta);
    $resultado_cpf->execute();
    $resultado = $resultado_cpf->get_result();
    if(($resultado_cpf) AND ($resultado_cpf->affected_rows > 0))
    {
        session_start();
        $linha = $resultado -> fetch_assoc();
        $nome = $linha['Nome'];
        $_SESSION['cpflogin'] = $linha['CPF'];
        $desincripta = $linha['senha'];

        $_SESSION['msg'] = "<p
			style='color:#08f26e'>Lofin efetuado com sucesso!</p>";
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
            echo"
            <style>
                dialog{
                    background: #2f6e31;
                }
                li{
                    list-style:none;
                }
                li.button{
                    display: inline;
                    margin-right: 20px;
                    font-size: 150%;
                }
                li.button:hover{
                    background-color: #08f26e;
                    color: #999999;
                    text-shadow: 1px 1px 0px #000000;
                    padding: 20px;
                }
                div.menu{
                    background: #19611b;
                }
                div.function{
                    font-size: 150%;
                }
                p.msg{
                    text-align: center;
                }
                ul.function:hover{
                    background: #19611b;
                }
                div.function{
                    width: 30%;
                    margin: 40 auto;
                }

            </style>
            <html>
            <body>
                <dialog  open class='dashboard' id='modal' style='width:auto; height:91%' >
                    <h1> colgas </h1>

                    <div>
			            <ul>
				            <p class='msg'> Bem Vindo ao colgas, ".$nome. "</p>
			            </ul>


                        <div class='menu'>
				            <ul>
					            <li class='button'>Home</li>
					            <li class='button sobre'>Sobre</li>
					            <li class='button submit'>Opções</li>
					            <a href='index.php'><li class='button'>Sair</li></a>
				            </ul>
                        </div>

                        <div class='function'>
                            <ul class='function'>
                                <a href='bq.php'><li>Banco de questões</li></a>
                            </ul>
                            <ul class='function'>
                                <a href='flash.php'><li>Flashcards</li></a>
                            </ul>
                            <ul class='function'>
                                <li>Planner</li>
                            </ul>
                        </div>
                </dialog>
            </body>
            </html>";
    }
else
		{
			$_SESSION['msg'] = "<p
			style='color:#08f26e'>Erro
			usuário ou senha inválida</p>";
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }        
    }
    
?>

<html>
    <head>
        <title> colgas </title>
    </head>

    <style type="text/css">
        h1{
            font-size: 500%;
            text-decoration: underline;
            text-align: center;
            background: #2f6e31;
        }
        body{
            font-family: Georgia, Times, serif;
            font-size: 22px;
            background-color: #808080;
        }
            p{
                text-align: justify;
                
            }
            p.autor{
                text-align: right;
                text-decoration: underline;
            }
            p.texto{
                background-color: #000000;
                color: #20C20E;
            }
        blockquote{
            font-size: 44px;
        }
        p.frase_p:hover{
            background-color: #FFFF00;
        }

            form{
            border: 1px solid #ccc;
            background-color: #2f6e31;
            padding: 20px;
            margin: auto;
            max-width: 400px;
            }

            label{
            display: block;
            margin-bottom: 10px;
            font-family: 'Shantell Sans', cursive;
  
            }

            input{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            }

            input{
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            }

            input:hover {
            background-color: #3e8e41;
            }

                form{
                border: 1px solid #ccc;
                background: #2f6e31;
                padding: 20px;
                margin: auto;
                max-width: 400px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                }

                input{
                background: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background 0.3s ease;
                box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
                }

                input[type="submit"]:hover {
                background: #3e8e41;
}
    </style>

    <body align="center">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Shantell+Sans:ital,wght@0,600;1,300&display=swap" rel="stylesheet">

    <h1> colgas </h1>

    <div class="one" style=" width: 65%;  float: left;">
            <p class="texto"> Objetiva-se, por meio do desenvolvimento deste sistema, melhor organizar os estudos, bem como a vida escolar </p>
            <blockquote> 
                <p class="frase_p">
                    "Os circuitos de consagração social serão tanto mais eficazes quanto maior a distância social do objeto consagrado."
                </p>
                <p class="autor">
                Pierre Bourdie
                </p>
            </blockquote>
        </div>

        <div  align="left" style="margin-left: 72%; ;">
            <box>
                <h2 align="left"> Login</h2>
				<form method="POST" class"login-form">
					<div>
						<label>Login   :</label>
						<input placeholder="Digite seu Login" type="text" name="cpfLogin" class="validate" id="cpflogin" data-length="11">
					</div>
					<div>
						<label>Senha:</label>
						<input placeholder="Digite sua senha" type="password" name="senhaLogin" class="validate" id="senhaLogin" data-length="8">
					</div>
					<input type="submit" value="Enviar" name="Logar" class="logar">
				</form>
			</box>
        </div>


        <dialog id="estudos">
            <p> Olá </p>
        </dialog>

    </body>
</html>