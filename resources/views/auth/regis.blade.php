<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- Leaflet -->
    <link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
    <!-- icon -->
    <script src="https://kit.fontawesome.com/26af10689e.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-image: url("assets/img/landing_page/pexels-mikhail-nilov-6965540.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }

    </style>

</head>

<body>
    {{-- create a card in the middle of the page --}}
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3>Daftar</h3>
                        <p class="mb-5">Hi Petani, Silahkan Daftar</p>
                        <form action="{{ route('authRegis') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Sudah Punya Akun ? <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-black">Login</a></p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>
