"use strict";

function calculateAddSaleTotal()
{
	//Here we get the total price by calling our function
	var addTotalPrice = document.getElementById('addSalesItemUnitPrice').value * document.getElementById('addSalesItemQuantity').value;
	console.log("unit price: " + Number(document.getElementById('addSalesItemUnitPrice').value));
	console.log("quantity: " + document.getElementById('addSalesItemQuantity').value);
	console.log("total price: " + addTotalPrice);
	document.getElementById('addSalesTotalPrice').value = addTotalPrice;
	document.getElementById('addSalesTotalPriceViewer').innerHTML = addTotalPrice;
}
	
function calculateEditSaleTotal()
{
	var editTotalPrice = document.getElementById('editSalesItemUnitPrice').value * document.getElementById('editSalesItemQuantity').value;
	console.log("unit price: " + Number(document.getElementById('editSalesItemUnitPrice').value));
	console.log("quantity: " + document.getElementById('editSalesItemQuantity').value);
	console.log("total price: " + editTotalPrice);
	document.getElementById('editSalesTotalPrice').value = editTotalPrice;
	document.getElementById('editSalesTotalPriceViewer').innerHTML = editTotalPrice;
}


function init () {
	var addQuantity = document.getElementById('addSalesItemQuantity')
	var editQuantity = document.getElementById('editSalesItemQuantity')
	addQuantity.onclick = calculateAddSaleTotal;
	editQuantity.onclick = calculateEditSaleTotal;
}

window.onload = init;