function add(quantiteVoulu, stockMax, fctAjouter, fctEnlever) { 
    var stockString = document.getElementById(stockMax).innerHTML;
    var stockNum = Number(stockString.match(/\d+/g).join(''));
    
    if (document.getElementById(quantiteVoulu).value < stockNum ) {
        document.getElementById(quantiteVoulu).value ++;
        document.getElementById(fctEnlever).disabled = '';
    }
    
    if (document.getElementById(quantiteVoulu).value == (stockNum)) {
        document.getElementById(fctAjouter).disabled = 'disabled';
    }
}
    
function substract(quantiteVoulu, fctAjouter, fctEnlever) { 
    if ( document.getElementById(quantiteVoulu).value > 0 )
        document.getElementById(quantiteVoulu).value --; 
        document.getElementById(fctAjouter).disabled = '';
    
    if (document.getElementById(quantiteVoulu).value == 0) {
        document.getElementById(fctEnlever).disabled = 'disabled';
    }
}

function cacherStcok(stockACacher) {
    var span = document.getElementsByClassName(stockACacher);
    for (var num=0, max=span.length; num<max; num++) {
        if(span[num].style.display == "" ) {
            span[num].style.display = "table-cell";
            document.getElementById('fctCacher').innerHTML = "Cacher Stock";
        }
        else {
            span[num].style.display = "";
            document.getElementById('fctCacher').innerHTML = "Afficher Stock";
        }
    }
}