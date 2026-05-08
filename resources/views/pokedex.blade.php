<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:      #0a0a0f;
            --surface: #111118;
            --card:    #16161f;
            --border:  rgba(255,255,255,0.07);
            --accent:  #e63946;
            --accent2: #f4a261;
            --text:    #f0eff4;
            --muted:   #6b6b80;
            --success: #2ec4b6;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background:var(--bg); color:var(--text); font-family:'DM Sans',sans-serif; min-height:100vh; overflow-x:hidden; }
        body::before {
            content:''; position:fixed; inset:0;
            background-image: linear-gradient(rgba(255,255,255,0.015) 1px,transparent 1px), linear-gradient(90deg,rgba(255,255,255,0.015) 1px,transparent 1px);
            background-size:40px 40px; pointer-events:none; z-index:0;
        }
        .blob { position:fixed; width:600px; height:600px; border-radius:50%; filter:blur(120px); pointer-events:none; z-index:0; opacity:0.12; }
        .blob-1 { background:var(--accent); top:-200px; left:-200px; }
        .blob-2 { background:#3a86ff; bottom:-200px; right:-200px; }
        .wrap { position:relative; z-index:1; max-width:1200px; margin:0 auto; padding:0 24px 80px; }
        header { display:flex; align-items:center; justify-content:space-between; padding:32px 0 40px; border-bottom:1px solid var(--border); margin-bottom:48px; }
        .logo { font-family:'Bebas Neue',sans-serif; font-size:2.8rem; letter-spacing:4px; background:linear-gradient(135deg,var(--accent),var(--accent2)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .logo span { color:var(--muted); -webkit-text-fill-color:var(--muted); font-size:1rem; font-family:'Space Mono',monospace; letter-spacing:0; margin-left:8px; vertical-align:middle; }
        .tabs { display:flex; gap:4px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:4px; }
        .tab { padding:8px 20px; border-radius:8px; border:none; background:transparent; color:var(--muted); font-family:'DM Sans',sans-serif; font-size:0.85rem; font-weight:500; cursor:pointer; transition:all 0.2s; }
        .tab.active { background:var(--accent); color:#fff; }
        .tab:hover:not(.active) { color:var(--text); }
        .section { display:none; }
        .section.active { display:block; }

        /* BUSCA */
        .search-hero { text-align:center; padding:20px 0 48px; }
        .search-hero h2 { font-family:'Bebas Neue',sans-serif; font-size:3.5rem; letter-spacing:3px; margin-bottom:8px; }
        .search-hero p { color:var(--muted); font-size:0.95rem; margin-bottom:40px; }
        .search-bar { display:flex; gap:12px; max-width:560px; margin:0 auto 20px; }
        .search-bar input { flex:1; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:16px 20px; color:var(--text); font-family:'DM Sans',sans-serif; font-size:1rem; outline:none; transition:border-color 0.2s; }
        .search-bar input:focus { border-color:var(--accent); }
        .search-bar input::placeholder { color:var(--muted); }
        .btn { padding:16px 28px; border-radius:12px; border:none; font-family:'DM Sans',sans-serif; font-weight:600; font-size:0.9rem; cursor:pointer; transition:all 0.2s; }
        .btn-primary { background:var(--accent); color:#fff; }
        .btn-primary:hover { background:#ff4d5a; transform:translateY(-1px); }
        .btn-secondary { background:var(--surface); border:1px solid var(--border); color:var(--text); }
        .btn-secondary:hover { border-color:var(--accent2); color:var(--accent2); }
        .btn-ghost { background:transparent; border:1px solid var(--border); color:var(--muted); padding:10px 18px; font-size:0.8rem; }
        .btn-ghost:hover { border-color:var(--success); color:var(--success); }
        .random-btn { display:block; margin:0 auto; background:transparent; border:1px dashed rgba(244,162,97,0.4); color:var(--accent2); padding:12px 28px; border-radius:12px; font-family:'Space Mono',monospace; font-size:0.8rem; cursor:pointer; transition:all 0.2s; }
        .random-btn:hover { border-color:var(--accent2); background:rgba(244,162,97,0.06); }
        #result-area { margin-top:48px; }
        .poke-spotlight { display:flex; gap:40px; background:var(--card); border:1px solid var(--border); border-radius:24px; padding:40px; align-items:center; animation:fadeUp 0.4s ease; position:relative; overflow:hidden; }
        .poke-spotlight::before { content:''; position:absolute; top:-80px; right:-80px; width:280px; height:280px; border-radius:50%; filter:blur(60px); opacity:0.15; background:var(--type-color,var(--accent)); }
        .poke-img-bg { width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,0.04); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .poke-img-bg img { width:140px; height:140px; image-rendering:pixelated; filter:drop-shadow(0 8px 24px rgba(0,0,0,0.5)); animation:float 3s ease-in-out infinite; }
        .poke-info { flex:1; }
        .poke-number { font-family:'Space Mono',monospace; font-size:0.75rem; color:var(--muted); letter-spacing:2px; margin-bottom:6px; }
        .poke-name { font-family:'Bebas Neue',sans-serif; font-size:4rem; letter-spacing:3px; line-height:1; margin-bottom:16px; }
        .poke-types { display:flex; gap:8px; margin-bottom:28px; }
        .type-badge { display:inline-block; padding:5px 16px; border-radius:20px; font-size:0.75rem; font-weight:600; letter-spacing:1px; text-transform:uppercase; }
        .poke-stats { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .stat-item label { display:block; font-size:0.7rem; color:var(--muted); letter-spacing:1px; text-transform:uppercase; margin-bottom:4px; }
        .stat-bar-wrap { background:rgba(255,255,255,0.06); border-radius:4px; height:6px; overflow:hidden; }
        .stat-bar { height:100%; border-radius:4px; transition:width 1s cubic-bezier(0.4,0,0.2,1); }
        .stat-val { font-family:'Space Mono',monospace; font-size:0.85rem; font-weight:700; margin-top:3px; }

        /* CADASTRAR */
        .form-layout { display:grid; grid-template-columns:1fr 1fr; gap:40px; align-items:start; }
        .form-card { background:var(--card); border:1px solid var(--border); border-radius:24px; padding:36px; }
        .form-card h3 { font-family:'Bebas Neue',sans-serif; font-size:1.8rem; letter-spacing:2px; margin-bottom:4px; }
        .form-card .sub { color:var(--muted); font-size:0.85rem; margin-bottom:28px; }
        .field { margin-bottom:20px; }
        .field label { display:block; font-size:0.75rem; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:var(--muted); margin-bottom:8px; }
        .field input, .field select { width:100%; background:var(--surface); border:1px solid var(--border); border-radius:10px; padding:13px 16px; color:var(--text); font-family:'DM Sans',sans-serif; font-size:0.95rem; outline:none; transition:border-color 0.2s; appearance:none; }
        .field input:focus, .field select:focus { border-color:var(--accent); }
        .field select option { background:var(--surface); }
        .btn-full { width:100%; padding:15px; font-size:1rem; border-radius:12px; }
        .preview-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:28px; text-align:center; margin-bottom:20px; }
        .preview-ball { width:100px; height:100px; border-radius:50%; background:rgba(255,255,255,0.04); border:2px dashed var(--border); margin:0 auto 16px; display:flex; align-items:center; justify-content:center; font-size:2.5rem; transition:all 0.3s; }
        .preview-pname { font-family:'Bebas Neue',sans-serif; font-size:1.8rem; letter-spacing:2px; color:var(--muted); transition:all 0.3s; }
        .preview-type { margin-top:8px; height:28px; display:flex; align-items:center; justify-content:center; }

        /* BANCO */
        .banco-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:32px; }
        .banco-header h2 { font-family:'Bebas Neue',sans-serif; font-size:2.4rem; letter-spacing:3px; }
        .count-badge { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:6px 16px; font-family:'Space Mono',monospace; font-size:0.8rem; color:var(--muted); }
        .banco-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:16px; }

        .banco-card { background:var(--card); border:1px solid var(--border); border-radius:16px; padding:20px; text-align:center; transition:all 0.25s; animation:fadeUp 0.4s ease both; }
        .banco-card:hover { border-color:rgba(255,255,255,0.15); transform:translateY(-4px); box-shadow:0 12px 40px rgba(0,0,0,0.4); }
        .bc-id { font-family:'Space Mono',monospace; font-size:0.7rem; color:var(--muted); margin-bottom:10px; }

        /* área da imagem IA */
        .bc-art {
            width:120px; height:120px; border-radius:12px; margin:0 auto 12px;
            background:rgba(255,255,255,0.04); border:1px solid var(--border);
            display:flex; align-items:center; justify-content:center;
            overflow:hidden; position:relative;
        }
        .bc-art svg { width:100%; height:100%; }
        .bc-art img {
            width:100%;
            height:100%;
            object-fit:contain;
            image-rendering:pixelated;
            filter:drop-shadow(0 8px 18px rgba(0,0,0,0.45));
        }
        .bc-art .art-loading {
            display:flex; flex-direction:column; align-items:center; gap:6px;
            color:var(--muted); font-size:0.65rem; letter-spacing:1px; text-transform:uppercase;
        }
        .art-spinner { width:24px; height:24px; border:2px solid var(--border); border-top-color:var(--accent); border-radius:50%; animation:spin 0.8s linear infinite; }

        .bc-name { font-family:'Bebas Neue',sans-serif; font-size:1.4rem; letter-spacing:2px; margin-bottom:8px; }
        .bc-atk { font-family:'Space Mono',monospace; font-size:0.8rem; color:var(--muted); margin-top:10px; }
        .bc-atk span { color:var(--accent2); font-weight:700; }
        .btn-delete { margin-top:12px; width:100%; padding:8px; background:transparent; border:1px solid rgba(230,57,70,0.3); border-radius:8px; color:rgba(230,57,70,0.7); font-family:'DM Sans',sans-serif; font-size:0.75rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
        .btn-delete:hover { background:rgba(230,57,70,0.1); border-color:var(--accent); color:var(--accent); }

        .empty-state { text-align:center; padding:80px 20px; color:var(--muted); }
        .empty-state .icon { font-size:3rem; margin-bottom:16px; opacity:0.4; }
        .spinner { width:40px; height:40px; border:3px solid var(--border); border-top-color:var(--accent); border-radius:50%; animation:spin 0.8s linear infinite; margin:60px auto; }

        /* MODAL */
        .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.7); backdrop-filter:blur(4px); z-index:100; display:flex; align-items:center; justify-content:center; opacity:0; pointer-events:none; transition:opacity 0.2s; }
        .modal-overlay.show { opacity:1; pointer-events:all; }
        .modal { background:var(--card); border:1px solid var(--border); border-radius:20px; padding:36px; max-width:360px; width:90%; text-align:center; transform:scale(0.92); transition:transform 0.2s cubic-bezier(0.34,1.56,0.64,1); }
        .modal-overlay.show .modal { transform:scale(1); }
        .modal .modal-icon { font-size:2.5rem; margin-bottom:12px; }
        .modal h4 { font-family:'Bebas Neue',sans-serif; font-size:1.6rem; letter-spacing:2px; margin-bottom:8px; }
        .modal p { color:var(--muted); font-size:0.9rem; margin-bottom:28px; }
        .modal-btns { display:flex; gap:10px; }
        .modal-btns button { flex:1; }

        /* TOAST */
        .toast { position:fixed; bottom:32px; right:32px; background:var(--success); color:#fff; padding:14px 24px; border-radius:12px; font-weight:600; font-size:0.9rem; z-index:999; transform:translateY(80px); opacity:0; transition:all 0.3s cubic-bezier(0.34,1.56,0.64,1); }
        .toast.show { transform:translateY(0); opacity:1; }
        .toast.error { background:var(--accent); }

        /* TIPOS */
        .t-fire     { background:rgba(230,80,30,0.18);  color:#ff6b35; border:1px solid rgba(230,80,30,0.3); }
        .t-water    { background:rgba(41,128,239,0.18); color:#4da8ff; border:1px solid rgba(41,128,239,0.3); }
        .t-grass    { background:rgba(63,161,41,0.18);  color:#5dbb37; border:1px solid rgba(63,161,41,0.3); }
        .t-electric { background:rgba(240,192,0,0.18);  color:#f5cc00; border:1px solid rgba(240,192,0,0.3); }
        .t-poison   { background:rgba(155,89,182,0.18); color:#b97fe8; border:1px solid rgba(155,89,182,0.3); }
        .t-normal   { background:rgba(150,150,150,0.18);color:#aaa;    border:1px solid rgba(150,150,150,0.3); }
        .t-flying   { background:rgba(137,174,245,0.18);color:#89aef5; border:1px solid rgba(137,174,245,0.3); }
        .t-bug      { background:rgba(145,161,25,0.18); color:#a8bb1f; border:1px solid rgba(145,161,25,0.3); }
        .t-ground   { background:rgba(200,160,44,0.18); color:#c8a02c; border:1px solid rgba(200,160,44,0.3); }
        .t-psychic  { background:rgba(230,21,90,0.18);  color:#ff4d8b; border:1px solid rgba(230,21,90,0.3); }
        .t-rock     { background:rgba(184,160,56,0.18); color:#c8a938; border:1px solid rgba(184,160,56,0.3); }
        .t-ice      { background:rgba(152,216,216,0.18);color:#98d8d8; border:1px solid rgba(152,216,216,0.3); }
        .t-dragon   { background:rgba(112,56,248,0.18); color:#9b6dff; border:1px solid rgba(112,56,248,0.3); }
        .t-ghost    { background:rgba(112,88,152,0.18); color:#9b7fd4; border:1px solid rgba(112,88,152,0.3); }
        .t-dark     { background:rgba(112,88,72,0.18);  color:#a08070; border:1px solid rgba(112,88,72,0.3); }
        .t-steel    { background:rgba(184,184,208,0.18);color:#b8b8d0; border:1px solid rgba(184,184,208,0.3); }
        .t-fairy    { background:rgba(240,160,200,0.18);color:#f0a0c8; border:1px solid rgba(240,160,200,0.3); }
        .t-fighting { background:rgba(192,48,40,0.18);  color:#e05050; border:1px solid rgba(192,48,40,0.3); }

        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        @keyframes float  { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes spin   { to{transform:rotate(360deg)} }
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

// ── CADASTRAR ──
async function cadastrarPokemon() {
    const nome=document.getElementById('f-nome').value.trim();
    const tipo=document.getElementById('f-tipo').value;
    const ataque=parseInt(document.getElementById('f-ataque').value);
    if(!nome||!tipo||!ataque) return showToast('Preencha todos os campos',true);
    try {
        const r=await fetch('/pokemon/novo',{
            method:'POST',
            headers:{'Content-Type':'application/json','X-Requested-With':'XMLHttpRequest'},
            body:JSON.stringify({nome,tipo,ataque})
        });
        const d=await r.json();
        if(!r.ok) return showToast('Erro ao cadastrar',true);
        showToast(`✅ ${nome} salvo! ID #${d.id_banco}`);
        document.getElementById('f-nome').value='';
        document.getElementById('f-tipo').value='';
        document.getElementById('f-ataque').value='';
        atualizarPreview();
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
            const imagemSeguro = escaparTexto(p.imagem);

            return `
            <div class="banco-card" id="card-${p.id}" style="animation-delay:${i*0.05}s">
                <div class="bc-id">#${String(p.id).padStart(3,'0')}</div>

                <div class="bc-art" id="art-${p.id}">
                    ${
                        p.imagem
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