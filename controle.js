// pre loader inicio
function loading() {
	document.getElementsByClassName('box-load')[0].style.display = "none";
	document.getElementsByClassName('conteudo-loader')[0].style.display = "block";

	}
// pre loader fim

$(document).ready(() => {	
	$('#documentacao').on('click',() => {		
		$.post('documentacao.php', data => {
			$('#conteudo').html(data)
		})
	})

})
