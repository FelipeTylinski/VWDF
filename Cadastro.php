<?php
include_once './conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST["submit"])) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados = array_map('trim', $dados);

    // Remove o submit da verificação de campos vazios
    $campos = $dados;
    unset($campos['submit']);

    if (in_array("", $campos)) {
        $erro = "⚠ Preencha todos os campos!";
    } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
        $erro = "⚠ E-mail inválido!";
    } else {
        $query_usuario = "INSERT INTO cadastrar (nome, email, telefone, sexo, data_nasc, cidade, estado, endereco, senha, tipo_usuario) 
                          VALUES (:Nome, :Email, :Telefone, :Sexo, :Data_nasc, :Cidade, :Estado, :Endereco, :Senha, :Tipo_usuario)";
        $cad_usuario = $conn->prepare($query_usuario);
        $cad_usuario->bindParam(':Nome', $dados['nome'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':Email', $dados['email'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':Telefone', $dados['telefone'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':Sexo', $dados['genero'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':Data_nasc', $dados['data_nascimento'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':Cidade', $dados['cidade'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':Estado', $dados['estado'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':Endereco', $dados['endereco'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':Senha', $dados['senha'], PDO::PARAM_STR);
        $cad_usuario->bindParam(':Tipo_usuario', $dados['tipo_usuario'], PDO::PARAM_STR);
        $cad_usuario->execute();

        if ($cad_usuario->rowCount()) {
            header("Location: login.php");
            exit();
        } else {
            $erro = "⚠ Erro ao cadastrar, tente novamente!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: #0a0a0f;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            padding: 100px 20px 40px;
        }

        /* Fundo animado */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: 
                radial-gradient(ellipse at 20% 50%, rgba(120, 40, 200, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(0, 100, 255, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(180, 0, 255, 0.1) 0%, transparent 50%);
            z-index: 0;
            animation: bgPulse 8s ease-in-out infinite alternate;
        }

        @keyframes bgPulse {
            0%   { opacity: 0.6; }
            100% { opacity: 1; }
        }

        /* Grid lines futuristas */
        body::after {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-image:
                linear-gradient(rgba(100, 50, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(100, 50, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 0;
        }

        /* Botão home */
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 10px 16px;
            color: white;
            font-size: 13px;
            cursor: pointer;
            z-index: 100;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .home-button:hover {
            background: rgba(130, 50, 255, 0.2);
            border-color: rgba(130, 50, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(130, 50, 255, 0.2);
        }

        /* Card principal */
        .card {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            backdrop-filter: blur(20px);
            box-shadow:
                0 0 0 1px rgba(130, 50, 255, 0.1),
                0 20px 60px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255,255,255,0.05);
            animation: fadeUp 0.6s ease forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Linha brilhante no topo do card */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(130, 50, 255, 0.8), transparent);
            border-radius: 50%;
        }

        /* Título */
        .card-title {
            text-align: center;
            margin-bottom: 32px;
        }

        .card-title h1 {
            font-size: 26px;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 1px;
        }

        .card-title p {
            color: rgba(255,255,255,0.35);
            font-size: 13px;
            margin-top: 6px;
        }

        /* Grid 2 colunas */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        /* Grupo de input */
        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-group label {
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-group input[type="text"],
        .input-group input[type="email"],
        .input-group input[type="tel"],
        .input-group input[type="password"],
        .input-group input[type="date"] {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 12px 16px;
            color: white;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            width: 100%;
        }

        .input-group input:focus {
            border-color: rgba(130, 50, 255, 0.6);
            background: rgba(130, 50, 255, 0.07);
            box-shadow: 0 0 0 3px rgba(130, 50, 255, 0.1);
        }

        .input-group input::placeholder {
            color: rgba(255,255,255,0.2);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) opacity(0.4);
            cursor: pointer;
        }

        /* Radio pill */
        .radio-section {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .radio-section .section-label {
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .radio-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .radio-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 50px;
            padding: 8px 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: rgba(255,255,255,0.6);
            font-size: 13px;
            user-select: none;
        }

        .radio-pill input[type="radio"] {
            display: none;
        }

        .radio-pill:has(input:checked) {
            background: rgba(130, 50, 255, 0.2);
            border-color: rgba(130, 50, 255, 0.6);
            color: white;
            box-shadow: 0 0 12px rgba(130, 50, 255, 0.2);
        }

        .radio-pill:hover {
            border-color: rgba(130, 50, 255, 0.4);
            color: white;
        }

        /* Divisor */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
            margin: 8px 0;
        }

        /* Mensagem de erro */
        .msg {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
        }

        .msg-error {
            background: rgba(255, 60, 60, 0.1);
            border: 1px solid rgba(255, 60, 60, 0.2);
            color: #ff8080;
        }

        /* Botões */
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 24px;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #6d28d9, #4f46e5);
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(109, 40, 217, 0.4);
            letter-spacing: 0.5px;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: 0.5s;
        }

        .btn-primary:hover::before { left: 100%; }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(109, 40, 217, 0.6);
        }

        .btn-primary:active { transform: scale(0.98); }

        .btn-secondary {
            width: 100%;
            padding: 13px;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            background: rgba(255,255,255,0.03);
            color: rgba(255,255,255,0.5);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            border-color: rgba(255,255,255,0.2);
            color: white;
            background: rgba(255,255,255,0.06);
            transform: translateY(-1px);
        }

        .btn-secondary:active { transform: scale(0.98); }
    </style>
</head>
<body>

    <!-- Botão home -->
    <button class="home-button" onclick="window.location.href='Pagina_principal.php'">
        🏠 Início
    </button>

    <div class="card">
        <div class="card-title">
            <h1>Criar Conta</h1>
            <p>Preencha os dados abaixo para se cadastrar</p>
        </div>

        <!-- Mensagem de erro -->
        <?php if ($erro): ?>
            <div class="msg msg-error"><?= $erro ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="grid-2">

                <div class="input-group full-width">
                    <label>Nome completo</label>
                    <input type="text" name="nome" placeholder="Seu nome completo" required>
                </div>

                <div class="input-group full-width">
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="seu@email.com" required>
                </div>

                <div class="input-group">
                    <label>Telefone</label>
                    <input type="tel" name="telefone" placeholder="(00) 00000-0000" required>
                </div>

                <div class="input-group">
                    <label>Data de Nascimento</label>
                    <input type="date" name="data_nascimento" required>
                </div>

                <div class="input-group">
                    <label>Cidade</label>
                    <input type="text" name="cidade" placeholder="Sua cidade" required>
                </div>

                <div class="input-group">
                    <label>Estado</label>
                    <input type="text" name="estado" placeholder="UF" required>
                </div>

                <div class="input-group full-width">
                    <label>Endereço</label>
                    <input type="text" name="endereco" placeholder="Rua, número, bairro" required>
                </div>

                <div class="input-group full-width">
                    <label>Senha</label>
                    <input type="password" name="senha" placeholder="••••••••" required>
                </div>

                <!-- Sexo -->
                <div class="radio-section full-width">
                    <span class="section-label">Sexo</span>
                    <div class="radio-options">
                        <label class="radio-pill">
                            <input type="radio" name="genero" value="feminino" required> ♀ Feminino
                        </label>
                        <label class="radio-pill">
                            <input type="radio" name="genero" value="masculino"> ♂ Masculino
                        </label>
                        <label class="radio-pill">
                            <input type="radio" name="genero" value="outro"> ⚬ Outro
                        </label>
                    </div>
                </div>

                <div class="divider full-width"></div>

                <!-- Tipo de usuário -->
                <div class="radio-section full-width">
                    <span class="section-label">Tipo de Usuário</span>
                    <div class="radio-options">
                        <label class="radio-pill">
                            <input type="radio" name="tipo_usuario" value="aluno" required> 🎓 Aluno
                        </label>
                        <label class="radio-pill">
                            <input type="radio" name="tipo_usuario" value="secretaria"> 🏢 Secretaria
                        </label>
                    </div>
                </div>

            </div>

            <div class="btn-group">
                <button type="submit" name="submit" value="submit" class="btn-primary">✦ Criar Conta</button>
                <button type="button" class="btn-secondary" onclick="window.location.href='login.php'">← Já tenho conta</button>
            </div>
        </form>
    </div>

</body>
</html>