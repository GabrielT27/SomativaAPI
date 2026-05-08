<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex Laravel</title>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #0a0a0f;
            --surface: #111118;
            --card: #16161f;
            --border: rgba(255,255,255,0.08);
            --accent: #e63946;
            --accent2: #f4a261;
            --text: #f0eff4;
            --muted: #7a7a8f;
            --electric: #f5cc00;
            --ice: #98d8d8;
            --fire: #ff6b35;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.018) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.018) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }

        .blob {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.14;
            pointer-events: none;
            z-index: 0;
        }

        .blob-1 {
            background: var(--accent);
            top: -220px;
            left: -180px;
        }

        .blob-2 {
            background: #3a86ff;
            bottom: -220px;
            right: -180px;
        }

        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
        }

        .hero {
            width: 100%;
            max-width: 1100px;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 56px;
            align-items: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.04);
            color: var(--muted);
            padding: 8px 14px;
            border-radius: 999px;
            font-family: 'Space Mono', monospace;
            font-size: 0.75rem;
            margin-bottom: 24px;
        }

        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(4rem, 10vw, 8rem);
            letter-spacing: 8px;
            line-height: 0.9;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 18px;
        }

        .subtitle {
            max-width: 620px;
            color: var(--muted);
            font-size: 1.08rem;
            line-height: 1.7;
            margin-bottom: 36px;
        }

        .actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 28px;
            border-radius: 14px;
            text-decoration: none;
            border: 1px solid transparent;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 14px 40px rgba(230,57,70,0.22);
        }

        .btn-primary:hover {
            background: #ff4d5a;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--surface);
            border-color: var(--border);
            color: var(--text);
        }

        .btn-secondary:hover {
            border-color: var(--accent2);
            color: var(--accent2);
            transform: translateY(-2px);
        }

        .cards {
            display: grid;
            gap: 16px;
        }

        .pokemon-card {
            background: rgba(22,22,31,0.86);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 16px 50px rgba(0,0,0,0.26);
            animation: floatCard 4s ease-in-out infinite;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
        }

        .pokemon-card:hover {
            border-color: rgba(255,255,255,0.2);
            transform: translateY(-4px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.38);
        }

        .pokemon-card:nth-child(2) {
            animation-delay: 0.4s;
            transform: translateX(28px);
        }

        .pokemon-card:nth-child(2):hover {
            transform: translateX(28px) translateY(-4px);
        }

        .pokemon-card:nth-child(3) {
            animation-delay: 0.8s;
        }

        .art {
            width: 86px;
            height: 86px;
            border-radius: 18px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .art img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            image-rendering: pixelated;
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.45));
        }

        .info small {
            display: block;
            font-family: 'Space Mono', monospace;
            color: var(--muted);
            font-size: 0.68rem;
            margin-bottom: 4px;
        }

        .info h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.7rem;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        .type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .electric {
            color: var(--electric);
            background: rgba(245,204,0,0.14);
            border: 1px solid rgba(245,204,0,0.28);
        }

        .ice {
            color: var(--ice);
            background: rgba(152,216,216,0.14);
            border: 1px solid rgba(152,216,216,0.28);
        }

        .fire {
            color: var(--fire);
            background: rgba(255,107,53,0.14);
            border: 1px solid rgba(255,107,53,0.28);
        }

        .footer-note {
            margin-top: 28px;
            color: var(--muted);
            font-family: 'Space Mono', monospace;
            font-size: 0.75rem;
        }

        @keyframes floatCard {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @media (max-width: 900px) {
            body {
                overflow: auto;
            }

            .hero {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .pokemon-card:nth-child(2) {
                transform: none;
            }

            .pokemon-card:nth-child(2):hover {
                transform: translateY(-4px);
            }

            .logo {
                font-size: 4.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <main class="page">
        <section class="hero">
            <div>
                <div class="badge">
                    Laravel + PokeAPI + MySQL
                </div>

                <h1 class="logo">Pokédex</h1>

                <p class="subtitle">
                    Projeto desenvolvido em Laravel com integração à PokeAPI, cadastro de Pokémons fictícios,
                    armazenamento em banco de dados MySQL e exibição visual com imagens locais.
                </p>

                <div class="actions">
                    <a href="/pokedex" class="btn btn-primary">
                        Entrar na Pokédex
                    </a>

                    <a href="/pokemon/banco/todos" class="btn btn-secondary">
                        Ver JSON do Banco
                    </a>
                </div>

                <p class="footer-note">
                    Projeto final: formativa_02 • Banco: bd_pokedex
                </p>
            </div>

            <div class="cards">
                <a href="/pokemon/banco/nome/Volthorn" class="pokemon-card">
                    <div class="art">
                        <img src="/images/pokemons/Volthorn.png" alt="Volthorn">
                    </div>
                    <div class="info">
                        <small>#001</small>
                        <h3>Volthorn</h3>
                        <span class="type electric">Elétrico</span>
                    </div>
                </a>

                <a href="/pokemon/banco/nome/Glacifera" class="pokemon-card">
                    <div class="art">
                        <img src="/images/pokemons/Glacifera.png" alt="Glacifera">
                    </div>
                    <div class="info">
                        <small>#002</small>
                        <h3>Glacifera</h3>
                        <span class="type ice">Gelo</span>
                    </div>
                </a>

                <a href="/pokemon/banco/nome/Pyrosnak" class="pokemon-card">
                    <div class="art">
                        <img src="/images/pokemons/Pyrosnak.png" alt="Pyrosnak">
                    </div>
                    <div class="info">
                        <small>#003</small>
                        <h3>Pyrosnak</h3>
                        <span class="type fire">Fogo</span>
                    </div>
                </a>
            </div>
        </section>
    </main>
</body>
</html>