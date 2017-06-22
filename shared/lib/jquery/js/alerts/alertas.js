// ActionScript Remote Document
//alert()

function alert_msj(titulo,texto,tipo){
	jAlert(texto, titulo);
}
	
function confirm_msj(titulo,texto,funcion_x){
	jConfirm(texto, titulo, funcion_x);
}

function prompt_msj(titulo,valor_predeterminado,texto,funcion_x){
	jPrompt(texto,valor_predeterminado,titulo, funcion_x);
}

/*
var oAlert = alert;
function alert(txt, title) {
    try {
        jAlert(txt, title);
    } catch (e) {
        oAlert(txt);
    }
}


alert("Hola", "Prueba");

//confirm()
var oConfirm = confirm;
function confirm(txt, title, func) {
    try {
        jConfirm(txt, title, func);
    } catch (e) {
        if (oConfirm (txt, title)) func();
    }
}

confirm("Hola", "Prueba", function(){
	alert("Prueba", "Superada");
});

//prompt()
var oPrompt = prompt;
function prompt(txt, input, title, func){
    try {
        jPrompt(txt, input, title, func);
    } catch(e) {
        func(prompt(txt, input, title));
    }
}

prompt("Hola", "Valor", "Prueba", function(r) {
	if (r) alert(r);
});
*/