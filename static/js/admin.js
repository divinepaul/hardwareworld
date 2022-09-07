let productFormHTML = document.querySelectorAll("tr")[1].innerHTML;

function addPurchaseItems(event) {
    let countInput = document.querySelector('input[name="count_input"]');
    let count = parseInt(countInput.value);
    let tbody = document.querySelector("tbody");
    tbody.insertAdjacentHTML("afterend",replaceNames());
    countInput.value = ++count;
}

function replaceNames() {
    let countInput = document.querySelector('input[name="count_input"]');
    let count = parseInt(countInput.value);
    console.log(productFormHTML);
    return productFormHTML.replaceAll(`0"`,`${count}"`);
}
