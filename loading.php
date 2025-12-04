<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Data dengan Loading</title>
    <style>
        /* CSS untuk animasi loading */
        .loading {
            display: none;
            width: 100px;
            height: 100px;
            border: 16px solid #f3f3f3; /* Grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            animation: spin 2s linear infinite;
            margin: 50px auto;
        }

        /* Animasi rotasi */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Tampilan untuk hasil pencarian */
        #result {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Form Pencarian -->
    <form id="searchForm">
        <input type="text" id="searchQuery" name="query" placeholder="Cari data..." required>
        <button type="submit">Cari</button>
    </form>

    <!-- Elemen Loading -->
    <div class="loading" id="loading"></div>

    <!-- Tempat untuk menampilkan hasil pencarian -->
    <div id="result"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function(){
            // Ketika form pencarian disubmit
            $('#searchForm').submit(function(e){
                e.preventDefault();
                var query = $('#searchQuery').val(); // Ambil query dari input

                // Tampilkan animasi loading
                $('#loading').show();

                // Lakukan AJAX untuk mengirim pencarian ke server PHP
                $.ajax({
                    url: 'search.php',
                    type: 'GET',
                    data: { query: query },
                    success: function(response){
                        // Sembunyikan loading setelah mendapatkan respon
                        $('#loading').hide();

                        // Tampilkan hasil pencarian
                        $('#result').html(response);
                    }
                });
            });
        });
    </script>

</body>
</html>
