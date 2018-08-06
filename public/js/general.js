/**
 * [numberWithComma description]
 * @param  {[type]} x [description]
 * @return {[type]}   [description]
 */
function numberWithComma(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$('.price_format').priceFormat({
    prefix: '',
    centsSeparator: '.',
    thousandsSeparator: ',',
    clearOnEmpty: true,
    centsLimit : 0
});