<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/assets/bulma.min.css">
    <style>
        body {
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-box {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .flash {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-weight: 500;
        }
        .flash-success { background: #d1ffd8; border-left: 4px solid #23d160; }
        .flash-error { background: #ffe2e2; border-left: 4px solid #ff3860; }
    </style>
</head>
<body>

<div class="login-box">
    <h1 class="title has-text-centered">Admin Login</h1>

    <?php if ($flash): ?>
        <div class="flash flash-<?= htmlspecialchars($flash["type"]) ?>">
            <?= htmlspecialchars($flash["message"]) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/login">
        <div class="field">
            <label class="label">Username</label>
            <div class="control">
                <input class="input" type="text" name="username" placeholder="Username" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" type="password" name="password" placeholder="Password" required>
            </div>
        </div>

        <div class="field mt-4">
            <div class="control">
                <button class="button is-primary is-fullwidth" type="submit">Login</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
