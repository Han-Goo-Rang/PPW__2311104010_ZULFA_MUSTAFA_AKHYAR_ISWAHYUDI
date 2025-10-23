// Fungsi untuk handle jika gambar gagal dimuat
function handleImageError(image) {
  // Ganti dengan gambar placeholder jika ada, atau sembunyikan
  image.src = 'https://via.placeholder.com/400x300?text=Image+Not+Found';
  console.error('Gagal memuat gambar:', image.alt);
}

// Fungsi untuk menampilkan/menyembunyikan detail produk
function toggleDetail(element) {
  // Cari parent .card terdekat
  const card = element.closest('.card');
  if (card) {
    // Cari elemen detail di dalam card tersebut
    const detailText = card.querySelector('.detail-text');
    if (detailText) {
      // Toggle display
      if (detailText.style.display === 'none' || detailText.style.display === '') {
        detailText.style.display = 'block';
      } else {
        detailText.style.display = 'none';
      }
    }
  }
}

// jQuery masih bisa digunakan jika diperlukan
$(document).ready(function(){
  console.log("Dokumen siap dengan Bootstrap dan jQuery!");
});