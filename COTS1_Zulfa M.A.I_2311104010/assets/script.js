function handleImageError(image) {
  image.src = 'https://via.placeholder.com/400x300?text=Image+Not+Found';
  console.warn('Gagal memuat gambar:', image.alt);
}

$(document).ready(function () {
  console.log("Dokumen siap dengan jQuery dan Bootstrap!");

  $(document).on("click", ".add-cart-btn", function () {
    const toastEl = document.getElementById('cartToast');
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
    click: function () { $("html, body").animate({ scrollTop: 0 }, "slow"); }
  }).appendTo("body");

  $(window).scroll(function () {
    if ($(this).scrollTop() > 200) $("#toTopBtn").fadeIn();
    else $("#toTopBtn").fadeOut();
  });

  if (window.location.pathname.includes("index.html") || window.location.pathname.endsWith("/")) {
    $("#searchInput").on("keyup", function () {
      const keyword = $(this).val().toLowerCase();
      $("#productList .card").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
      });
    });
  }
  const products = [
    { id: 1, name: "Heavenly Zoran - Shadow", price: "Rp 740.000", img: ["Art1.jpeg", "Art2.jpeg", "Art3.jpeg"], desc: "Gaya elegan bernuansa misterius dengan bahan satin lembut dan ringan." },
    { id: 2, name: "Heavenly Zoran - Shaolin", price: "Rp 710.100", img: ["Art2.jpeg", "Art3.jpeg", "Art4.jpeg"], desc: "Perpaduan desain oriental modern dengan nuansa lembut." },
    { id: 3, name: "Heavenly Zoran - Enlight", price: "Rp 820.000", img: ["Art3.jpeg", "Art4.jpeg", "Art5.jpeg"], desc: "Memberikan kesan bercahaya dengan material berkilau lembut." },
    { id: 4, name: "Heavenly Candra", price: "Rp 930.000", img: ["Art4.jpeg", "Art5.jpeg", "Art6.jpeg"], desc: "Elegan dan klasik, cocok untuk acara malam hari." },
    { id: 5, name: "Heavenly Chaos", price: "Rp 930.000", img: ["Art5.jpeg", "Art6.jpeg", "Art7.jpeg"], desc: "Desain berani yang melambangkan keunikan dan ekspresi diri." },
    { id: 6, name: "Heavenly Armanth", price: "Rp 890.000", img: ["Art6.jpeg", "Art7.jpeg", "Art8.jpeg"], desc: "Motif abstrak berwarna hangat dengan bahan premium." },
    { id: 7, name: "Heavenly Shades", price: "Rp 925.000", img: ["Art7.jpeg", "Art8.jpeg", "Art10.jpeg"], desc: "Tampilan gradasi lembut memberi kesan menenangkan." },
    { id: 8, name: "Heavenly Ayaskara", price: "Rp 970.000", img: ["Art8.jpeg", "Art10.jpeg", "Art1.jpeg"], desc: "Perpaduan desain modern dan tradisional dalam satu karya." },
    { id: 9, name: "Heavenly Gaia - Cassandra", price: "Rp 1.000.000", img: ["Art10.jpeg"], desc: "Perpaduan desain klasikal dan surealisme." }
  ];

  if (window.location.pathname.includes("detail.html")) {
    const params = new URLSearchParams(window.location.search);
    const id = parseInt(params.get("id")) || 1;
    const product = products.find(p => p.id === id) || products[0];

    $("#productName").text(product.name);
    $("#productPrice").text(product.price);
    $("#productDesc").text(product.desc);

    const carouselContainer = $("#carouselImages");
    product.img.forEach((src, i) => {
      const active = i === 0 ? "active" : "";
      carouselContainer.append(`
        <div class="carousel-item ${active}">
          <img src="assets/img/${src}" class="d-block w-100" alt="${product.name}" onerror="handleImageError(this)">
        </div>
      `);
    });

    const recContainer = $("#recommendations");
    if (recContainer.length) {
      const recs = products.filter(p => p.id !== product.id).sort(() => 0.5 - Math.random()).slice(0, 3);
      recs.forEach(r => {
        recContainer.append(`
          <div class="col-6 col-md-4">
            <div class="card glass text-center recommendation-card h-100">
              <a href="detail.html?id=${r.id}">
                <img src="assets/img/${r.img[0]}" class="card-img-top" alt="${r.name}" onerror="handleImageError(this)">
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
