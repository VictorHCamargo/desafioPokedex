<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Rajdhani', sans-serif; }
        .pixel { font-family: 'Press Start 2P', monospace; }
        .card-hover { transition: transform .2s, box-shadow .2s; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.5); }
        .stat-bar { transition: width 1s ease-out; }
        @keyframes fadeSlide { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
        .toast { animation: fadeSlide .35s ease forwards; }
        @keyframes spin-slow { to { transform: rotate(360deg); } }
        .spin-slow { animation: spin-slow 12s linear infinite; }
        .pokeball-bg {
            background-image: radial-gradient(circle at 70% 20%, rgba(220,38,38,.08) 0%, transparent 60%),
                              radial-gradient(circle at 10% 80%, rgba(220,38,38,.05) 0%, transparent 50%);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen pokeball-bg">

{{ $slot }}
</body>
</html>