"use strict";

function calculateSaleTotal()
{
	//Here we get the total price by calling our function
	var totalPrice = document.getElementById('salesItemUnitPrice').value * document.getElementById('salesItemQuantity').value;

	document.getElementById('salesTotalPrice').innerHTML = totalPrice;
	return totalPrice;
}


function init () {
	var unitPrice = document.getElementById('salesItemUnitPrice')
	var quantity = document.getElementById('salesItemQuantity')
	unitPrice.onchange = calculateSaleTotal;
	quantity.onchange = calculateSaleTotal;
}

window.onload = init;