<?php
include_once './Conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados["submit"])) {

        $empty_input = false;

        $dados = array_map('trim',$dados);

        if(in_array("",$dados)){
            $empty_input=true;

            $mensagem="
            <div class='mensagem-erro'>
            Preencha todos os campos!
            </div>";
        }

        if(!$empty_input){

            $query="INSERT INTO Ensalamento
            (curso, professor, data, hora, sala)
            VALUES
            (:curso,:professor,:data,:hora,:sala)";

            $cad=$conn->prepare($query);

            $cad->bindParam(':curso',$dados['curso']);
            $cad->bindParam(':professor',$dados['professor']);
            $cad->bindParam(':data',$dados['data']);
            $cad->bindParam(':hora',$dados['hora']);
            $cad->bindParam(':sala',$dados['sala']);

            $cad->execute();

            if($cad->rowCount()){

                $mensagem="
                <div class='mensagem-sucesso'>
                Ensalamento cadastrado com sucesso!
                </div>";

                unset($dados);

            }else{

                $mensagem="
                <div class='mensagem-erro'>
                Erro ao cadastrar!
                </div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1">

<title>Sistema de Ensalamento</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{

font-family:'Segoe UI',sans-serif;

height:100vh;

overflow:hidden;

background:#050816;

position:relative;

}

/* Fundo tecnológico */

body::before{

content:"";

position:absolute;

width:100%;
height:100%;

background:
radial-gradient(circle at 20% 30%, rgba(0,255,255,.12), transparent 30%),

radial-gradient(circle at 80% 20%, rgba(138,43,226,.15), transparent 30%),

radial-gradient(circle at 60% 80%, rgba(0,80,255,.12), transparent 30%);

animation:pulse 7s infinite alternate;

}

body::after{

content:"";

position:absolute;

width:100%;
height:100%;

background-image:
linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),

linear-gradient(90deg,
rgba(255,255,255,.03) 1px,
transparent 1px);

background-size:40px 40px;

}

@keyframes pulse{

from{
transform:scale(1);
opacity:.5;
}

to{
transform:scale(1.1);
opacity:1;
}

}

/* partículas */

.particle{

position:absolute;

bottom:-50px;

background:cyan;

border-radius:50%;

opacity:.6;

box-shadow:
0 0 10px cyan,
0 0 25px cyan;

animation:subir linear infinite;

z-index:0;

}

@keyframes subir{

0%{
transform:
translateY(0)
translateX(0);

opacity:0;
}

20%{
opacity:1;
}

100%{
transform:
translateY(-120vh)
translateX(100px);

opacity:0;
}

}

/* card */

.box{

position:absolute;

top:50%;
left:50%;

transform:
translate(-50%,-50%);

transform-style:
preserve-3d;

transition:
transform .15s linear;

z-index:5;

width:90%;
max-width:500px;

padding:30px;

border-radius:25px;

background:
rgba(255,255,255,.04);

backdrop-filter:
blur(25px);

border:
1px solid rgba(255,255,255,.08);

box-shadow:
0 0 30px rgba(0,255,255,.2),
0 0 60px rgba(138,43,226,.2);

color:white;

}

fieldset{

border:
1px solid rgba(0,255,255,.4);

padding:20px;

border-radius:20px;

}

legend{

padding:10px 20px;

border-radius:10px;

font-weight:bold;

background:
linear-gradient(
135deg,
#00d4ff,
#6a00ff);

}

/* inputs */

.inputBox{

position:relative;

margin-bottom:25px;

}

.inputUser,
.styled-select{

width:100%;

padding:15px;

background:
rgba(255,255,255,.04);

border:
1px solid rgba(255,255,255,.1);

border-radius:12px;

outline:none;

color:white;

transition:.4s;

}

.inputUser:focus,
.styled-select:focus{

border-color:#00d4ff;

box-shadow:
0 0 15px cyan;

background:
rgba(0,212,255,.06);

}

.labelInput{

position:absolute;

top:15px;
left:15px;

pointer-events:none;

color:#aaa;

transition:.4s;

}

.inputUser:focus~.labelInput,
.inputUser:valid~.labelInput{

top:-10px;

font-size:12px;

color:#00d4ff;

}

/* botão */

#submit{

width:100%;

padding:15px;

border:none;

border-radius:12px;

cursor:pointer;

font-size:16px;

font-weight:bold;

color:white;

background:
linear-gradient(
135deg,
#00d4ff,
#6a00ff);

transition:.4s;

}

#submit:hover{

transform:
translateY(-3px);

box-shadow:
0 0 20px cyan,
0 0 50px #6a00ff;

}

.mensagem-sucesso{

padding:10px;

border-radius:10px;

background:
rgba(0,255,0,.1);

border:1px solid #00ff88;

margin-bottom:15px;

text-align:center;

}

.mensagem-erro{

padding:10px;

border-radius:10px;

background:
rgba(255,0,0,.1);

border:1px solid red;

margin-bottom:15px;

text-align:center;

}

.home-button{

position:absolute;

top:20px;
left:20px;

background:none;

border:none;

cursor:pointer;

z-index:999;

}

.home-icon{

width:40px;

filter:
drop-shadow(0 0 10px cyan);

}

</style>

</head>

<body>

<button class="home-button"
onclick="window.location.href='Pagina_principal.php'">

<img src="home-icon.png"
class="home-icon">

</button>

<div class="box">

<?php
if(isset($mensagem)){
echo $mensagem;
}
?>

<form method="POST">

<fieldset>

<legend>
Cadastro de Ensalamento
</legend>

<br>

<select name="curso"
class="styled-select">

<option>Téc. Desenvolvimento de Sistemas</option>

<option>Téc. Administração</option>

<option>Téc. Alimentos</option>

<option>Téc. Automação Industrial</option>

<option>Téc. Eletroeletrônica</option>

</select>

<br>

<div class="inputBox">

<input
type="text"
name="professor"
class="inputUser"
required>

<label class="labelInput">
Professor
</label>

</div>


<div class="inputBox">

<input
type="date"
name="data"
class="inputUser"
required>

<label class="labelInput">
Data
</label>

</div>


<div class="inputBox">

<input
type="time"
name="hora"
class="inputUser"
required>

<label class="labelInput">
Horário
</label>

</div>


<select
name="sala"
class="styled-select">

<option>Laboratório informática 1</option>

<option>Laboratório informática 2</option>

<option>Simulador 1</option>

<option>Simulador 2</option>

<option>Oficina 1</option>

<option>Oficina 2</option>

</select>

<br><br>

<input
type="submit"
name="submit"
id="submit"
value="Cadastrar">

</fieldset>

</form>

</div>

<script>

/* efeito 3D */

const box=document.querySelector(".box");

document.addEventListener("mousemove",(e)=>{

let x=
(window.innerWidth/2-e.clientX)/35;

let y=
(window.innerHeight/2-e.clientY)/35;

box.style.transform=

`translate(-50%,-50%)
rotateY(${x}deg)
rotateX(${-y}deg)`;

});


/* partículas */

for(let i=0;i<35;i++){

let p=
document.createElement("div");

p.classList.add("particle");

p.style.left=
Math.random()*100+"vw";

p.style.width=
(Math.random()*6+2)+"px";

p.style.height=
p.style.width;

p.style.animationDuration=
(Math.random()*8+4)+"s";

p.style.animationDelay=
Math.random()*5+"s";

document.body.appendChild(p);

}

</script>

</body>
</html>