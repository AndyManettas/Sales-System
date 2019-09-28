"use strict";

function calculateSaleTotal()
{
	//Here we get the total price by calling our function
	var totalPrice = document.getElementById('addSalesItemUnitPrice').value * document.getElementById('addSalesItemQuantity').value;
	console.log("unit price: " + Number(document.getElementById('addSalesItemUnitPrice').textContent));
	console.log("quantity: " + document.getElementById('addSalesItemQuantity').value);
	console.log("total price: " + totalPrice);
	document.getElementById('addSalesTotalPrice').value = totalPrice;
	document.getElementById('addSalesTotalPriceViewer').innerHTML = totalPrice;
}


function init () {
	var quantity = document.getElementById('addSalesItemQuantity')
	quantity.onchange = calculateSaleTotal;
}

window.onload = init;