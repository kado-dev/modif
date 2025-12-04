<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animasi Loading Menarik</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Animasi titik berkedip */
        .dots {
            display: inline-block;
            font-size: 2rem;
            animation: blink 1.5s infinite;
        }

        .dots span {
            animation: blink 1.5s infinite;
            animation-delay: calc(0.2s * var(--i));
        }

        .dots span:nth-child(1) {
            --i: 0;
        }

        .dots span:nth-child(2) {
            --i: 1;
        }

        .dots span:nth-child(3) {
            --i: 2;
        }

        /* Animasi kedip */
        @keyframes blink {
            0%, 50%, 100% {
                opacity: 0;
            }
            25%, 75% {
                opacity: 1;
            }
        }

        .loading-container {
            display: none;  /* Awalnya disembunyikan */
            text-align: center;
            margin-top: 50px;
            font-size: 1.5rem;
        }

        .data-container {
            display: none;  /* Awalnya disembunyikan */
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Tempat animasi loading -->
    <div id="loadingContainer" class="loading-container">
        <div class="dots">
            <span>.</span><span>.</span><span>.</span>
        </div>
        <p>Memuat data, harap tunggu...</p>
    </div>

    <!-- Tempat untuk menampilkan data -->
    <div id="dataContainer" class="data-container alert alert-info" role="alert">
        <!-- Data akan ditampilkan di sini -->
    </div>

    <!-- Tombol untuk memulai proses loading -->
    <button id="loadDataBtn" class="btn btn-primary">Muati Data</button>
</div>

<!-- Link ke Bootstrap JS dan Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // Ketika tombol 'Muati Data' ditekan
    $("#loadDataBtn").click(function() {
        // Menampilkan animasi loading
        $("#loadingContainer").show();
        $("#dataContainer").hide(); // Sembunyikan data sebelumnya

        // Simulasikan proses loading data dengan delay
        setTimeout(function() {
            // Sembunyikan animasi loading
            $("#loadingContainer").hide();
            
            // Menampilkan data yang berhasil dimuat
            $("#dataContainer").text("Data berhasil dimuat!").show();
        }, 3000); // Simulasi proses loading selama 3 detik
    });
});
</script>

</body>
</html>
