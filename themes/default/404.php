<!DOCTYPE html>
<html>
<head>
    <title>404 - Not Found</title>
    <style>
        body { font-family:sans-serif; background:#fafaff; text-align:center; padding:3em; }
        .notfound { display:inline-block; background:#f9dbdb; color:#a00; padding:2em 3em; border-radius:12px;}
    </style>
</head>
<body>
    <div class="notfound">
        <h1>404 - Page Not Found</h1>
        <p><?= htmlspecialchars($message ?? "The page you're looking for doesn't exist.") ?></p>
        <p><a href="/">Go back home</a></p>
    </div>
</body>
</html>