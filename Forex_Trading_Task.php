<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PESA AFRICA| Digital Forex Terminal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Universal Mobile Layout Fix */
@media (max-width: 600px) {
    body {
        padding: 15px !important; /* Prevents content from touching the screen edges */
    }

    /* Fixes for Payment/Token Cards */
    .token-card, .payment-container, .card {
        width: 100% !important;
        max-width: 100% !important;
        padding: 25px 15px !important;
        margin: 0 auto !important;
        border-radius: 20px !important;
    }

    /* Make Input boxes and Buttons big enough for fingers */
    input[type="text"], input[type="password"], input[type="number"], .btn-confirm {
        width: 100% !important;
        height: 50px !important;
        font-size: 16px !important; /* Prevents iPhone from auto-zooming on text boxes */
        margin-bottom: 15px !important;
    }

    /* Professional spacing for instructions */
    .instructions, .step-text {
        font-size: 14px !important;
        line-height: 1.5 !important;
    }
}

/* Global scroll fix */
html, body {
    overflow-x: hidden;
    width: 100%;
}
        :root {
            --primary: #26ca99;
            --secondary: #eceaf7;
            --success: #22c55e;
            --danger: #ef4444;
            --bg-light: #f8fafc;
            --text-dark: #020408;
            --text-muted: #64748b;
            --white: #ffffff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0b0f1a; margin: 0; color: white; overflow-x: hidden; }

        /* --- Header --- */
        .header {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .menu-toggle { 
            font-size: 22px; cursor: pointer; color: var(--text-dark);
            background: #f1f5f9; width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center; border-radius: 10px;
        }

        .brand-text { font-weight: 800; font-size: 20px; color: var(--text-dark); }
        .brand-text span { color: var(--primary); }

        /* --- Trading Interface --- */
        .market-header { padding: 15px 20px; background: #161b2e; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2d3748; }
        .pair-info h2 { margin: 0; font-size: 18px; }
        .pair-info span { font-size: 12px; color: var(--success); font-weight: 700; }

        .chart-area { width: 100%; height: 260px; background: #0b0f1a; position: relative; padding: 10px 0; }
        #chartCanvas { width: 100%; height: 100%; }

        .live-price-bar { 
            background: #1e293b; padding: 15px; display: flex; 
            justify-content: space-between; align-items: center;
            border-radius: 20px 20px 0 0; margin-top: -20px; position: relative; z-index: 5;
        }
        .price-now { font-size: 24px; font-weight: 800; }

        /* --- Controls --- */
        .trade-controls { padding: 20px; background: var(--white); color: var(--text-dark); border-radius: 0 0 24px 24px; }
        .order-btns { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .btn-order { 
            border: none; padding: 20px; border-radius: 16px; color: white; 
            font-weight: 800; font-size: 16px; cursor: pointer; transition: 0.3s;
        }
        .btn-buy { background: var(--success); box-shadow: 0 6px 15px rgba(34, 197, 94, 0.3); }
        .btn-sell { background: var(--danger); box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3); }
        .btn-order:disabled { background: #cbd5e1; box-shadow: none; cursor: not-allowed; }

        /* --- Side Menu (Dashboard Synced) --- */
        .side-menu {
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%;
            background: var(--white); z-index: 2000; color: var(--text-dark);
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 30px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.1);
        }
        .side-menu.active { left: 0; }
        .menu-item {
            display: flex; align-items: center; gap: 12px; padding: 14px;
            color: var(--text-dark); text-decoration: none; font-weight: 600;
            border-radius: 12px; margin-bottom: 5px; font-size: 14px;
        }
        .menu-item i { width: 20px; color: var(--text-muted); }
        .menu-item.active { background: #f1f5f9; color: var(--primary); }
        
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 1500; }
    </style>
</head>
<body>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <div class="header">
        <div class="menu-toggle" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="brand-text">PESA <N><span>AFRICA</span></div>
        <div style="font-weight: 800; color: var(--success); font-size: 14px;" id="topBal">0 RWF</div>
    </div>

    <div class="market-header">
        <div class="pair-info">
            <h2>EUR/USD <i class="fa-solid fa-caret-down"></i></h2>
            <span><i class="fa-solid fa-bolt"></i> Live Feed</span>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 10px; color: #94a3b8;">EARNING</div>
            <div style="font-weight: 800; color: var(--success);">1,200 RWF</div>
        </div>
    </div>

    <div class="chart-area">
        <canvas id="chartCanvas"></canvas>
    </div>

    <div class="live-price-bar">
        <div>
            <div style="font-size: 10px; color: #94a3b8; font-weight: 700;">PRICE</div>
            <div class="price-now" id="livePrice">1.08420</div>
        </div>
        <div id="tradeTimer" style="font-weight: 800; color: var(--danger); font-size: 18px;">STANDBY</div>
    </div>

    <div class="trade-controls">
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 15px; text-align: center;">
            Choose market direction. Predicting correctly for 15s yields rewards.
        </p>
        <div class="order-btns" id="actionPanel">
            <button class="btn-order btn-buy" onclick="placeOrder('buy')">BUY <br><small>Call</small></button>
            <button class="btn-order btn-sell" onclick="placeOrder('sell')">SELL <br><small>Put</small></button>
        </div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div id="menuUser" style="font-weight: 800; font-size: 18px;">User</div>
            <div style="font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase;">Standard Account</div>
        </div>
        <nav>
            <a href="dashboard.html" class="menu-item"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="Withdraw_bonus.html" class="menu-item"><i class="fa-solid fa-wallet"></i> Withdraw Bonus</a>
            <a href="Withdraw_Task_Balance.html" class="menu-item"><i class="fa-solid fa-money-bill-transfer"></i> Withdraw Task Balance</a>
            <a href="spin.html" class="menu-item"><i class="fa-solid fa-dharmachakra"></i> Lucky Spin</a>
            <a href="aviator.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Aviator Betting</a>
            <a href="image_task.html" class="menu-item"><i class="fa-solid fa-image"></i> Image Tasks</a>
            <a href="video_task.html" class="menu-item"><i class="fa-solid fa-circle-play"></i> Video Tasks</a>
            <a href="Forex_Trading_Task.html" class="menu-item active"><i class="fa-solid fa-chart-simple"></i> Forex Task</a>
            
            <a href="buy_followers_subscribers.html" class="menu-item"><i class="fa-solid fa-users-viewfinder"></i> Buy Follower&Subscribers</a>
            <a href="login.html" onclick="logout()" class="menu-item" style="color: var(--danger); margin-top: 10px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <i class="fa-solid fa-right-from-bracket"></i> Logout Account
            </a>
        </nav>
    </div>

    <script>
        const currentUser = localStorage.getItem("current_user");
        let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
        let userData = users.find(u => u.username === currentUser);

        // --- Chart Logic ---
        const canvas = document.getElementById('chartCanvas');
        const ctx = canvas.getContext('2d');
        let dataPoints = Array.from({length: 45}, () => 1.08400 + Math.random() * 0.001);

        function drawChart() {
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Draw Trend Line
            ctx.beginPath();
            ctx.strokeStyle = '#22c55e';
            ctx.lineWidth = 3;
            ctx.lineJoin = 'round';

            const spacing = canvas.width / (dataPoints.length - 1);
            dataPoints.forEach((p, i) => {
                const x = i * spacing;
                const y = canvas.height - ((p - 1.083) * 100000); 
                if(i === 0) ctx.moveTo(x, y);
                else ctx.lineTo(x, y);
            });
            ctx.stroke();

            // Price Fluctuations
            const last = dataPoints[dataPoints.length - 1];
            const next = last + (Math.random() - 0.5) * 0.0001;
            dataPoints.push(next);
            dataPoints.shift();
            document.getElementById('livePrice').innerText = next.toFixed(5);
            requestAnimationFrame(drawChart);
        }

        // --- Trading Engine ---
        function placeOrder(type) {
            if(userData.forexTaskDone) {
                alert("Task already completed for today!");
                return;
            }

            const entryPrice = parseFloat(document.getElementById('livePrice').innerText);
            const panel = document.getElementById('actionPanel');
            let timer = 15;

            panel.innerHTML = `<div style="grid-column: span 2; text-align:center; padding:20px; background:#f1f5f9; border-radius:15px; font-weight:800; color:var(--secondary); border: 2px solid var(--secondary);">
                ORDER ACTIVE AT ${entryPrice.toFixed(5)}...
            </div>`;

            const countdown = setInterval(() => {
                timer--;
                document.getElementById('tradeTimer').innerText = `00:${timer < 10 ? '0'+timer : timer}`;
                
                if(timer <= 0) {
                    clearInterval(countdown);
                    const exitPrice = parseFloat(document.getElementById('livePrice').innerText);
                    const win = (type === 'buy' && exitPrice > entryPrice) || (type === 'sell' && exitPrice < entryPrice);
                    
                    if(win) {
                        userData.taskBalance = (userData.taskBalance || 0) + 1200;
                        userData.forexTaskDone = true;
                        saveData();
                        alert("TRADE SUCCESS! 1,200 RWF added.");
                        location.reload();
                    } else {
                        alert("MARKET REVERSED. Order Closed with Loss. Try again.");
                        location.reload();
                    }
                }
            }, 1000);
        }

        function updateUI() {
            if(!userData) window.location.href = 'login.html';
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("topBal").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
            
            if(userData.forexTaskDone) {
                document.getElementById('actionPanel').innerHTML = `<button class="btn-order" style="grid-column: span 2; background:var(--secondary); width:100%" disabled>SESSION COMPLETED</button>`;
                document.getElementById('tradeTimer').innerText = "DONE";
            }
        }

        function toggleMenu() {
            const menu = document.getElementById("sideMenu");
            const overlay = document.getElementById("overlay");
            menu.classList.toggle('active');
            overlay.style.display = menu.classList.contains('active') ? 'block' : 'none';
        }

        function saveData() {
            users = users.map(u => u.username === currentUser ? userData : u);
            localStorage.setItem("mula_users", JSON.stringify(users));
        }

        function logout() {
            localStorage.removeItem("current_user");
            window.location.href = 'login.html';
        }

        updateUI();
        drawChart();
    </script>
</body>
</html>

-->





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PESA AFRICA| Digital Forex Terminal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Universal Mobile Layout Fix */
@media (max-width: 600px) {
    body {
        padding: 15px !important; /* Prevents content from touching the screen edges */
    }

    /* Fixes for Payment/Token Cards */
    .token-card, .payment-container, .card {
        width: 100% !important;
        max-width: 100% !important;
        padding: 25px 15px !important;
        margin: 0 auto !important;
        border-radius: 20px !important;
    }

    /* Make Input boxes and Buttons big enough for fingers */
    input[type="text"], input[type="password"], input[type="number"], .btn-confirm {
        width: 100% !important;
        height: 50px !important;
        font-size: 16px !important; /* Prevents iPhone from auto-zooming on text boxes */
        margin-bottom: 15px !important;
    }

    /* Professional spacing for instructions */
    .instructions, .step-text {
        font-size: 14px !important;
        line-height: 1.5 !important;
    }
}

/* Global scroll fix */
html, body {
    overflow-x: hidden;
    width: 100%;
}
        :root {
            --primary: #26ca99;
            --secondary: #eceaf7;
            --success: #22c55e;
            --danger: #ef4444;
            --bg-light: #f8fafc;
            --text-dark: #020408;
            --text-muted: #64748b;
            --white: #ffffff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0b0f1a; margin: 0; color: white; overflow-x: hidden; padding-top: 40px; }

        /* --- MOVING NOTIFICATION HEADER BANNER --- */
        .ticker-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background: linear-gradient(90deg, #090d16, #121824);
            border-bottom: 2px solid var(--primary);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            overflow: hidden;
            white-space: nowrap;
            z-index: 2001;
            box-shadow: 0 4px 15px rgba(0,0,0,0.25);
        }

        .ticker-wrap {
            display: inline-block;
            padding-left: 100%;
            animation: marquee-scroll 28s linear infinite;
        }

        .ticker-msg {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-right: 60px;
            background: rgba(38, 202, 153, 0.08);
            padding: 4px 14px;
            border-radius: 50px;
            border: 1px solid rgba(38, 202, 153, 0.25);
        }

        .ticker-badge {
            background: var(--primary);
            color: #0b0f1a;
            font-size: 9px;
            text-transform: uppercase;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        @keyframes marquee-scroll {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }

        /* --- Header --- */
        .header {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 40px;
            z-index: 1000;
        }

        .menu-toggle { 
            font-size: 22px; cursor: pointer; color: var(--text-dark);
            background: #f1f5f9; width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center; border-radius: 10px;
        }

        .brand-text { font-weight: 800; font-size: 20px; color: var(--text-dark); }
        .brand-text span { color: var(--primary); }

        /* Trust & Verification Badging Grid */
        .secure-badge-strip {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin: 15px 20px 5px;
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
        }
        .secure-badge-strip span { display: inline-flex; align-items: center; gap: 4px; }
        .secure-badge-strip i { color: var(--primary); }

        /* --- Trading Interface --- */
        .market-header { padding: 15px 20px; background: #161b2e; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2d3748; margin-top: 5px; }
        .pair-info h2 { margin: 0; font-size: 18px; display: flex; align-items: center; gap: 6px; }
        .pair-info span { font-size: 12px; color: var(--primary); font-weight: 700; }

        /* MetaTrader Authentic Grid Layout */
        .chart-area { 
            width: 100%; 
            height: 260px; 
            background: #0b0f1a; 
            position: relative; 
            padding: 10px 0; 
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 25px 25px;
            border-bottom: 1px solid #1e293b;
        }
        #chartCanvas { width: 100%; height: 100%; position: relative; z-index: 2; }
        
        /* MT4 Floating Info Label Elements */
        .mt4-watermark { position: absolute; top: 15px; left: 20px; font-size: 11px; font-family: monospace; color: rgba(255,255,255,0.15); font-weight: 700; z-index: 1; pointer-events: none; line-height: 1.4; }

        .live-price-bar { 
            background: #121824; padding: 15px; display: flex; 
            justify-content: space-between; align-items: center;
            border-radius: 20px 20px 0 0; margin-top: -20px; position: relative; z-index: 5;
            border: 1px solid rgba(255,255,255,0.05);
            border-bottom: none;
        }
        .price-now { font-size: 24px; font-weight: 800; color: var(--primary); font-family: monospace; }

        /* --- Controls --- */
        .trade-controls { padding: 20px; background: var(--white); color: var(--text-dark); border-radius: 0 0 24px 24px; }
        .order-btns { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .btn-order { 
            border: none; padding: 20px; border-radius: 16px; color: white; 
            font-weight: 800; font-size: 16px; cursor: pointer; transition: 0.3s;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .btn-buy { background: var(--success); box-shadow: 0 6px 15px rgba(34, 197, 94, 0.3); }
        .btn-sell { background: var(--danger); box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3); }
        .btn-order:disabled { background: #cbd5e1 !important; box-shadow: none !important; cursor: not-allowed; color: #94a3b8 !important; }

        /* --- Side Menu (Dashboard Synced) --- */
        .side-menu {
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%;
            background: var(--white); z-index: 2100; color: var(--text-dark);
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 30px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.15);
        }
        .side-menu.active { left: 0; }
        .menu-item {
            display: flex; align-items: center; gap: 12px; padding: 14px;
            color: var(--text-dark); text-decoration: none; font-weight: 600;
            border-radius: 12px; margin-bottom: 5px; font-size: 14px;
        }
        .menu-item i { width: 20px; color: var(--text-muted); }
        .menu-item.active { background: #f1f5f9; color: var(--primary); }
        
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 2050; backdrop-filter: blur(2px); }
    </style>
</head>
<body>

    <!-- MOVING NOTIFICATION HEADER BANNER -->
    <div class="ticker-header">
        <div class="ticker-wrap">
            <div class="ticker-msg">
                <span class="ticker-badge">Withdrawn</span>
                <span>🎉 <strong>alice 078*****44</strong> successful withdrawn <strong>20000 rwf</strong> from paypesa africa 🔥</span>
            </div>
            <div class="ticker-msg">
                <span class="ticker-badge">Withdrawn</span>
                <span>⚡ <strong>Gakire 079*****81</strong> successful withdrawn <strong>12500 rwf</strong> from paypesa africa 🚀</span>
            </div>
            <div class="ticker-msg">
                <span class="ticker-badge">Withdrawn</span>
                <span>💎 <strong>Kevine 078*****32</strong> successful withdrawn <strong>30000 rwf</strong> from paypesa africa 💰</span>
            </div>
        </div>
    </div>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <div class="header">
        <div class="menu-toggle" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="brand-text">PESA <span>AFRICA</span> 📊</div>
        <div style="font-weight: 800; color: var(--success); font-size: 14px; background: #f1f5f9; padding: 6px 12px; border-radius: 8px;" id="topBal">0 RWF</div>
    </div>

    <!-- TRUST BADGE STRIP -->
    <div class="secure-badge-strip">
        <span><i class="fa-solid fa-circle-check"></i> MT4 Live Server</span>
        <span><i class="fa-solid fa-shield"></i> Verified Gateway</span>
        <span><i class="fa-solid fa-lock"></i> Secured Payout</span>
    </div>

    <div class="market-header">
        <div class="pair-info">
            <h2>EUR/USD <span style="color: #94a3b8; font-size:14px;">[Real-Time]</span> <i class="fa-solid fa-caret-down"></i></h2>
            <span><i class="fa-solid fa-bolt"></i> Live Market Active ✅</span>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 10px; color: #94a3b8; font-weight:700;">PROFIT VALUE</div>
            <div style="font-weight: 800; color: var(--primary);">📈 1,200 RWF</div>
        </div>
    </div>

    <div class="chart-area">
        <div class="mt4-watermark">
            EURUSD, M1<br>
            SPREAD: 0.2 pips<br>
            EXECUTION: INSTANT 🔒
        </div>
        <canvas id="chartCanvas"></canvas>
    </div>

    <div class="live-price-bar">
        <div>
            <div style="font-size: 10px; color: #94a3b8; font-weight: 700;">MT4 ASK PRICE 💸</div>
            <div class="price-now" id="livePrice">1.08420</div>
        </div>
        <div id="tradeTimer" style="font-weight: 800; color: var(--danger); font-size: 16px; background: rgba(239, 68, 68, 0.1); padding: 6px 14px; border-radius: 30px; border: 1px solid rgba(239, 68, 68, 0.2);">STANDBY</div>
    </div>

    <div class="trade-controls">
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px; text-align: center; font-weight: 600;">
            🚀 Choose market direction. Predicting correctly for 15s yields dynamic balance rewards.
        </p>
        <div class="order-btns" id="actionPanel">
            <button class="btn-order btn-buy" onclick="placeOrder('buy')">🟢 BUY <br><small>Call / Up</small></button>
            <button class="btn-order btn-sell" onclick="placeOrder('sell')">🔴 SELL <br><small>Put / Down</small></button>
        </div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div id="menuUser" style="font-weight: 800; font-size: 18px;">User</div>
            <div style="font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase;">Standard Account ✅</div>
        </div>
        <nav>
                      <a href="dashboard.html" class="menu-item active"><i class="fa-solid fa-house"></i> Dashboard⚫</a>
            <a href="Withdraw_bonus.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Withdraw Bonus✅</a>
            <a href="Withdraw_Task_Balance.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Withdraw Task Balance✅</a>
            <a href="spin.html" class="menu-item"><i class="fa-solid fa-dharmachakra"></i> Daily Bonus🔴 <span style="margin-left: auto; font-size: 10px; background: var(--success); color: white; padding: 2px 8px; border-radius: 10px; font-weight: 800;">2 Left 🔥</span></a>
            <a href="aviator.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Find Cash🔴</a>
            <a href="image_task.html" class="menu-item"><i class="fa-solid fa-image"></i> Product Image🔴</a>
            <a href="video_task.html" class="menu-item"><i class="fa-solid fa-circle-play"></i> Earning Video🔴</a>
            <a href="Forex_Trading_Task.html" class="menu-item"><i class="fa-solid fa-chart-simple"></i> Free Trading🔴</a>
            <a href="buy_followers_subscribers.html" class="menu-item"><i class="fa-solid fa-users-viewfinder"></i>Follower&Subscribers⚫</a>
            
            <a href="buy_followers_subscribers.html" class="menu-item"><i class="fa-solid fa-users-viewfinder"></i> Buy Follower&Subscribers</a>
            <a href="login.html" onclick="logout()" class="menu-item" style="color: var(--danger); margin-top: 10px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <i class="fa-solid fa-right-from-bracket"></i> Logout Account
            </a>
        </nav>
    </div>

    <script>
        const currentUser = localStorage.getItem("current_user");
        let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
        let userData = users.find(u => u.username === currentUser);

        // --- Chart Logic ---
        const canvas = document.getElementById('chartCanvas');
        const ctx = canvas.getContext('2d');
        let dataPoints = Array.from({length: 45}, () => 1.08400 + Math.random() * 0.001);

        function drawChart() {
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Draw Trend Line
            ctx.beginPath();
            ctx.strokeStyle = '#26ca99';
            ctx.lineWidth = 3;
            ctx.lineJoin = 'round';

            const spacing = canvas.width / (dataPoints.length - 1);
            dataPoints.forEach((p, i) => {
                const x = i * spacing;
                const y = canvas.height - ((p - 1.083) * 100000); 
                if(i === 0) ctx.moveTo(x, y);
                else ctx.lineTo(x, y);
            });
            ctx.stroke();

            // Price Fluctuations
            const last = dataPoints[dataPoints.length - 1];
            const next = last + (Math.random() - 0.5) * 0.0001;
            dataPoints.push(next);
            dataPoints.shift();
            document.getElementById('livePrice').innerText = next.toFixed(5);
            requestAnimationFrame(drawChart);
        }

        // --- Trading Engine ---
        function placeOrder(type) {
            if(userData.forexTaskDone) {
                alert("Task already completed for today!");
                return;
            }

            const entryPrice = parseFloat(document.getElementById('livePrice').innerText);
            const panel = document.getElementById('actionPanel');
            let timer = 15;

            panel.innerHTML = `<div style="grid-column: span 2; text-align:center; padding:20px; background:#f1f5f9; border-radius:15px; font-weight:800; color:#0f172a; border: 2px solid var(--primary);">
                ⚡ MT4 ORDER EXECUTED AT ${entryPrice.toFixed(5)}...
            </div>`;

            const countdown = setInterval(() => {
                timer--;
                document.getElementById('tradeTimer').innerText = `00:${timer < 10 ? '0'+timer : timer}`;
                
                if(timer <= 0) {
                    clearInterval(countdown);
                    const exitPrice = parseFloat(document.getElementById('livePrice').innerText);
                    const win = (type === 'buy' && exitPrice > entryPrice) || (type === 'sell' && exitPrice < entryPrice);
                    
                    if(win) {
                        userData.taskBalance = (userData.taskBalance || 0) + 1200;
                        userData.forexTaskDone = true;
                        saveData();
                        alert("TRADE SUCCESS! 1,200 RWF added.");
                        location.reload();
                    } else {
                        alert("MARKET REVERSED. Order Closed with Loss. Try again.");
                        location.reload();
                    }
                }
            }, 1000);
        }

        function updateUI() {
            if(!userData) window.location.href = 'login.html';
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("topBal").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
            
            if(userData.forexTaskDone) {
                document.getElementById('actionPanel').innerHTML = `<button class="btn-order" style="grid-column: span 2; background:#cbd5e1; color:#94a3b8; width:100%" disabled>✅ SESSION SECURED & COMPLETED</button>`;
                document.getElementById('tradeTimer').innerText = "DONE";
            }
        }

        function toggleMenu() {
            const menu = document.getElementById("sideMenu");
            const overlay = document.getElementById("overlay");
            menu.classList.toggle('active');
            overlay.style.display = menu.classList.contains('active') ? 'block' : 'none';
        }

        function saveData() {
            users = users.map(u => u.username === currentUser ? userData : u);
            localStorage.setItem("mula_users", JSON.stringify(users));
        }

        function logout() {
            localStorage.removeItem("current_user");
            window.location.href = 'login.html';
        }

        updateUI();
        drawChart();
    </script>
</body>
</html>
















































































































































































































































































































