<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubli - Reset Password</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            display: grid;
            height: 100%;
            width: 100%;
            place-items: center;
            background: -webkit-linear-gradient(left, #689502, #72BF44, #0fc98bff, #13a650ff);
        }

        ::selection {
            background: #1a75ff;
            color: #fff;
        }

        .wrapper {
            overflow: hidden;
            width: 390px;
            max-width: 95%;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
        }

        .wrapper .title {
            font-size: 30px;
            font-weight: 600;
            text-align: center;
        }

        .wrapper .subtitle {
            text-align: center;
            color: #777;
            font-size: 14px;
            margin-top: 10px;
        }

        form .field {
            height: 50px;
            width: 100%;
            margin-top: 20px;
            position: relative;
        }

        form .field input {
            height: 100%;
            width: 100%;
            outline: none;
            padding-left: 15px;
            padding-right: 45px;
            border-radius: 15px;
            border: 1px solid lightgrey;
            border-bottom-width: 2px;
            font-size: 17px;
            transition: all 0.3s ease;
        }

        form .field input[readonly] {
            background: #f5f5f5;
            color: #888;
        }

        form .field .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 18px;
            user-select: none;
        }

        form .field .password-toggle:hover {
            color: #689502;
        }

        form .field input:focus {
            border-color: #689502;
        }

        form .field input::placeholder {
            color: #999;
            transition: all 0.3s ease;
        }

        form .field input:focus::placeholder {
            color: #689502;
        }

        form .btn {
            height: 50px;
            width: 100%;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }

        form .btn .btn-layer {
            height: 100%;
            width: 300%;
            position: absolute;
            left: -100%;
            background: -webkit-linear-gradient(right, #689502, #689502, #689502, #689502);
            border-radius: 15px;
            transition: all 0.4s ease;
        }

        form .btn:hover .btn-layer {
            left: 0;
        }

        form .btn input[type="submit"] {
            height: 100%;
            width: 100%;
            z-index: 1;
            position: relative;
            background: none;
            border: none;
            color: #fff;
            padding-left: 0;
            border-radius: 15px;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
        }

        .back-link a {
            color: #1a75ff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .alert {
            margin-top: 15px;
            padding: 12px 15px;
            border-radius: 10px;
            font-size: 14px;
            text-align: center;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .alert-error {
            background: #fdecea;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .text-danger {
            color: #c62828;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="title">Reset Password</div>
        <div class="subtitle">Set a new password for your account.</div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="field">
                <input type="email" name="email" placeholder="Enter Email" value="{{ old('email', $email) }}" {{ $email ? 'readonly' : '' }} required>
            </div>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="field">
                <input type="password" name="password" id="password" placeholder="New Password (min 8 characters)" required>
                <span class="password-toggle" onclick="togglePassword('password', this)">👁️</span>
            </div>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="field">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm New Password" required>
                <span class="password-toggle" onclick="togglePassword('password_confirmation', this)">👁️</span>
            </div>
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="field btn">
                <div class="btn-layer"></div>
                <input type="submit" value="Reset Password">
            </div>
            <div class="back-link"><a href="{{ route('login') }}">&larr; Back to Login</a></div>
        </form>
    </div>

    <script>
        function togglePassword(inputId, toggleElement) {
            const input = document.getElementById(inputId);
            if (!input) return;

            if (input.type === "password") {
                input.type = "text";
                toggleElement.textContent = "🙈";
            } else {
                input.type = "password";
                toggleElement.textContent = "👁️";
            }
        }
    </script>
</body>
</html>
