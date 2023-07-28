const html = document.documentElement;


//Mudar o tema e salvar a escolha
function esquema() {

    if (html.getAttribute('data-bs-theme') == 'dark') {
        html.setAttribute('data-bs-theme', 'light');
        sessionStorage.setItem('tema', 'light');
        document.getElementById("botao").setAttribute("name", "moon");
        document.getElementById("botao").setAttribute("color", "#000000");
        document.querySelector(".icone").setAttribute("color", "#000000");
        document.querySelector(".icone1").setAttribute("color", "#000000");
        document.querySelector(".icone2").setAttribute("color", "#000000");
    } else {
        html.setAttribute('data-bs-theme', 'dark');
        sessionStorage.setItem('tema', 'dark'); 
        document.getElementById("botao").setAttribute("name", "sun");
        document.getElementById("botao").setAttribute("color", "#ffffff");
        document.querySelector(".icone").setAttribute("color", "#ffffff");
        document.querySelector(".icone1").setAttribute("color", "#ffffff");
        document.querySelector(".icone2").setAttribute("color", "#ffffff");
    }
}

// onload da página (tipo docready) verificar se já há um item da sessionstorage chamado tema, se sim, atribiuir isso ao tema, e verificar se é dark ou light para atualizar icones
// de acordo
window.onload = function() {

    const tema = sessionStorage.getItem('tema');
    
    if (tema) {
        html.setAttribute('data-bs-theme', tema);
        

        if (tema == 'dark') {
            document.getElementById("botao").setAttribute("name", "sun");
            document.getElementById("botao").setAttribute("color", "#ffffff");
            document.querySelector(".icone").setAttribute("color", "#ffffff");
            document.querySelector(".icone1").setAttribute("color", "#ffffff");
            document.querySelector(".icone2").setAttribute("color", "#ffffff");
        } else {
            document.getElementById("botao").setAttribute("name", "moon");
            document.getElementById("botao").setAttribute("color", "#000000");
            document.querySelector(".icone").setAttribute("color", "#000000");
            document.querySelector(".icone1").setAttribute("color", "#000000");
            document.querySelector(".icone2").setAttribute("color", "#000000");
        }
    } else {

        html.setAttribute('data-bs-theme', 'light');
        document.getElementById("botao").setAttribute("name", "moon");
        document.getElementById("botao").setAttribute("color", "#000000");
        document.querySelector(".icone").setAttribute("color", "#000000");
        document.querySelector(".icone1").setAttribute("color", "#000000");
        document.querySelector(".icone2").setAttribute("color", "#000000");
    }
}

