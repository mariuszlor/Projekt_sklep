function priceformat(e) {
	e.value=(1.0*e.value.replace(/[^0-9.]/g,'')).toFixed(2);
}
function nformat(e) {
	e.value=e.value.replace(/[^0-9.]/g,'');
}
function intformat(e) {
	e.value=1*e.value.replace(/[^0-9.]/g,'');
}