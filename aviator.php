<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PESA AFRICA | Real Aviator</title>
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
            --primary: #000000; --success: #22c55e; --danger: #ef4444;
            --dark-bg: #0b0e14; --card-bg: #1e293b; --white: #ffffff;
            --text-dark: #1e293b; --text-muted: #64748b;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--dark-bg); margin: 0; color: white; overflow: hidden; }
        
        /* Header */
        .header { padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; background: #1e293b; border-bottom: 1px solid #334155; position: sticky; top: 0; z-index: 1000; }
        .menu-toggle { font-size: 20px; cursor: pointer; color: white; background: #334155; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
        .brand-text { font-weight: 800; font-size: 18px; }
        .brand-text span { color: var(--danger); }
        .balance-pill { background: rgba(34, 197, 94, 0.1); padding: 5px 12px; border-radius: 20px; border: 1px solid var(--success); font-weight: 800; font-size: 12px; color: var(--success); }

        /* Aviator Game UI */
        .game-container { padding: 15px; text-align: center; }
        .aviator-screen {
            background: #000; height: 260px; border-radius: 20px; border: 2px solid #334155;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            position: relative; overflow: hidden; margin-bottom: 15px;
            background-image: radial-gradient(circle at bottom left, rgba(239, 68, 68, 0.15), transparent);
        }
        
        #chartCanvas { position: absolute; bottom: 0; left: 0; width: 100%; height: 100%; z-index: 1; }

        .multiplier { font-size: 55px; font-weight: 800; color: white; z-index: 10; text-shadow: 0 0 20px rgba(255,255,255,0.3); }
        .multiplier.crashed { color: var(--danger) !important; animation: shake 0.3s infinite; }
        
        .plane-icon { 
            position: absolute; bottom: 10%; left: 10%; color: var(--danger); 
            font-size: 32px; z-index: 11; transform: rotate(-10deg);
            filter: drop-shadow(0 0 10px rgba(239, 68, 68, 0.8));
            display: none;
        }

        /* Betting Card */
        .bet-card { background: var(--card-bg); padding: 18px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); }
        .bet-controls { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px; }
        .control-box { background: #0f172a; border: 1px solid #334155; padding: 10px; border-radius: 12px; text-align: left; }
        .label { font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-bottom: 4px; }
        .control-box input { background: transparent; border: none; color: white; font-weight: 800; font-size: 16px; width: 100%; outline: none; }
        .live-money { color: var(--success); font-weight: 800; font-size: 16px; display: block; }

        .btn-main {
            width: 100%; padding: 18px; border-radius: 15px; border: none;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white; font-weight: 800; font-size: 18px; cursor: pointer;
            transition: 0.2s; text-transform: uppercase;
        }
        .btn-main.cashout { background: linear-gradient(135deg, #fbbf24, #d97706); color: #000; box-shadow: 0 0 20px rgba(234, 179, 8, 0.4); }
        .btn-main:disabled { opacity: 0.5; filter: grayscale(1); }

        @keyframes shake {
            0%, 100% { transform: translate(0,0); }
            25% { transform: translate(-2px, 2px); }
            75% { transform: translate(2px, -2px); }
        }

        /* Sidebar Sidebar (Corrected) */
        .side-menu { 
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%; 
            background: var(--white); z-index: 2000; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 30px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.3); 
        }
        .side-menu.active { left: 0; }
        .menu-item { 
            display: flex; align-items: center; gap: 12px; padding: 14px; 
            color: var(--text-dark); text-decoration: none; font-weight: 600; 
            border-radius: 12px; margin-bottom: 5px; font-size: 14px; 
        }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: none; z-index: 1500; backdrop-filter: blur(4px); }
    </style>
</head>
<body>
    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>
    
    <div class="header">
        <div class="menu-toggle" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="brand-text">Jet<span>Fly</span></div>
        <div class="balance-pill" id="topBal">0 RWF</div>
    </div>

    <div class="game-container">
        <div class="aviator-screen" id="screen">
            <canvas id="chartCanvas"></canvas>
            <div class="multiplier" id="mult">1.00x</div>
            <i class="fa-solid fa-plane-up plane-icon" id="jet"></i>
        </div>

        <div class="bet-card">
            <div class="bet-controls">
                <div class="control-box">
                    <div class="label">Amount (RWF)</div>
                    <input type="number" id="betAmount" value="500" min="100">
                </div>
                <div class="control-box">
                    <div class="label">Live Win</div>
                    <span class="live-money" id="liveMoney">0 RWF</span>
                </div>
            </div>

            <button class="btn-main" id="actionBtn" onclick="handleAction()">BET</button>
            <p id="statusMsg" style="font-size: 11px; margin-top: 10px; color: #94a3b8;">Place bet and watch profit increase!</p>
        </div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div id="menuUser" style="font-weight: 800; font-size: 18px; color: var(--text-dark);">User</div>
            <div style="font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase;">PRO MEMBER</div>
        </div>
        
        <nav class="menu-list">
            <a href="dashboard.html" class="menu-item"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="Withdraw_bonus.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Withdraw Bonus</a>
            <a href="Withdraw_Task_Balance.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Withdraw Task Balance</a>
            <a href="spin.html" class="menu-item"><i class="fa-solid fa-dharmachakra"></i> Lucky Spin <span style="margin-left: auto; font-size: 10px; background: var(--success); color: white; padding: 2px 8px; border-radius: 10px;">2 Left</span></a>
            <a href="aviator.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Aviator Betting</a>
            <a href="image_task.html" class="menu-item"><i class="fa-solid fa-image"></i> Image Tasks</a>
            <a href="video_task.html" class="menu-item"><i class="fa-solid fa-circle-play"></i> Video Tasks</a>
                 <a href="Forex_Trading_Task.html" class="menu-item"><i class="fa-solid fa-chart-simple"></i> Forex Task</a>
            <a href="buy_followers_subscribers.html" class="menu-item"><i class="fa-solid fa-users-viewfinder"></i> Buy Follower&Subscribers</a>
            <a href="login.html" onclick="logout()" class="menu-item" style="color: var(--danger);"><i class="fa-solid fa-right-from-bracket"></i> Logout Account</a>
        </nav>
    </div>

    <script>
        const currentUser = localStorage.getItem("current_user");
        let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
        let userData = users.find(u => u.username === currentUser);

        if(!userData) window.location.href = 'login.html';

        const canvas = document.getElementById('chartCanvas');
        const ctx = canvas.getContext('2d');
        let animationId;
        let isFlying = false;
        let currentMultiplier = 1.00;
        let crashPoint = 0;
        let flightStartTime;
        let activeBet = 0;

        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;

        function updateUI() {
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("topBal").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
        }
        updateUI();

        function handleAction() {
            const betInput = document.getElementById("betAmount");
            if (!isFlying) {
                activeBet = parseInt(betInput.value);
                if (activeBet > userData.taskBalance) return alert("Insufficient Task Balance!");
                if (activeBet < 100) return alert("Minimum bet is 100 RWF");
                userData.taskBalance -= activeBet;
                saveData();
                updateUI();
                startFlight();
            } else {
                cashOut();
            }
        }

        function startFlight() {
            isFlying = true;
            currentMultiplier = 1.00;
            const btn = document.getElementById("actionBtn");
            const jet = document.getElementById("jet");
            crashPoint = Math.random() < 0.4 ? (1.05 + Math.random() * 0.8) : (2.0 + Math.random() * 10);
            btn.innerText = "CASH OUT";
            btn.className = "btn-main cashout";
            jet.style.display = "block";
            document.getElementById("mult").classList.remove("crashed");
            flightStartTime = performance.now();
            animate();
        }

        function animate() {
            if (!isFlying) return;
            let now = performance.now();
            let elapsed = (now - flightStartTime) / 1000; 
            currentMultiplier = Math.pow(1.15, elapsed * 1.8);
            let liveProfit = Math.floor(activeBet * currentMultiplier);
            document.getElementById("liveMoney").innerText = liveProfit.toLocaleString() + " RWF";
            document.getElementById("mult").innerText = currentMultiplier.toFixed(2) + "x";
            let x = (elapsed / 10) * canvas.width + 50;
            let y = canvas.height - ((currentMultiplier - 1) * 35) - 60;
            const jet = document.getElementById("jet");
            jet.style.left = Math.min(x, canvas.width - 40) + "px";
            jet.style.bottom = Math.min(canvas.height - y, canvas.height - 40) + "px";
            ctx.clearRect(0,0, canvas.width, canvas.height);
            ctx.beginPath();
            ctx.strokeStyle = "#ef4444";
            ctx.lineWidth = 5;
            ctx.moveTo(0, canvas.height);
            ctx.quadraticCurveTo(x/2, canvas.height, x, y);
            ctx.stroke();
            if (currentMultiplier >= crashPoint) {
                crash();
            } else {
                animationId = requestAnimationFrame(animate);
            }
        }

        function cashOut() {
            isFlying = false;
            cancelAnimationFrame(animationId);
            let winAmount = Math.floor(activeBet * currentMultiplier);
            userData.taskBalance += winAmount;
            saveData();
            alert("CASHOUT: " + winAmount.toLocaleString() + " RWF Collected!");
            resetGame();
        }

        function crash() {
            isFlying = false;
            cancelAnimationFrame(animationId);
            document.getElementById("mult").innerText = "FLEW AWAY!";
            document.getElementById("mult").classList.add("crashed");
            document.getElementById("jet").style.display = "none";
            document.getElementById("liveMoney").innerText = "0 RWF";
            document.getElementById("liveMoney").style.color = "var(--danger)";
            setTimeout(() => { resetGame(); }, 2000);
        }

        function resetGame() {
            isFlying = false;
            const btn = document.getElementById("actionBtn");
            btn.innerText = "BET";
            btn.className = "btn-main";
            document.getElementById("jet").style.display = "none";
            document.getElementById("liveMoney").style.color = "var(--success)";
            document.getElementById("liveMoney").innerText = "0 RWF";
            ctx.clearRect(0,0, canvas.width, canvas.height);
            updateUI();
        }

        function saveData() {
            users = users.map(u => u.username === currentUser ? userData : u);
            localStorage.setItem("mula_users", JSON.stringify(users));
        }

        function toggleMenu() {
            const menu = document.getElementById("sideMenu");
            const overlay = document.getElementById("overlay");
            menu.classList.toggle('active');
            overlay.style.display = menu.classList.contains('active') ? 'block' : 'none';
        }

        function logout() { localStorage.removeItem("current_user"); window.location.href = 'login.html'; }
    </script>
</body>
</html>

-->




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PESA AFRICA | Real Aviator</title>
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
            --primary: #000000; --success: #22c55e; --danger: #ef4444;
            --dark-bg: #0b0e14; --card-bg: #1e293b; --white: #ffffff;
            --text-dark: #1e293b; --text-muted: #64748b;
            --gold-accent: #ffb700;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--dark-bg); margin: 0; color: white; overflow: hidden; padding-top: 40px; }
        
        /* --- MOVING NOTIFICATION HEADER BANNER --- */
        .ticker-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background: linear-gradient(90deg, #070a12, #151b26);
            border-bottom: 2px solid var(--danger);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            overflow: hidden;
            white-space: nowrap;
            z-index: 2001;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
        }

        .ticker-wrap {
            display: inline-block;
            padding-left: 100%;
            animation: marquee-scroll 26s linear infinite;
        }

        .ticker-msg {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-right: 60px;
            background: rgba(255, 255, 255, 0.05);
            padding: 4px 14px;
            border-radius: 50px;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .ticker-badge {
            background: var(--success);
            color: white;
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

        /* PLATFORM TRUST BADGE STRIP */
        .platform-rules-strip {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            color: #fca5a5;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
        }

        /* Header */
        .header { padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; background: #1e293b; border-bottom: 1px solid #334155; position: sticky; top: 40px; z-index: 1000; }
        .menu-toggle { font-size: 20px; cursor: pointer; color: white; background: #334155; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
        .brand-text { font-weight: 800; font-size: 18px; }
        .brand-text span { color: var(--danger); }
        .balance-pill { background: rgba(34, 197, 94, 0.1); padding: 5px 12px; border-radius: 20px; border: 1px solid var(--success); font-weight: 800; font-size: 12px; color: var(--success); }

        /* Aviator Game UI */
        .game-container { padding: 15px; text-align: center; }
        .aviator-screen {
            background: #000; height: 260px; border-radius: 20px; border: 2px solid #334155;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            position: relative; overflow: hidden; margin-bottom: 15px;
            background-image: radial-gradient(circle at bottom left, rgba(239, 68, 68, 0.15), transparent);
        }
        
        #chartCanvas { position: absolute; bottom: 0; left: 0; width: 100%; height: 100%; z-index: 1; }

        .multiplier { font-size: 55px; font-weight: 800; color: white; z-index: 10; text-shadow: 0 0 20px rgba(255,255,255,0.3); }
        .multiplier.crashed { color: var(--danger) !important; animation: shake 0.3s infinite; }
        
        .plane-icon { 
            position: absolute; bottom: 10%; left: 10%; color: var(--danger); 
            font-size: 32px; z-index: 11; transform: rotate(-10deg);
            filter: drop-shadow(0 0 10px rgba(239, 68, 68, 0.8));
            display: none;
        }

        /* Betting Card */
        .bet-card { background: var(--card-bg); padding: 18px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.05); }
        .bet-controls { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px; }
        .control-box { background: #0f172a; border: 1px solid #334155; padding: 10px; border-radius: 12px; text-align: left; }
        .label { font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-bottom: 4px; }
        .control-box input { background: transparent; border: none; color: white; font-weight: 800; font-size: 16px; width: 100%; outline: none; }
        .live-money { color: var(--success); font-weight: 800; font-size: 16px; display: block; }

        .btn-main {
            width: 100%; padding: 18px; border-radius: 15px; border: none;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white; font-weight: 800; font-size: 18px; cursor: pointer;
            transition: 0.2s; text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(34, 197, 150, 0.2);
        }
        .btn-main.cashout { background: linear-gradient(135deg, #fbbf24, #d97706); color: #000; box-shadow: 0 0 20px rgba(234, 179, 8, 0.4); }
        .btn-main:disabled { opacity: 0.5; filter: grayscale(1); cursor: not-allowed; }

        @keyframes shake {
            0%, 100% { transform: translate(0,0); }
            25% { transform: translate(-2px, 2px); }
            75% { transform: translate(2px, -2px); }
        }

        /* Sidebar Sidebar (Corrected) */
        .side-menu { 
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%; 
            background: var(--white); z-index: 2100; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 30px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.5); 
        }
        .side-menu.active { left: 0; }
        .menu-item { 
            display: flex; align-items: center; gap: 12px; padding: 14px; 
            color: var(--text-dark); text-decoration: none; font-weight: 600; 
            border-radius: 12px; margin-bottom: 5px; font-size: 14px; 
        }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: none; z-index: 2050; backdrop-filter: blur(4px); }
    </style>
</head>
<body>
    <!-- MOVING NOTIFICATION HEADER BANNER -->
    <div class="ticker-header">
        <div class="ticker-wrap">
            <div class="ticker-msg">
                <span class="ticker-badge">Paid</span>
                <span>🎉 <strong>alice 078*****44</strong> successful withdrawn <strong>20000 rwf</strong> from paypesa africa 🔥</span>
            </div>
            <div class="ticker-msg">
                <span class="ticker-badge">Paid</span>
                <span>⚡ <strong>Gakire 079*****81</strong> successful withdrawn <strong>12500 rwf</strong> from paypesa africa 🚀</span>
            </div>
            <div class="ticker-msg">
                <span class="ticker-badge">Paid</span>
                <span>💎 <strong>Kevine 078*****32</strong> successful withdrawn <strong>30000 rwf</strong> from paypesa africa 💰</span>
            </div>
        </div>
    </div>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>
    
    <div class="header">
        <div class="menu-toggle" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="brand-text">Jet<span>Fly</span> 🚀</div>
        <div class="balance-pill" id="topBal">0 RWF</div>
    </div>

    <div class="game-container">
        <!-- PLATFORM POLICIES BADGE -->
        <div class="platform-rules-strip">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Daily Profit Room Cap: Max 15,000 RWF • Required Balance: 500 RWF 🔒</span>
        </div>

        <div class="aviator-screen" id="screen">
            <canvas id="chartCanvas"></canvas>
            <div class="multiplier" id="mult">1.00x</div>
            <i class="fa-solid fa-plane-up plane-icon" id="jet"></i>
        </div>

        <div class="bet-card">
            <div class="bet-controls">
                <div class="control-box">
                    <div class="label">💸 Amount (RWF)</div>
                    <input type="number" id="betAmount" value="500" min="100">
                </div>
                <div class="control-box">
                    <div class="label">✅ Live Win</div>
                    <span class="live-money" id="liveMoney">0 RWF</span>
                </div>
            </div>

            <button class="btn-main" id="actionBtn" onclick="handleAction()">BET</button>
            <p id="statusMsg" style="font-size: 11px; margin-top: 10px; color: #94a3b8;">Place bet and watch profit increase instantly!</p>
        </div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div id="menuUser" style="font-weight: 800; font-size: 18px; color: var(--text-dark);">User</div>
            <div style="font-size: 11px; color: var(--success); font-weight: 700; text-transform: uppercase;">PRO MEMBER ✅</div>
        </div>
        
        <nav class="menu-list">
                       <a href="dashboard.html" class="menu-item active"><i class="fa-solid fa-house"></i> Dashboard⚫</a>
            <a href="Withdraw_bonus.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Withdraw Bonus✅</a>
            <a href="Withdraw_Task_Balance.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Withdraw Task Balance✅</a>
            <a href="spin.html" class="menu-item"><i class="fa-solid fa-dharmachakra"></i> Daily Bonus🔴 <span style="margin-left: auto; font-size: 10px; background: var(--success); color: white; padding: 2px 8px; border-radius: 10px; font-weight: 800;">2 Left 🔥</span></a>
            <a href="aviator.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Find Cash🔴</a>
            <a href="image_task.html" class="menu-item"><i class="fa-solid fa-image"></i> Product Image🔴</a>
            <a href="video_task.html" class="menu-item"><i class="fa-solid fa-circle-play"></i> Earning Video🔴</a>
            <a href="Forex_Trading_Task.html" class="menu-item"><i class="fa-solid fa-chart-simple"></i> Free Trading🔴</a>
            <a href="buy_followers_subscribers.html" class="menu-item"><i class="fa-solid fa-users-viewfinder"></i>Follower&Subscribers⚫</a>
            <a href="login.html" onclick="logout()" class="menu-item" style="color: var(--danger);"><i class="fa-solid fa-right-from-bracket"></i> Logout Account</a>
        </nav>
    </div>

    <script>
        const currentUser = localStorage.getItem("current_user");
        let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
        let userData = users.find(u => u.username === currentUser);

        if(!userData) window.location.href = 'login.html';

        // TRACK DAILY AVIATOR CAP SESSIONS WITHIN STORAGE OBJECT
        if (userData.dailyAviatorProfit === undefined) userData.dailyAviatorProfit = 0;

        const canvas = document.getElementById('chartCanvas');
        const ctx = canvas.getContext('2d');
        let animationId;
        let isFlying = false;
        let currentMultiplier = 1.00;
        let crashPoint = 0;
        let flightStartTime;
        let activeBet = 0;

        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;

        function updateUI() {
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("topBal").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
            
            // CHECK EARNING SAFEGUARDS BEFORE INITIATING INTERACTION
            const btn = document.getElementById("actionBtn");
            if (userData.dailyAviatorProfit >= 15000) {
                btn.disabled = true;
                btn.innerText = "LIMIT REACHED";
                document.getElementById("statusMsg").innerText = "Daily earning limit reached (Max 15,000 RWF). Try again tomorrow!";
                document.getElementById("statusMsg").style.color = "var(--danger)";
            }
        }
        updateUI();

        function handleAction() {
            const betInput = document.getElementById("betAmount");
            
            // 1. REQUIRE MINIMUM SYSTEM PLAYING AMOUNT OF 500 BALANCE
            if ((userData.taskBalance || 0) < 500) {
                return alert("⚠️ Playing Requires a minimum balance of 500 RWF!");
            }

            // 2. DAILY MAXIMUM SYSTEM LIMIT CHECK 
            if (userData.dailyAviatorProfit >= 15000) {
                return alert("⚠️ Daily limit reached! Maximum daily earning amount is 15,000 RWF.");
            }

            if (!isFlying) {
                activeBet = parseInt(betInput.value);
                if (activeBet > userData.taskBalance) return alert("Insufficient Task Balance!");
                if (activeBet < 100) return alert("Minimum bet is 100 RWF");
                userData.taskBalance -= activeBet;
                saveData();
                updateUI();
                startFlight();
            } else {
                cashOut();
            }
        }

        function startFlight() {
            isFlying = true;
            currentMultiplier = 1.00;
            const btn = document.getElementById("actionBtn");
            const jet = document.getElementById("jet");
            crashPoint = Math.random() < 0.4 ? (1.05 + Math.random() * 0.8) : (2.0 + Math.random() * 10);
            btn.innerText = "CASH OUT";
            btn.className = "btn-main cashout";
            jet.style.display = "block";
            document.getElementById("mult").classList.remove("crashed");
            flightStartTime = performance.now();
            animate();
        }

        function animate() {
            if (!isFlying) return;
            let now = performance.now();
            let elapsed = (now - flightStartTime) / 1000; 
            currentMultiplier = Math.pow(1.15, elapsed * 1.8);
            let liveProfit = Math.floor(activeBet * currentMultiplier);
            document.getElementById("liveMoney").innerText = liveProfit.toLocaleString() + " RWF";
            document.getElementById("mult").innerText = currentMultiplier.toFixed(2) + "x";
            let x = (elapsed / 10) * canvas.width + 50;
            let y = canvas.height - ((currentMultiplier - 1) * 35) - 60;
            const jet = document.getElementById("jet");
            jet.style.left = Math.min(x, canvas.width - 40) + "px";
            jet.style.bottom = Math.min(canvas.height - y, canvas.height - 40) + "px";
            ctx.clearRect(0,0, canvas.width, canvas.height);
            ctx.beginPath();
            ctx.strokeStyle = "#ef4444";
            ctx.lineWidth = 5;
            ctx.moveTo(0, canvas.height);
            ctx.quadraticCurveTo(x/2, canvas.height, x, y);
            ctx.stroke();
            if (currentMultiplier >= crashPoint) {
                crash();
            } else {
                animationId = requestAnimationFrame(animate);
            }
        }

        function cashOut() {
            isFlying = false;
            cancelAnimationFrame(animationId);
            let winAmount = Math.floor(activeBet * currentMultiplier);
            let netProfit = winAmount - activeBet;

            // 3. STOP PLAYING INTERRUPT IF RETRIEVED WIN EXCEEDS CAPPED MARGINS
            if (userData.dailyAviatorProfit + netProfit > 15000) {
                let allowedProfit = 15000 - userData.dailyAviatorProfit;
                winAmount = activeBet + allowedProfit;
                netProfit = allowedProfit;
                alert("🔒 Max Daily Profit Cap Applied!");
            }

            userData.dailyAviatorProfit += netProfit;
            userData.taskBalance += winAmount;
            saveData();
            alert("CASHOUT: " + winAmount.toLocaleString() + " RWF Collected!");
            resetGame();
        }

        function crash() {
            isFlying = false;
            cancelAnimationFrame(animationId);
            document.getElementById("mult").innerText = "FLEW AWAY!";
            document.getElementById("mult").classList.add("crashed");
            document.getElementById("jet").style.display = "none";
            document.getElementById("liveMoney").innerText = "0 RWF";
            document.getElementById("liveMoney").style.color = "var(--danger)";
            setTimeout(() => { resetGame(); }, 2000);
        }

        function resetGame() {
            isFlying = false;
            const btn = document.getElementById("actionBtn");
            btn.innerText = "BET";
            btn.className = "btn-main";
            document.getElementById("jet").style.display = "none";
            document.getElementById("liveMoney").style.color = "var(--success)";
            document.getElementById("liveMoney").innerText = "0 RWF";
            ctx.clearRect(0,0, canvas.width, canvas.height);
            updateUI();
        }

        function saveData() {
            users = users.map(u => u.username === currentUser ? userData : u);
            localStorage.setItem("mula_users", JSON.stringify(users));
        }

        function toggleMenu() {
            const menu = document.getElementById("sideMenu");
            const overlay = document.getElementById("overlay");
            menu.classList.toggle('active');
            overlay.style.display = menu.classList.contains('active') ? 'block' : 'none';
        }

        function logout() { localStorage.removeItem("current_user"); window.location.href = 'login.html'; }
    </script>
</body>
</html>
