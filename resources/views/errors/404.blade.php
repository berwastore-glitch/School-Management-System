<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-container { text-align: center; padding: 2rem; }
        .error-code { font-size: 8rem; font-weight: 800; color: #0A2342; line-height: 1; opacity: 0.15; }
        .error-title { font-size: 1.75rem; font-weight: 700; color: #0A2342; margin-top: -1rem; }
        .error-message { color: #6B7280; font-size: 1.05rem; margin: 1rem 0 2rem; }
        .btn-home { background: #D97706; color: #fff; border: none; padding: 0.7rem 2rem; border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.3s; }
        .btn-home:hover { background: #b45309; color: #fff; transform: translateY(-2px); }
        .btn-back { color: #6B7280; text-decoration: none; margin-left: 1rem; font-weight: 500; }
        .btn-back:hover { color: #0A2342; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">The page you're looking for doesn't exist or has been moved.</p>
        <a href="/" class="btn-home"><i class="fas fa-home me-1"></i> Go Home</a>
        <a href="javascript:history.back()" class="btn-back"><i class="fas fa-arrow-left me-1"></i> Go Back</a>
    </div>
</body>
</html>
