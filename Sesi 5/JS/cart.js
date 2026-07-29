const cartItems = document.getElementById("cart-items");

let cart = JSON.parse(localStorage.getItem("cart")) || [];

function formatRupiah(number){

    return new Intl.NumberFormat("id-ID",{

        style:"currency",

        currency:"IDR"

    }).format(number);

}

function saveCart(){

    localStorage.setItem("cart",JSON.stringify(cart));

}

function renderCart(){

    cartItems.innerHTML="";

    let total=0;

    if(cart.length===0){

        cartItems.innerHTML=`

        <div class="alert alert-warning">

        Keranjang masih kosong.

        </div>

        `;

        document.getElementById("grand-total").textContent="Rp0";

        return;

    }

    cart.forEach(item=>{

        total += item.price * item.qty;

        cartItems.innerHTML += `

<div class="card mb-3">
    <div class="card-body">

        <div class="row align-items-center">

        <div class="col-md-2">
        <img src="${item.image}" class="img-fluid">

        </div>

        <div class="col-md-4">

        <h5>${item.name}</h5>

    <p>${item.category}</p>

    </div>

    <div class="col-md-2">

    ${formatRupiah(item.price)}

    </div>

    <div class="col-md-2">

    <input

    type="number"

    min="1"

    value="${item.qty}"

    class="form-control"

    onchange="changeQty(${item.id},this.value)">

</div>

<div class="col-md-2 text-end">

<button

class="btn btn-danger"

onclick="removeItem(${item.id})">

Hapus

</button>

</div>

</div>

</div>

</div>

`;

    });

    document.getElementById("grand-total").textContent =

        formatRupiah(total);

}

function changeQty(id,qty){

    qty=parseInt(qty);

    const item=cart.find(item=>item.id===id);

    if(item){

        item.qty=qty;

        saveCart();

        renderCart();

    }

}

function removeItem(id){

    cart=cart.filter(item=>item.id!==id);

    saveCart();

    renderCart();

}

renderCart();
