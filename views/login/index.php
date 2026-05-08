<!doctype html>
<html lang="es">
<head>
    <?php require_once("../Main/mainhead.php") ?>
    <title>Banca Unión - Login</title>

    <style>
        :root {
            --deep: #26215C;
            --royal: #3C3489;
            --brand: #534AB7;
            --mid: #7F77DD;
            --lavender: #CECBF6;
            --ghost: #EEEDFE;
            --text-dark: #26215C;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: system-ui, -apple-system, sans-serif;
            background-color: var(--ghost);
        }

        /* Layout centrado limpio */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Card minimalista */
        .login-card {
            width: 100%;
            max-width: 380px;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
        }

        h4 {
            text-align: center;
            color: var(--royal);
            margin-bottom: 25px;
        }

        .form-control {
            border: 1px solid var(--lavender);
            border-radius: 8px;
            padding: 10px;
        }

        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 2px rgba(83, 74, 183, 0.15);
        }

        .btn-login {
            background-color: var(--brand);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            transition: background 0.2s;
        }

        .btn-login:hover {
            background-color: var(--mid);
        }

        label {
            font-size: 0.85rem;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

    </style>
</head>

<body>

<div class="login-wrapper">
    <div class="login-card">

        <img src="../../public/images/LOGO_BANCA_UNION.png" height="90" class="logo">

        <h4>Iniciar Sesión</h4>

        <div class="mb-3">
            <label>Correo</label>
            <input type="text" class="form-control" id="email">
        </div>

        <div class="mb-4">
            <label>Contraseña</label>
            <input type="password" class="form-control" id="password">
        </div>

        <button class="btn-login" id="btnIngresar">
            Ingresar
        </button>

    </div>
</div>

<?php require_once("../Main/mainjs.php"); ?>
<script src="./login.js"></script>

</body>
</html>