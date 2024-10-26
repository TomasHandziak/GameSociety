function searchProducts() {
    const input = document.getElementById('searchBar').value.toLowerCase();
    const products = document.querySelectorAll('.product-card');

    products.forEach(product => {
        const title = product.querySelector('h2').textContent.toLowerCase();
        if (title.includes(input)) {
            product.style.display = '';
        } else {
            product.style.display = 'none';
        }
    });
}

function filterProducts() {
    const category = document.getElementById('filterCategory').value;
    const products = document.querySelectorAll('.card');

    products.forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = '';
        } else {
            product.style.display = 'none';
        }
    });
}

document.getElementById('toggleView').addEventListener('click', function() {
    var container = document.getElementById('productContainer');
    var cards = document.querySelectorAll('.card');
    var icon = document.getElementById('btnIcon');

    if (container.classList.contains('table-view')) {
        container.classList.remove('table-view');
        container.classList.add('list-view');
        console.log(icon);      
        icon.classList.remove('fa-list');
        icon.classList.add('fa-table');

        cards.forEach(function(card) {
            if (card.classList.contains('product-card')) {
                card.classList.remove('product-card');
                card.classList.add('product-card-list');
            }
        });
        
    } else {
        container.classList.remove('list-view');
        container.classList.add('table-view'); 
        icon.classList.remove('fa-table');
        icon.classList.add('fa-list');

        cards.forEach(function(card) {
            if (card.classList.contains('product-card-list')) {
                card.classList.remove('product-card-list');
                card.classList.add('product-card');
            }
        });
    }
});


document.querySelector(".dropbtn").addEventListener("click", function() {
    var dropdown = document.querySelector(".dropdown-content");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
  });
  
  // Para cerrar el menú si el usuario hace clic fuera de él
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.style.display === "block") {
          openDropdown.style.display = "none";
        }
      }
    }
  };




// carrito

const btnCart = document.querySelector('.container-cart-icon');
const containerCartProducts = document.querySelector('.container-cart-products');


btnCart.addEventListener('click', () => {
    containerCartProducts.classList.toggle('hidden-cart')
})

const cartInfo =  document.querySelector(".cart-product");
const rowProduct = document.querySelector(".row-product");
const productsList = document.getElementById("productContainer");


let allProducts = [];

const valorTotal = document.querySelector('.total-pagar');

const countProduct = document.querySelector('#contador-productos');


productsList.addEventListener('click', e => {

    if(e.target.classList.contains('btn-add-cart')){
        const product = e.target.parentElement

        const infoProduct = {
            quantity: 1,
            title: product.querySelector('.titleProduct').textContent,
            price: product.querySelector('.price').textContent,
        };

        const exist = allProducts.some(product => product.title === infoProduct.title)

        if(exist) {
            const products = allProducts.map(product =>{
                if(product.title === infoProduct.title){
                    product.quantity++
                    return product
                } else {
                    return product
                }
            })

            allProducts = [...products];
        } else {
            allProducts = [...allProducts, infoProduct];
        }
    
        showHTML();
    }


})


rowProduct.addEventListener('click', e => {
    if(e.target.classList.contains('icon-close')){
        const product = e.target.parentElement;
        const title = product.querySelector('p').textContent;
    
        allProducts = allProducts.filter(
            product => product.title !== title
        );

        showHTML()
    }
})

console.log("click");


const btnFinalizarCompra = document.getElementById('finalizar-compra');

btnFinalizarCompra.addEventListener('click', () => {
    console.log("click");

    localStorage.setItem('productosCarrito', JSON.stringify(allProducts));
    window.location = 'checkout.php';  // Redirige a la página de checkout
});




const showHTML  = () => {

    if(!allProducts.length){
        containerCartProducts.innerHTML=`
        <p class="cart-empty">EL carrito esta vacio</p>
        `;
    }

    rowProduct.innerHTML= '';

    let total = 0;
    let totalOfProduct = 0;


    allProducts.forEach(product => {
        const containerProduct = document.createElement('div')
        containerProduct.classList.add('cart-product')
        
        containerProduct.innerHTML = `
            <div class="info-cart-product">
                <span class="cantidad-producto-carrito">${product.quantity}</span>
                <p class="titulo-producto-carrito">${product.title}</p>
                <span class="precio-producto-carrito">${product.price}</span>
            </div>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="icon-close"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        `


        rowProduct.append(containerProduct)

        total = total + parseInt(product.quantity * product.price.slice(1))

        totalOfProduct = totalOfProduct + product.quantity; 
    })

    valorTotal.innerText =  `${total}`;
    countProduct.innerText = totalOfProduct;

};