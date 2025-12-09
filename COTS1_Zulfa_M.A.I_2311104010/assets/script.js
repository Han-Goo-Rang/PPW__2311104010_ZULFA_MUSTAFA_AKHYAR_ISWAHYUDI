function handleImageError(image) {
  image.src = "https://via.placeholder.com/400x300?text=Image+Not+Found";
  console.warn("Gagal memuat gambar:", image.alt);
}

$(document).ready(function () {
  console.log("Dokumen siap dengan jQuery dan Bootstrap!");

  $(document).on("click", ".add-cart-btn", function () {
    const toastEl = document.getElementById("cartToast");
    if (toastEl) {
      const toast = new bootstrap.Toast(toastEl, { delay: 2000 });
      toast.show();
    }
  });

  $("<button/>", {
    id: "toTopBtn",
    class: "btn btn-custom-pink position-fixed",
    html: "↑",
    style: "bottom:20px; right:20px; display:none; z-index:10;",
    click: function () {
      $("html, body").animate({ scrollTop: 0 }, "slow");
    },
  }).appendTo("body");

  $(window).scroll(function () {
    if ($(this).scrollTop() > 200) $("#toTopBtn").fadeIn();
    else $("#toTopBtn").fadeOut();
  });

  let products = [];

  // Load products from API on index page
  if (
    window.location.pathname.includes("index.html") ||
    window.location.pathname.endsWith("/")
  ) {
    loadProductsFromAPI();

    $("#searchInput").on("keyup", function () {
      const keyword = $(this).val().toLowerCase();
      $("#productList .card").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
      });
    });
  }

  async function loadProductsFromAPI() {
    products = await fetchAllProducts();
    if (products.length === 0) {
      console.warn("No products loaded from API");
    }
  }

  if (window.location.pathname.includes("detail.html")) {
    loadDetailPageFromAPI();
  }

  async function loadDetailPageFromAPI() {
    const params = new URLSearchParams(window.location.search);
    const id = parseInt(params.get("id")) || 1;

    // Fetch specific product
    const product = await fetchProductById(id);

    if (!product) {
      console.error("Product not found");
      return;
    }

    $("#productName").text(product.name);
    $("#productPrice").text(product.price);
    $("#productDesc").text(product.description);

    const carouselContainer = $("#carouselImages");
    const images = product.images || [];

    if (images.length === 0) {
      carouselContainer.append(`
        <div class="carousel-item active">
          <img src="https://via.placeholder.com/400x300?text=No+Image" class="d-block w-100" alt="${product.name}">
        </div>
      `);
    } else {
      images.forEach((src, i) => {
        const active = i === 0 ? "active" : "";
        carouselContainer.append(`
          <div class="carousel-item ${active}">
            <img src="assets/img/${src}" class="d-block w-100" alt="${product.name}" onerror="handleImageError(this)">
          </div>
        `);
      });
    }

    // Load recommendations
    const allProducts = await fetchAllProducts();
    const recContainer = $("#recommendations");
    if (recContainer.length) {
      const recs = allProducts
        .filter((p) => p.id !== product.id)
        .sort(() => 0.5 - Math.random())
        .slice(0, 3);
      recs.forEach((r) => {
        const recImage =
          r.images && r.images.length > 0
            ? r.images[0]
            : "https://via.placeholder.com/300x200?text=No+Image";
        recContainer.append(`
          <div class="col-6 col-md-4">
            <div class="card glass text-center recommendation-card h-100">
              <a href="detail.html?id=${r.id}">
                <img src="assets/img/${recImage}" class="card-img-top" alt="${r.name}" onerror="handleImageError(this)">
              </a>
              <div class="card-body">
                <h6 class="fw-bold">${r.name}</h6>
                <p class="text-custom-pink fw-semibold mb-1">${r.price}</p>
                <button class="btn btn-sm btn-custom-pink add-cart-btn">Tambah ke Keranjang</button>
              </div>
            </div>
          </div>
        `);
      });
    }
  }
});
