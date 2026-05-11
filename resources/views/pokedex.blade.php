<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        :root {
            --red:     #ff1744;
            --red-dark: #c41c3b;
            --white:   #ffffff;
            --black:   #1a1a1a;
            --gray:    #f5f5f5;
            --accent:  #ffcd00;
            --text:    #333333;
            --success: #4caf50;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { 
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color:var(--text); 
            font-family:'Bebas Neue','DM Sans',sans-serif; 
            min-height:100vh; 
            overflow-x:hidden;
        }
        body::before {
            content:''; position:fixed; inset:0;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255,23,68,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,205,0,0.08) 0%, transparent 50%);
            pointer-events:none; z-index:0;
        }
        .wrap { position:relative; z-index:1; max-width:1300px; margin:0 auto; padding:0 24px 80px; }
        
        /* HEADER / LOGO */
        header { 
            display:flex; align-items:center; justify-content:space-between; 
            padding:32px 0 30px; 
            margin-bottom:48px;
            border-bottom: 3px solid var(--red);
        }
        .logo { 
            font-size:3.2rem; 
            letter-spacing:6px; 
            font-weight:900;
            background: linear-gradient(135deg, var(--red) 0%, var(--red-dark) 100%);
            -webkit-background-clip:text; 
            -webkit-text-fill-color:transparent;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            position:relative;
        }
        .logo::after {
            content:'';
            position:absolute;
            bottom:-8px;
            left:0;
            width:100%;
            height:3px;
            background: var(--accent);
        }
        .logo span { 
            color:var(--accent); 
            font-size:0.6rem; 
            letter-spacing:2px;
            display:block;
            margin-top:4px;
        }
        
        /* TABS */
        .tabs { 
            display:flex; 
            gap:8px; 
            background:var(--white); 
            border:2px solid var(--red);
            border-radius:8px; 
            padding:6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .tab { 
            padding:10px 24px; 
            border-radius:4px; 
            border:none; 
            background:transparent; 
            color:var(--text); 
            font-size:0.85rem; 
            font-weight:700;
            cursor:pointer; 
            transition:all 0.2s;
            letter-spacing:1px;
        }
        .tab.active { 
            background:var(--red);
            color:var(--white);
            box-shadow: 0 2px 8px rgba(255,23,68,0.4);
        }
        .tab:hover:not(.active) { 
            background:rgba(255,23,68,0.1);
            color:var(--red);
        }
        .section { display:none; }
        .section.active { display:block; animation: fadeIn 0.3s ease; }
        
        /* BUSCA */
        .search-hero { text-align:center; padding:30px 0 50px; }
        .search-hero h2 { 
            font-size:3.8rem; 
            letter-spacing:4px;
            margin-bottom:12px;
            color:var(--red);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            font-weight:900;
        }
        .search-hero p { 
            color:#666; 
            font-size:1.05rem; 
            margin-bottom:40px;
            letter-spacing:0.5px;
        }
        .search-bar { 
            display:flex; 
            gap:12px; 
            max-width:620px; 
            margin:0 auto 24px;
        }
        .search-bar input { 
            flex:1; 
            background:var(--white); 
            border:2px solid var(--red);
            border-radius:6px; 
            padding:16px 20px; 
            color:var(--text);
            font-size:1rem; 
            outline:none; 
            transition:all 0.2s;
            font-weight:500;
        }
        .search-bar input:focus { 
            border-color:var(--accent);
            box-shadow: 0 0 0 4px rgba(255,205,0,0.2);
        }
        .search-bar input::placeholder { color:#999; }
        
        .btn { 
            padding:14px 32px; 
            border-radius:6px; 
            border:2px solid var(--red);
            font-weight:700; 
            font-size:0.9rem; 
            cursor:pointer; 
            transition:all 0.2s;
            letter-spacing:1px;
        }
        .btn-primary { 
            background:var(--red); 
            color:var(--white);
            border-color:var(--red);
        }
        .btn-primary:hover { 
            background:var(--red-dark);
            border-color:var(--red-dark);
            transform:translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,23,68,0.4);
        }
        .btn-secondary { 
            background:var(--white); 
            border:2px solid var(--red); 
            color:var(--red);
        }
        .btn-secondary:hover { 
            background:var(--red);
            color:var(--white);
        }
        .btn-ghost { 
            background:transparent; 
            border:2px dashed var(--accent); 
            color:var(--accent); 
            padding:10px 18px; 
            font-size:0.8rem;
        }
        .btn-ghost:hover { 
            background:rgba(255,205,0,0.1);
            border-color:var(--accent);
        }
        .random-btn { 
            display:block; 
            margin:0 auto; 
            background:var(--accent);
            border:2px solid var(--accent); 
            color:var(--black); 
            padding:14px 36px; 
            border-radius:6px; 
            font-weight:700;
            font-size:0.9rem; 
            cursor:pointer; 
            transition:all 0.2s;
            letter-spacing:1px;
        }
        .random-btn:hover { 
            transform:scale(1.05);
            box-shadow: 0 6px 16px rgba(255,205,0,0.4);
        }
        
        #result-area { margin-top:48px; }
        
        /* POKEMON SPOTLIGHT */
        .poke-spotlight { 
            display:flex; 
            gap:50px; 
            background:var(--white);
            border:3px solid var(--red);
            border-radius:12px; 
            padding:48px;
            align-items:center; 
            animation:slideUp 0.5s ease;
            position:relative; 
            overflow:hidden;
            box-shadow: 0 8px 24px rgba(255,23,68,0.2);
        }
        .poke-spotlight::before { 
            content:''; 
            position:absolute; 
            top:-80px; 
            right:-80px; 
            width:280px; 
            height:280px; 
            border-radius:50%; 
            filter:blur(60px); 
            opacity:0.1; 
            background:var(--red);
            z-index:0;
        }
        .poke-img-bg { 
            width:200px; 
            height:200px; 
            border-radius:12px; 
            background:linear-gradient(135deg, rgba(255,23,68,0.05) 0%, rgba(255,205,0,0.05) 100%);
            border:3px solid var(--accent);
            display:flex; 
            align-items:center; 
            justify-content:center; 
            flex-shrink:0;
            position:relative;
            z-index:1;
            box-shadow: inset 0 0 20px rgba(255,23,68,0.1);
        }
        .poke-img-bg img { 
            width:160px; 
            height:160px; 
            image-rendering:pixelated; 
            filter:drop-shadow(0 4px 8px rgba(0,0,0,0.2));
            animation:bounce 3s ease-in-out infinite;
        }
        .poke-info { flex:1; position:relative; z-index:1; }
        .poke-number { 
            font-size:0.75rem; 
            color:#999; 
            letter-spacing:2px;
            margin-bottom:8px;
            font-weight:700;
        }
        .poke-name { 
            font-size:4.2rem; 
            letter-spacing:3px; 
            line-height:1; 
            margin-bottom:20px;
            color:var(--red);
            font-weight:900;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .poke-types { 
            display:flex; 
            gap:12px; 
            margin-bottom:36px;
            flex-wrap:wrap;
        }
        .type-badge { 
            display:inline-block; 
            padding:8px 20px; 
            border-radius:20px; 
            font-size:0.8rem; 
            font-weight:700;
            letter-spacing:1px; 
            text-transform:uppercase;
            border:2px solid;
            background-color: rgba(255,255,255,0.7);
        }
        .poke-stats { 
            display:grid; 
            grid-template-columns:1fr 1fr; 
            gap:24px;
            padding-top:20px;
            border-top:2px solid var(--red);
        }
        .stat-item { }
        .stat-item label { 
            display:block; 
            font-size:0.7rem; 
            color:#666;
            letter-spacing:1px; 
            text-transform:uppercase; 
            margin-bottom:8px;
            font-weight:700;
        }
        .stat-bar-wrap { 
            background:#e0e0e0;
            border-radius:4px; 
            height:8px; 
            overflow:hidden;
            border:1px solid #ccc;
        }
        .stat-bar { 
            height:100%; 
            border-radius:4px; 
            background:linear-gradient(90deg, var(--red), var(--accent));
            transition:width 1s cubic-bezier(0.4,0,0.2,1);
        }
        .stat-val { 
            font-size:0.9rem; 
            font-weight:700; 
            margin-top:6px;
            color:var(--red);
        }

        /* CADASTRAR */
        .form-layout { 
            display:grid; 
            grid-template-columns:1fr 1fr; 
            gap:40px; 
            align-items:start;
        }
        .form-card { 
            background:var(--white);
            border:3px solid var(--red);
            border-radius:12px; 
            padding:40px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .form-card h3 { 
            font-size:2rem; 
            letter-spacing:2px; 
            margin-bottom:8px;
            color:var(--red);
            font-weight:900;
        }
        .form-card .sub { 
            color:#666; 
            font-size:0.9rem; 
            margin-bottom:32px;
            letter-spacing:0.5px;
        }
        .field { margin-bottom:24px; }
        .field label { 
            display:block; 
            font-size:0.75rem; 
            font-weight:700;
            letter-spacing:1px; 
            text-transform:uppercase; 
            color:var(--text);
            margin-bottom:10px;
        }
        .field input, .field select { 
            width:100%; 
            background:var(--gray);
            border:2px solid #ddd;
            border-radius:6px; 
            padding:14px 16px; 
            color:var(--text);
            font-size:0.95rem; 
            outline:none; 
            transition:all 0.2s;
            appearance:none;
            font-weight:500;
        }
        .field input:focus, .field select:focus { 
            border-color:var(--red);
            box-shadow: 0 0 0 4px rgba(255,23,68,0.1);
        }
        .field select { 
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ff1744' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 36px;
        }
        .field select option { background:var(--white); color:var(--text); }
        .btn-full { 
            width:100%; 
            padding:16px; 
            font-size:1rem; 
            border-radius:6px;
        }
        .preview-card { 
            background:linear-gradient(135deg, rgba(255,23,68,0.05) 0%, rgba(255,205,0,0.05) 100%);
            border:3px dashed var(--red);
            border-radius:12px; 
            padding:32px; 
            text-align:center; 
            margin-bottom:24px;
            min-height:200px;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
        }
        .preview-ball { 
            width:120px; 
            height:120px; 
            border-radius:12px; 
            background:var(--white);
            border:3px solid var(--accent);
            margin:0 auto 20px; 
            display:flex; 
            align-items:center; 
            justify-content:center; 
            font-size:2.5rem; 
            transition:all 0.3s;
            box-shadow: 0 4px 12px rgba(255,205,0,0.2);
        }
        .preview-ball img {
            width:100%;
            height:100%;
            object-fit:contain;
            border-radius:8px;
        }
        .preview-pname { 
            font-size:1.8rem; 
            letter-spacing:2px; 
            color:var(--red);
            transition:all 0.3s;
            font-weight:900;
            margin-bottom:8px;
        }
        .preview-type { 
            margin-top:12px; 
            height:auto; 
            display:flex; 
            align-items:center; 
            justify-content:center;
            flex-wrap:wrap;
            gap:8px;
        }

        /* BANCO */
        .banco-header { 
            display:flex; 
            align-items:center; 
            justify-content:space-between; 
            margin-bottom:40px;
            padding-bottom:20px;
            border-bottom:2px solid var(--red);
        }
        .banco-header h2 { 
            font-size:2.6rem; 
            letter-spacing:2px;
            color:var(--red);
            font-weight:900;
        }
        .count-badge { 
            background:var(--red);
            border:none;
            border-radius:20px; 
            padding:8px 20px; 
            font-size:0.85rem; 
            color:var(--white);
            font-weight:700;
            box-shadow: 0 2px 8px rgba(255,23,68,0.3);
        }
        .banco-grid { 
            display:grid; 
            grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); 
            gap:20px;
        }

        .banco-card { 
            background:var(--white);
            border:2px solid var(--red);
            border-radius:12px; 
            padding:24px; 
            text-align:center; 
            transition:all 0.3s;
            animation:slideUp 0.4s ease both;
            position:relative;
            overflow:hidden;
        }
        .banco-card::before {
            content:'';
            position:absolute;
            top:0;
            left:0;
            right:0;
            height:4px;
            background:linear-gradient(90deg, var(--red), var(--accent));
        }
        .banco-card:hover { 
            border-color:var(--accent);
            transform:translateY(-6px);
            box-shadow:0 12px 28px rgba(255,23,68,0.2);
        }
        .bc-id { 
            font-size:0.7rem; 
            color:#999; 
            margin-bottom:12px;
            font-weight:700;
            letter-spacing:1px;
        }

        .bc-art {
            width:140px; 
            height:140px; 
            border-radius:8px; 
            margin:0 auto 16px;
            background:linear-gradient(135deg, rgba(255,23,68,0.05) 0%, rgba(255,205,0,0.05) 100%);
            border:2px solid var(--accent);
            display:flex; 
            align-items:center; 
            justify-content:center;
            overflow:hidden; 
            position:relative;
        }
        .bc-art img {
            width:100%;
            height:100%;
            object-fit:contain;
            image-rendering:pixelated;
            filter:drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        .bc-art .art-loading {
            display:flex; 
            flex-direction:column; 
            align-items:center; 
            gap:6px;
            color:#999; 
            font-size:0.65rem; 
            letter-spacing:1px; 
            text-transform:uppercase;
        }
        .art-spinner { 
            width:24px; 
            height:24px; 
            border:2px solid var(--accent); 
            border-top-color:var(--red); 
            border-radius:50%; 
            animation:spin 0.8s linear infinite;
        }

        .bc-name { 
            font-size:1.5rem; 
            letter-spacing:1px; 
            margin-bottom:12px;
            color:var(--red);
            font-weight:900;
        }
        .bc-atk { 
            font-size:0.85rem; 
            color:#666; 
            margin-top:12px;
            font-weight:600;
        }
        .bc-atk span { 
            color:var(--red); 
            font-weight:900;
        }
        .btn-delete { 
            margin-top:16px; 
            width:100%; 
            padding:10px; 
            background:transparent; 
            border:2px solid var(--red);
            border-radius:6px; 
            color:var(--red);
            font-size:0.75rem; 
            font-weight:700;
            cursor:pointer; 
            transition:all 0.2s;
            letter-spacing:1px;
        }
        .btn-delete:hover { 
            background:var(--red);
            color:var(--white);
        }

        .empty-state { 
            text-align:center; 
            padding:80px 20px; 
            color:#666;
        }
        .empty-state .icon { 
            font-size:4rem; 
            margin-bottom:20px; 
            opacity:0.5;
        }
        .spinner { 
            width:50px; 
            height:50px; 
            border:3px solid var(--accent); 
            border-top-color:var(--red); 
            border-radius:50%; 
            animation:spin 0.8s linear infinite; 
            margin:60px auto;
        }

        /* MODAL */
        .modal-overlay { 
            position:fixed; 
            inset:0; 
            background:rgba(0,0,0,0.6);
            backdrop-filter:blur(4px);
            z-index:100; 
            display:flex; 
            align-items:center; 
            justify-content:center; 
            opacity:0; 
            pointer-events:none; 
            transition:opacity 0.2s;
        }
        .modal-overlay.show { 
            opacity:1; 
            pointer-events:all;
        }
        .modal { 
            background:var(--white); 
            border:3px solid var(--red);
            border-radius:12px; 
            padding:40px; 
            max-width:360px; 
            width:90%; 
            text-align:center; 
            transform:scale(0.92); 
            transition:transform 0.2s cubic-bezier(0.34,1.56,0.64,1);
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }
        .modal-overlay.show .modal { 
            transform:scale(1);
        }
        .modal .modal-icon { 
            font-size:3rem; 
            margin-bottom:16px;
        }
        .modal h4 { 
            font-size:1.6rem; 
            letter-spacing:1px; 
            margin-bottom:12px;
            color:var(--red);
            font-weight:900;
        }
        .modal p { 
            color:#666; 
            font-size:0.95rem; 
            margin-bottom:32px;
            letter-spacing:0.5px;
        }
        .modal-btns { 
            display:flex; 
            gap:12px;
        }
        .modal-btns button { 
            flex:1;
        }

        /* TOAST */
        .toast { 
            position:fixed; 
            bottom:32px; 
            right:32px; 
            background:var(--success); 
            color:var(--white); 
            padding:16px 28px; 
            border-radius:6px; 
            font-weight:700; 
            font-size:0.9rem; 
            z-index:999; 
            transform:translateY(100px); 
            opacity:0; 
            transition:all 0.3s cubic-bezier(0.34,1.56,0.64,1);
            letter-spacing:0.5px;
        }
        .toast.show { 
            transform:translateY(0); 
            opacity:1;
        }
        .toast.error { 
            background:var(--red);
        }

        /* TIPOS - Cores mais vibrantes */
        .t-fire     { background:linear-gradient(135deg, #ff6b35, #ff8c42); color:#fff; border:2px solid #ff6b35; }
        .t-water    { background:linear-gradient(135deg, #4da8ff, #2eb3d1); color:#fff; border:2px solid #4da8ff; }
        .t-grass    { background:linear-gradient(135deg, #5dbb37, #7bc043); color:#fff; border:2px solid #5dbb37; }
        .t-electric { background:linear-gradient(135deg, #f5cc00, #ffd700); color:#000; border:2px solid #f5cc00; }
        .t-poison   { background:linear-gradient(135deg, #b97fe8, #d5a3ff); color:#fff; border:2px solid #b97fe8; }
        .t-normal   { background:linear-gradient(135deg, #aaa, #c0c0c0); color:#fff; border:2px solid #aaa; }
        .t-flying   { background:linear-gradient(135deg, #89aef5, #a8d5ff); color:#fff; border:2px solid #89aef5; }
        .t-bug      { background:linear-gradient(135deg, #a8bb1f, #bfd335); color:#fff; border:2px solid #a8bb1f; }
        .t-ground   { background:linear-gradient(135deg, #c8a02c, #e8b74b); color:#fff; border:2px solid #c8a02c; }
        .t-psychic  { background:linear-gradient(135deg, #ff4d8b, #ff69b4); color:#fff; border:2px solid #ff4d8b; }
        .t-rock     { background:linear-gradient(135deg, #c8a938, #e8c958); color:#fff; border:2px solid #c8a938; }
        .t-ice      { background:linear-gradient(135deg, #98d8d8, #b0e0e0); color:#000; border:2px solid #98d8d8; }
        .t-dragon   { background:linear-gradient(135deg, #9b6dff, #b88dff); color:#fff; border:2px solid #9b6dff; }
        .t-ghost    { background:linear-gradient(135deg, #9b7fd4, #b8a0e8); color:#fff; border:2px solid #9b7fd4; }
        .t-dark     { background:linear-gradient(135deg, #a08070, #b8a080); color:#fff; border:2px solid #a08070; }
        .t-steel    { background:linear-gradient(135deg, #b8b8d0, #d0d0e8); color:#fff; border:2px solid #b8b8d0; }
        .t-fairy    { background:linear-gradient(135deg, #f0a0c8, #f8c8e0); color:#fff; border:2px solid #f0a0c8; }
        .t-fighting { background:linear-gradient(135deg, #e05050, #ff6b6b); color:#fff; border:2px solid #e05050; }

        @keyframes fadeIn { from{opacity:0} to{opacity:1} }
        @keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        @keyframes bounce { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        @keyframes spin { to{transform:rotate(360deg)} }
        
        @media (max-width: 900px) {
            .form-layout { grid-template-columns:1fr; }
            .poke-spotlight { flex-direction:column; padding:32px; gap:24px; }
            .search-hero h2 { font-size:2.6rem; }
            .logo { font-size:2.2rem; }
        }
    </style>
</head>
<body>
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="wrap">
    <header>
        <div class="logo">Pokédex <span>Laravel Edition</span></div>
        <div class="tabs">
            <button class="tab active" onclick="switchTab('busca',this)">Buscar</button>
            <button class="tab" onclick="switchTab('cadastrar',this)">Cadastrar</button>
            <button class="tab" onclick="switchTab('banco',this)">Banco de Dados</button>
        </div>
    </header>

    <!-- BUSCA -->
    <div id="tab-busca" class="section active">
        <div class="search-hero">
            <h2>Encontre seu Pokémon</h2>
            <p>Digite o nome ou número — ou tente a sorte com um aleatório</p>
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="ex: pikachu, charizard, 25..." onkeydown="if(event.key==='Enter') buscarPokemon()">
                <button class="btn btn-primary" onclick="buscarPokemon()">Buscar</button>
            </div>
            <button class="random-btn" onclick="pokemonAleatorio()">⚡ Pokémon Aleatório</button>
        </div>
        <div id="result-area"></div>
    </div>

    <!-- CADASTRAR -->
    <div id="tab-cadastrar" class="section">
        <div class="form-layout">
            <div class="form-card">
                <h3>Novo Pokémon</h3>
                <p class="sub">Cadastre um Pokémon personalizado no banco de dados</p>
                <div class="field"><label>Nome</label><input type="text" id="f-nome" placeholder="ex: Volthorn" oninput="atualizarPreview()"></div>
                <div class="field">
                    <label>Tipo</label>
                    <select id="f-tipo" onchange="atualizarPreview()">
                        <option value="">Selecione o tipo</option>
                        <option>Normal</option><option>Fogo</option><option>Água</option>
                        <option>Elétrico</option><option>Planta</option><option>Gelo</option>
                        <option>Lutador</option><option>Veneno</option><option>Terra</option>
                        <option>Voador</option><option>Psíquico</option><option>Inseto</option>
                        <option>Pedra</option><option>Fantasma</option><option>Dragão</option>
                        <option>Sombrio</option><option>Aço</option><option>Fada</option>
                    </select>
                </div>
                <div class="field"><label>Ataque</label><input type="number" id="f-ataque" placeholder="ex: 88" min="1" max="255" oninput="atualizarPreview()"></div>
                <div class="field"><label>Foto do Pokémon</label><input type="file" id="f-foto" accept="image/*" onchange="atualizarPreviewFoto()"></div>
                <button class="btn btn-primary btn-full" onclick="cadastrarPokemon()">Cadastrar no Banco</button>
            </div>
            <div>
                <div class="preview-card">
                    <div class="preview-ball" id="prev-ball">?</div>
                    <div class="preview-pname" id="prev-nome">Seu Pokémon</div>
                    <div class="preview-type" id="prev-tipo"></div>
                </div>
                <div class="form-card" style="padding:24px">
                    <p style="font-size:0.8rem;color:var(--muted);margin-bottom:16px;font-weight:600;letter-spacing:1px;text-transform:uppercase">Atalhos — Pokémons IA</p>
                    <div style="display:flex;flex-direction:column;gap:10px">
                        <button class="btn btn-ghost" onclick="preencherIA('Volthorn','Elétrico',88)">⚡ Volthorn — Elétrico / ATK 88</button>
                        <button class="btn btn-ghost" onclick="preencherIA('Glacifera','Gelo',72)">❄️ Glacifera — Gelo / ATK 72</button>
                        <button class="btn btn-ghost" onclick="preencherIA('Pyrosnak','Fogo',95)">🔥 Pyrosnak — Fogo / ATK 95</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BANCO -->
    <div id="tab-banco" class="section">
        <div class="banco-header">
            <h2>Banco de Dados</h2>
            <div style="display:flex;gap:10px;align-items:center">
                <span class="count-badge" id="total-badge">— pokémons</span>
                <button class="btn btn-secondary" style="padding:8px 16px;font-size:0.8rem" onclick="carregarBanco()">↻ Atualizar</button>
            </div>
        </div>
        <div id="banco-grid" class="banco-grid"></div>
    </div>
</div>

<!-- MODAL -->
<div class="modal-overlay" id="modal-overlay">
    <div class="modal">
        <div class="modal-icon">🗑️</div>
        <h4>Excluir Pokémon</h4>
        <p id="modal-msg">Tem certeza? Essa ação não pode ser desfeita.</p>
        <div class="modal-btns">
            <button class="btn btn-secondary" onclick="fecharModal()">Cancelar</button>
            <button class="btn btn-primary" id="modal-confirm">Excluir</button>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<script>
const tipoMap = {
    'fire':'fire','fogo':'fire','water':'water','água':'water','grass':'grass','planta':'grass',
    'electric':'electric','elétrico':'electric','poison':'poison','veneno':'poison',
    'normal':'normal','flying':'flying','voador':'flying','bug':'bug','inseto':'bug',
    'ground':'ground','terra':'ground','psychic':'psychic','psíquico':'psychic',
    'rock':'rock','pedra':'rock','ice':'ice','gelo':'ice','dragon':'dragon','dragão':'dragon',
    'ghost':'ghost','fantasma':'ghost','dark':'dark','sombrio':'dark','steel':'steel','aço':'steel',
    'fairy':'fairy','fada':'fairy','fighting':'fighting','lutador':'fighting'
};
const localPokemonImages = {
    'Volthorn': '/images/pokemons/Volthorn.png',
    'Pyrosnak': '/images/pokemons/Pyrosnak.png',
    'Glacifera': '/images/pokemons/Glacifera.png'
};
const tipoEmoji = {
    fire:'🔥',fogo:'🔥',water:'💧',água:'💧',grass:'🌿',planta:'🌿',
    electric:'⚡',elétrico:'⚡',poison:'☠️',veneno:'☠️',normal:'⭐',
    flying:'🌪️',voador:'🌪️',bug:'🐛',inseto:'🐛',ground:'🌍',terra:'🌍',
    psychic:'🔮',psíquico:'🔮',rock:'🪨',pedra:'🪨',ice:'❄️',gelo:'❄️',
    dragon:'🐉',dragão:'🐉',ghost:'👻',fantasma:'👻',dark:'🌑',sombrio:'🌑',
    steel:'⚙️',aço:'⚙️',fairy:'✨',fada:'✨',fighting:'🥊',lutador:'🥊'
};
const tipoColor = {
    fire:'#ff6b35',water:'#4da8ff',grass:'#5dbb37',electric:'#f5cc00',
    poison:'#b97fe8',normal:'#aaa',flying:'#89aef5',bug:'#a8bb1f',
    ground:'#c8a02c',psychic:'#ff4d8b',rock:'#c8a938',ice:'#98d8d8',
    dragon:'#9b6dff',ghost:'#9b7fd4',dark:'#a08070',steel:'#b8b8d0',
    fairy:'#f0a0c8',fighting:'#e05050'
};

function getTipoClass(t) { return 't-'+(tipoMap[t?.toLowerCase()]||'normal'); }
function getTipoEmoji(t)  { return tipoEmoji[t?.toLowerCase()]||'⭐'; }
function getTipoColor(t)  { return tipoColor[tipoMap[t?.toLowerCase()]]||'#aaa'; }

function switchTab(id,btn) {
    document.querySelectorAll('.section').forEach(s=>s.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(b=>b.classList.remove('active'));
    document.getElementById('tab-'+id).classList.add('active');
    btn.classList.add('active');
    if(id==='banco') carregarBanco();
}

function showToast(msg,isError=false) {
    const t=document.getElementById('toast');
    t.textContent=msg;
    t.className='toast'+(isError?' error':'')+' show';
    setTimeout(()=>t.className='toast',3000);
}

// ── BUSCA ──
async function buscarPokemon() {
    const q=document.getElementById('search-input').value.trim().toLowerCase();
    if(!q) return showToast('Digite um nome ou número',true);
    renderResultado(null,true);
    try {
        const r=await fetch('/pokemon/'+q);
        const d=await r.json();
        if(!r.ok) return renderResultado(null,false,d.erro||'Não encontrado');
        renderResultado(d.resultados);
    } catch(e){renderResultado(null,false,'Erro de conexão');}
}

async function pokemonAleatorio() {
    const id=Math.floor(Math.random()*898)+1;
    document.getElementById('search-input').value='';
    renderResultado(null,true);
    try {
        const r=await fetch('/pokemon/'+id);
        const d=await r.json();
        if(!r.ok) return renderResultado(null,false,'Erro ao buscar');
        renderResultado(d.resultados);
    } catch(e){renderResultado(null,false,'Erro de conexão');}
}

function renderResultado(p,loading=false,erro=null) {
    const area=document.getElementById('result-area');
    if(loading){area.innerHTML='<div class="spinner"></div>';return;}
    if(erro){area.innerHTML=`<div class="empty-state"><div class="icon">😵</div><p>${erro}</p></div>`;return;}
    if(!p){area.innerHTML='';return;}
    const tipo=p.tipo||'Normal';
    const tc=getTipoColor(tipo);
    const num=String(p.identificador||'').padStart(3,'0');
    const s=p.identificador||50;
    const stats=[
        {label:'HP',val:Math.min(255,45+(s%80))},
        {label:'Ataque',val:Math.min(255,49+(s%90))},
        {label:'Defesa',val:Math.min(255,49+(s%70))},
        {label:'Velocidade',val:Math.min(255,45+(s%100))},
    ];
    area.innerHTML=`
    <div class="poke-spotlight" style="--type-color:${tc}">
        <div class="poke-img-bg"><img src="${p.foto}" alt="${p.nome_do_pokemon}"></div>
        <div class="poke-info">
            <div class="poke-number"># ${num}</div>
            <div class="poke-name">${p.nome_do_pokemon}</div>
            <div class="poke-types"><span class="type-badge ${getTipoClass(tipo)}">${getTipoEmoji(tipo)} ${tipo}</span></div>
            <div class="poke-stats">${stats.map(st=>`
                <div class="stat-item">
                    <label>${st.label}</label>
                    <div class="stat-bar-wrap"><div class="stat-bar" style="width:0%;background:${tc}" data-val="${st.val}"></div></div>
                    <div class="stat-val" style="color:${tc}">${st.val}</div>
                </div>`).join('')}
            </div>
        </div>
    </div>`;
    requestAnimationFrame(()=>{
        document.querySelectorAll('.stat-bar').forEach(b=>{b.style.width=(parseInt(b.dataset.val)/255*100)+'%';});
    });
}

// ── PREVIEW ──
function atualizarPreview() {
    const nome=document.getElementById('f-nome').value||'Seu Pokémon';
    const tipo=document.getElementById('f-tipo').value;
    document.getElementById('prev-nome').textContent=nome;
    document.getElementById('prev-nome').style.color=tipo?getTipoColor(tipo):'var(--muted)';
    document.getElementById('prev-ball').textContent=tipo?getTipoEmoji(tipo):'?';
    document.getElementById('prev-ball').style.borderColor=tipo?getTipoColor(tipo):'var(--border)';
    document.getElementById('prev-ball').style.background=tipo?getTipoColor(tipo)+'18':'rgba(255,255,255,0.04)';
    document.getElementById('prev-tipo').innerHTML=tipo?`<span class="type-badge ${getTipoClass(tipo)}">${tipo}</span>`:'';
}
function preencherIA(nome,tipo,ataque) {
    document.getElementById('f-nome').value=nome;
    document.getElementById('f-tipo').value=tipo;
    document.getElementById('f-ataque').value=ataque;
    atualizarPreview();
}
function atualizarPreviewFoto() {
    const file=document.getElementById('f-foto').files[0];
    const prevBall=document.getElementById('prev-ball');
    if(file) {
        const reader=new FileReader();
        reader.onload=function(e) {
            prevBall.innerHTML=`<img src="${e.target.result}" style="width:100%;height:100%;object-fit:contain;">`;
        };
        reader.readAsDataURL(file);
    } else {
        prevBall.innerHTML='?';
    }
}

// ── CADASTRAR ──
async function cadastrarPokemon() {
    const nome=document.getElementById('f-nome').value.trim();
    const tipo=document.getElementById('f-tipo').value;
    const ataque=parseInt(document.getElementById('f-ataque').value);
    const fotoFile=document.getElementById('f-foto').files[0];
    
    if(!nome||!tipo||!ataque) return showToast('Preencha todos os campos',true);
    
    const formData=new FormData();
    formData.append('nome',nome);
    formData.append('tipo',tipo);
    formData.append('ataque',ataque);
    if(fotoFile) formData.append('foto',fotoFile);
    
    try {
        const r=await fetch('/pokemon/novo',{
            method:'POST',
            headers:{'X-Requested-With':'XMLHttpRequest'},
            body:formData
        });
        const d=await r.json();
        if(!r.ok) return showToast('Erro ao cadastrar',true);
        showToast(`✅ ${nome} salvo! ID #${d.id_banco}`);
        document.getElementById('f-nome').value='';
        document.getElementById('f-tipo').value='';
        document.getElementById('f-ataque').value='';
        document.getElementById('f-foto').value='';
        atualizarPreview();
        atualizarPreviewFoto();
    } catch(e){showToast('Erro de conexão',true);}
}

// ── BANCO + IMAGEM VINDO DO BANCO DE DADOS ──
function escaparTexto(txt) {
    return String(txt ?? '')
        .replaceAll('&','&amp;')
        .replaceAll('<','&lt;')
        .replaceAll('>','&gt;')
        .replaceAll('"','&quot;')
        .replaceAll("'",'&#039;');
}

async function carregarBanco() {
    const grid=document.getElementById('banco-grid');
    grid.innerHTML='<div class="spinner"></div>';
    try {
        const r=await fetch('/pokemon/banco/todos');
        const d=await r.json();

        document.getElementById('total-badge').textContent=`${d.total} pokémon${d.total!==1?'s':''}`;

        if(!d.pokemons||d.pokemons.length===0){
            grid.innerHTML='<div class="empty-state"><div class="icon">🗄️</div><p>Nenhum Pokémon cadastrado ainda</p></div>';
            return;
        }

        grid.innerHTML=d.pokemons.map((p,i)=>{
            const nomeSeguro = escaparTexto(p.nome);
            const tipoSeguro = escaparTexto(p.tipo);
            const imagemSeguro = escaparTexto(p.imagem || localPokemonImages[p.nome] || '');
            const temImagem = Boolean(p.imagem || localPokemonImages[p.nome]);

            return `
            <div class="banco-card" id="card-${p.id}" style="animation-delay:${i*0.05}s">
                <div class="bc-id">#${String(p.id).padStart(3,'0')}</div>

                <div class="bc-art" id="art-${p.id}">
                    ${
                        temImagem
                        ? `<img src="${imagemSeguro}" alt="${nomeSeguro}">`
                        : `<span style="font-size:3rem">${getTipoEmoji(p.tipo)}</span>`
                    }
                </div>

                <div class="bc-name">${nomeSeguro}</div>
                <span class="type-badge ${getTipoClass(p.tipo)}" style="font-size:0.68rem;padding:4px 12px">${tipoSeguro}</span>
                <div class="bc-atk">ATK <span>${p.ataque}</span></div>
                <button class="btn-delete" onclick="confirmarExclusao(${p.id},'${nomeSeguro}')">× Excluir</button>
            </div>`;
        }).join('');

    } catch(e){
        grid.innerHTML='<div class="empty-state"><div class="icon">⚠️</div><p>Erro ao carregar dados</p></div>';
    }
}

// ── EXCLUIR ──
function confirmarExclusao(id,nome) {
    document.getElementById('modal-msg').textContent=`Deseja excluir "${nome}"? Essa ação não pode ser desfeita.`;
    document.getElementById('modal-confirm').onclick=()=>excluirPokemon(id,nome);
    document.getElementById('modal-overlay').classList.add('show');
}
function fecharModal() {
    document.getElementById('modal-overlay').classList.remove('show');
}
document.getElementById('modal-overlay').addEventListener('click',function(e){
    if(e.target===this) fecharModal();
});
async function excluirPokemon(id,nome) {
    fecharModal();
    try {
        const r=await fetch(`/pokemon/deletar/${id}`,{method:'DELETE'});
        if(!r.ok) return showToast('Erro ao excluir',true);
        showToast(`🗑️ ${nome} removido do banco!`);
        carregarBanco();
    } catch(e){showToast('Erro de conexão',true);}
}
</script>
</body>
</html>