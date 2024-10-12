<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #222D32;
            font-family: 'Roboto', sans-serif;
        }

        .login-box {
            margin-top: 50px;
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: #1A2226;
            text-align: center;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-key {
            height: 100px;
            font-size: 80px;
            line-height: 100px;
            background: -webkit-linear-gradient(#27EF9F, #0DB8DE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            /* animation: bounce 2s infinite; */
        }

        /* @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        } */

        .login-title {
            margin-top: 15px;
            font-size: 30px;
            letter-spacing: 2px;
            font-weight: bold;
            background: -webkit-linear-gradient(#27EF9F, #0DB8DE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-form {
            margin-top: 25px;
            text-align: left;
        }

        input[type=email],
        input[type=password] {
            background-color: #1A2226;
            border: none;
            border-bottom: 2px solid #0DB8DE;
            border-radius: 0px;
            font-weight: bold;
            outline: 0;
            color: #ECF0F5;
            transition: border-color 0.3s;
        }

        .form-group {
            margin-bottom: 40px;
        }

        .form-control:focus {
            border-color: inherit;
            -webkit-box-shadow: none;
            box-shadow: none;
            border-bottom: 2px solid #FF5733;
            /* Color change on focus */
            background-color: #1A2226;
            color: #ECF0F5;
        }

        .form-control-label {
            font-size: 10px;
            color: #6C6C6C;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .btn-outline-primary {
            border-color: #0DB8DE;
            color: #0DB8DE;
            border-radius: 0px;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: background-color 0.3s, color 0.3s;
<<<<<<< HEAD
            /* animation: pulse 2s infinite; */
=======
           /* animation: pulse 2s infinite; */
>>>>>>> 9c148faa03373b20c85430f50b589470dd4cfe44
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(0, 184, 222, 0.5);
            }

            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 20px rgba(0, 184, 222, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(0, 184, 222, 0);
            }
        }

        .btn-outline-primary:hover {
            background-color: #0DB8DE;
            color: #ffffff;
        }

        .login-btm {
            text-align: right;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <main>
        <div class="container d-flex justify-content-center">
            <div class="login-box">
                <div class="login-key">
                    <i class="bi bi-person-fill-lock"></i>
                </div>
                <div class="login-title">
                    ADMIN PANEL
                </div>
                <div class="login-form">
                    @if (session('error'))
<<<<<<< HEAD
                        <div class="alert alert-danger" id="successMessage">
                            {{ session('error') }}
                        </div>
=======
                    <div class="alert alert-danger" id="successMessage">
                        {{ session('error') }}
                    </div>
>>>>>>> 9c148faa03373b20c85430f50b589470dd4cfe44
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="form-control-label">EMAIL</label>
<<<<<<< HEAD
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
=======
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
>>>>>>> 9c148faa03373b20c85430f50b589470dd4cfe44
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-control-label">PASSWORD</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="current-password">
                            @error('password')
<<<<<<< HEAD
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
=======
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
>>>>>>> 9c148faa03373b20c85430f50b589470dd4cfe44
                            @enderror
                        </div>
                        <div class="login-btm">
                            <button type="submit" class="btn btn-outline-primary">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 9c148faa03373b20c85430f50b589470dd4cfe44
