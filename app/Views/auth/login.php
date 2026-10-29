<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/gif" href="<?= base_url('assets/logo110.gif') ?>">
    <title>Login - Student Management</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            font-family: Arial, sans-serif;

            background: #f4f6f9;
        }

        .login-container {
            width: 400px;

            padding: 35px;

            background: white;

            border-radius: 12px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .login-container h1 {
            margin: 0 0 8px;

            text-align: center;

            color: #1f2937;
        }

        .login-container .subtitle {
            margin-bottom: 30px;

            text-align: center;

            color: #6b7280;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;

            margin-bottom: 8px;

            font-weight: 600;

            color: #374151;
        }

        .form-group input {
            width: 100%;

            padding: 12px 14px;

            border: 1px solid #d1d5db;

            border-radius: 7px;

            font-size: 14px;

            outline: none;
        }

        .form-group input:focus {
            border-color: #2563eb;
        }

        .btn-login {
            width: 100%;

            padding: 12px;

            border: none;

            border-radius: 7px;

            background: #2563eb;

            color: white;

            font-size: 15px;

            font-weight: 600;

            cursor: pointer;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .alert {
            padding: 12px;

            margin-bottom: 20px;

            border-radius: 7px;

            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;

            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;

            color: #166534;
        }

    </style>

</head>

<body>

    <div class="login-container">

        <h1>Student Management</h1>

        <div class="subtitle">
            Permata Bangsa School
        </div>


        <?php if (session()->getFlashdata('error')): ?>

            <div class="alert alert-error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>

        <?php endif; ?>


        <?php if (session()->getFlashdata('success')): ?>

            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>

        <?php endif; ?>


        <form action="<?= base_url('login') ?>" method="post">

            <?= csrf_field() ?>

            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan username"
                    value="<?= old('username') ?>"
                    required
                    autofocus
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn-login"
            >
                Login
            </button>

        </form>

    </div>

</body>

</html>