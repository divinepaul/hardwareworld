let productFormHTML = document.querySelectorAll("tr")[1].innerHTML;

function addPurchaseItems(event) {
    let countInput = document.querySelector('input[name="count_input"]');
    let count = parseInt(countInput.value);
    let tbody = document.querySelector("tbody");
    tbody.insertAdjacentHTML("beforeend",replaceNames());
    countInput.value = ++count;
}

function replaceNames() {
    let countInput = document.querySelector('input[name="count_input"]');
    let count = parseInt(countInput.value);
    console.log(productFormHTML);
    return productFormHTML.replaceAll(`0"`,`${count}"`);
}

function openPrintPurchase(){
    let tableState = document.querySelectorAll("tr");

    if(tableState.length > 0){
        let start_date = document.querySelector("input[name='start_date']").value;
        let end_date = document.querySelector("input[name='end_date']").value;
        if(start_date && end_date){
            window.location = `/admin/purchase/print.php?start_date=${start_date}&end_date=${end_date}`;
        } else {
            window.location = `/admin/purchase/print.php`;
        }
    }
}

function openPrintOrders(){
    let tableState = document.querySelectorAll("tr");

    if(tableState.length > 0){
        let start_date = document.querySelector("input[name='start_date']").value;
        let end_date = document.querySelector("input[name='end_date']").value;
        if(start_date && end_date){
            window.location = `/admin/payments/print.php?start_date=${start_date}&end_date=${end_date}`;
        } else {
            window.location = `/admin/payments/print.php`;
        }
    }
}

