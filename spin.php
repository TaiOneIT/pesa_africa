<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PESA AFRICA | Premium Lucky Spin</title>
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
            --gold: #00c3ff;
            --dark-red: #8b0000;
            --bright-red: #ff0000;
            --charcoal: #121212;
            --white: #ffffff;
            --primary: #4e44e7;
            --danger: #ef4444;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle, #1a1a1a, #000000);
            color: var(--white);
            margin: 0;
            overflow-x: hidden;
            height: 100vh;
        }

        /* --- Header --- */
        .header {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.9);
            border-bottom: 2px solid var(--gold);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .balance-container {
            text-align: right;
            background: rgba(255, 215, 0, 0.1);
            padding: 5px 15px;
            border-radius: 10px;
            border: 1px solid var(--gold);
        }

        .balance-label { font-size: 10px; color: var(--gold); font-weight: 800; text-transform: uppercase; }
        .balance-value { font-size: 18px; font-weight: 800; display: block; }

        /* --- Spin UI --- */
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 20px;
        }

        .wheel-outer {
            position: relative;
            width: 300px;
            height: 300px;
            margin-bottom: 40px;
            padding: 12px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 40px rgba(255, 215, 0, 0.4);
        }

        .pointer {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 50;
            color: var(--white);
            font-size: 40px;
            filter: drop-shadow(0 3px 5px black);
        }

        .wheel {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: conic-gradient(
                var(--dark-red) 0deg 45deg, #000 45deg 90deg, 
                var(--dark-red) 90deg 135deg, #000 135deg 180deg, 
                var(--dark-red) 180deg 225deg, #000 225deg 270deg, 
                var(--dark-red) 270deg 315deg, #000 315deg 360deg
            );
            border: 5px solid #222;
            position: relative;
            transition: transform 4s cubic-bezier(0.1, 0, 0.1, 1);
            overflow: hidden;
        }

        .segment-text {
            position: absolute;
            width: 100%;
            height: 100%;
            text-align: center;
            color: var(--gold);
            font-weight: 800;
            font-size: 12px;
            padding-top: 15px;
        }

        .btn-spin {
            background: linear-gradient(180deg, var(--gold), #b8860b);
            color: #000;
            border: none;
            padding: 18px 70px;
            border-radius: 50px;
            font-size: 20px;
            font-weight: 900;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 8px 0 #8b6508, 0 15px 20px rgba(0,0,0,0.5);
            transition: 0.1s;
        }

        .btn-spin:active { transform: translateY(4px); box-shadow: 0 4px 0 #8b6508; }
        .btn-spin:disabled { background: #444; color: #777; box-shadow: none; cursor: not-allowed; }

        /* --- Professional Side Menu --- */
       
        /* --- Side Menu (Styled like Dashboard) --- */
.side-menu {
    position: fixed; 
    top: 0; 
    left: -100%; 
    width: 280px; 
    height: 100%;
    background: var(--white); 
    z-index: 2000; 
    color: #1e293b;
    transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 30px 20px; 
    box-shadow: 25px 0 50px rgba(0,0,0,0.1);
    display: block; /* Ensure it overrides any flex settings */
}

.side-menu.active { left: 0; }

.menu-header {
    margin-bottom: 25px; 
    border-bottom: 1px solid #f1f5f9; 
    padding-bottom: 15px;
    background: none; /* Remove previous spin background */
}

.menu-brand { font-weight: 800; font-size: 20px; letter-spacing: -0.5px; color: #1e293b; }
.menu-brand span { color: var(--primary); }

.menu-item {
    display: flex; 
    align-items: center; 
    gap: 12px; 
    padding: 14px;
    color: #1e293b; 
    text-decoration: none; 
    font-weight: 600;
    border-radius: 12px; 
    margin-bottom: 5px; 
    font-size: 14px;
}

.menu-item i { width: 20px; color: #64748b; } /* Matches --text-muted */

.menu-item.active-page { 
    background: #f1f5f9; 
    color: var(--primary); 
}

.menu-item.active-page i { color: var(--primary); }

/* Logout styling from Dashboard */
.logout-item {
    color: var(--danger) !important; 
    margin-top: 10px; 
    border-top: 1px solid #f1f5f9; 
    padding-top: 20px;
}

        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 1500; }
    </style>
</head>
<body>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <div class="header">
        <div class="menu-btn" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="balance-container">
            <span class="balance-label">Task Balance</span>
            <span class="balance-value" id="headerTaskBalance">0 RWF</span>
        </div>
    </div>

    <div class="main-content">
        <h1 style="color: var(--gold); margin-top: 10px;">LUCKY CASINO</h1>
        <p style="color: #94a3b8; margin-bottom: 30px;">Remaining: <span id="spinLimitText" style="color: var(--gold);">2</span></p>

        <div class="wheel-outer">
            <div class="pointer"><i class="fa-solid fa-caret-down"></i></div>
            <div class="wheel" id="wheel">
                <div class="segment-text" style="transform: rotate(0deg)">100,000</div>
                <div class="segment-text" style="transform: rotate(45deg)">200</div>
                <div class="segment-text" style="transform: rotate(90deg)">5,000</div>
                <div class="segment-text" style="transform: rotate(135deg)">30,000</div>
                <div class="segment-text" style="transform: rotate(180deg)">10,000</div>
                <div class="segment-text" style="transform: rotate(225deg)">500</div>
                <div class="segment-text" style="transform: rotate(270deg)">50,000</div>
                <div class="segment-text" style="transform: rotate(315deg)">00</div>
            </div>
        </div>

        <button class="btn-spin" id="spinBtn" onclick="processSpin()">Spin Now</button>
    </div>

   <div class="side-menu" id="sideMenu">
    <div class="menu-header">
        <div class="menu-brand">Line<span>Stay</span></div>
        <div id="displayUser" style="font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase; margin-top: 5px;">@User</div>
    </div>
    
    <nav>
        <a href="dashboard.html" class="menu-item"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="Withdraw_bonus.html" class="menu-item"><i class="fa-solid fa-wallet"></i> Withdraw Bonus</a>
        <a href="Withdraw_Task_Balance.html" class="menu-item"><i class="fa-solid fa-money-bill-transfer"></i> Withdraw Task Balance</a>
        <a href="spin.html" class="menu-item active-page"><i class="fa-solid fa-dharmachakra"></i> Lucky Spin</a>
        <a href="aviator.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Aviator Betting</a>
        <a href="image_task.html" class="menu-item"><i class="fa-solid fa-image"></i> Image Tasks</a>
        <a href="video_task.html" class="menu-item"><i class="fa-solid fa-circle-play"></i> Video Tasks</a>
        <a href="Forex_Trading_Task.html" class="menu-item"><i class="fa-solid fa-chart-simple"></i> Forex Task</a>
        <a href="buy_followers_subscribers.html" class="menu-item"><i class="fa-solid fa-users-viewfinder"></i> Buy Follower&Subscribers</a>
        
        <a href="login.html" onclick="logout()" class="menu-item logout-item">
            <i class="fa-solid fa-right-from-bracket"></i> Logout Account
        </a>
    </nav>
</div>

<script>
    const currentUser = localStorage.getItem("current_user");
    let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
    let userData = users.find(u => u.username === currentUser);

    if(!userData) window.location.href = 'login.html';

    if (userData.taskBalance === undefined) userData.taskBalance = 0;
    if (userData.spinsPerformed === undefined) userData.spinsPerformed = 0;

    function updateUI() {
        document.getElementById("displayUser").innerText = "@" + currentUser;
        document.getElementById("headerTaskBalance").innerText = userData.taskBalance.toLocaleString() + " RWF";
        document.getElementById("spinLimitText").innerText = (2 - userData.spinsPerformed);
        
        const btn = document.getElementById("spinBtn");
        if(userData.spinsPerformed >= 2) {
            btn.disabled = true;
            btn.innerText = "OUT OF SPINS";
            btn.style.opacity = "0.5";
        } else if (userData.spinsPerformed === 1) {
            btn.disabled = false;
            btn.innerText = "SPIN AGAIN!";
        }
    }
    updateUI();

    function processSpin() {
        const wheel = document.getElementById("wheel");
        const btn = document.getElementById("spinBtn");
        btn.disabled = true;
        btn.innerText = "SPINNING...";

        let amountWon = 0;
        let finalRotation = 0;

        if (userData.spinsPerformed === 0) {
            amountWon = 200;
            finalRotation = 3600 - 45; 
        } else if (userData.spinsPerformed === 1) {
            amountWon = 10000;
            finalRotation = 7200 - 180; 
        }

        wheel.style.transform = `rotate(${finalRotation}deg)`;

        setTimeout(() => {
            userData.taskBalance += amountWon;
            userData.spinsPerformed += 1;
            users = users.map(u => u.username === currentUser ? userData : u);
            localStorage.setItem("mula_users", JSON.stringify(users));

            alert(`🎉 WINNER! You earned ${amountWon.toLocaleString()} RWF!`);
            updateUI();
        }, 4100);
    }

    function toggleMenu() {
        const menu = document.getElementById("sideMenu");
        const overlay = document.getElementById("overlay");
        menu.classList.toggle('active');
        overlay.style.display = menu.classList.contains('active') ? 'block' : 'none';
    }

    function logout() {
        localStorage.removeItem("current_user");
        window.location.href = 'login.html';
    }
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
    <title>PESA AFRICA | Premium Lucky Spin</title>
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
            --gold: #00c3ff;
            --dark-red: #8b0000;
            --bright-red: #ff0000;
            --charcoal: #121212;
            --white: #ffffff;
            --primary: #4e44e7;
            --danger: #ef4444;
            --premium-glow: #00ffaa;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle, #1a1a1a, #000000);
            color: var(--white);
            margin: 0;
            overflow-x: hidden;
            height: 100vh;
            padding-top: 40px; /* Allocated space for the absolute fixed notification ticker */
        }

        /* --- PREMIUM LIVE NOTIFICATION MARQUEE --- */
        .ticker-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background: linear-gradient(90deg, #050505, #111111);
            border-bottom: 2px solid var(--gold);
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
            border: 1px solid rgba(0, 195, 255, 0.2);
        }

        .ticker-badge {
            background: #00c853;
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

        /* HIGH TRUST SYSTEM HUB STICKER */
        .trust-badge-container {
            background: rgba(0, 195, 255, 0.08);
            border: 1px solid rgba(0, 195, 255, 0.15);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            color: #00c3ff;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* --- Header --- */
        .header {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.9);
            border-bottom: 2px solid var(--gold);
            position: sticky;
            top: 40px;
            z-index: 1000;
        }

        .balance-container {
            text-align: right;
            background: rgba(0, 195, 255, 0.1);
            padding: 5px 15px;
            border-radius: 10px;
            border: 1px solid var(--gold);
        }

        .balance-label { font-size: 10px; color: var(--gold); font-weight: 800; text-transform: uppercase; }
        .balance-value { font-size: 18px; font-weight: 800; display: block; color: #ffffff; }

        .menu-btn {
            background: rgba(255, 255, 255, 0.05);
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            color: var(--gold);
            cursor: pointer;
            border: 1px solid rgba(0, 195, 255, 0.2);
        }

        /* --- Spin UI --- */
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 20px;
        }

        .wheel-outer {
            position: relative;
            width: 300px;
            height: 300px;
            margin-bottom: 40px;
            padding: 12px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 40px rgba(0, 195, 255, 0.4);
        }

        .pointer {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 50;
            color: var(--white);
            font-size: 40px;
            filter: drop-shadow(0 3px 5px black);
        }

        .wheel {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: conic-gradient(
                var(--dark-red) 0deg 45deg, #000 45deg 90deg, 
                var(--dark-red) 90deg 135deg, #000 135deg 180deg, 
                var(--dark-red) 180deg 225deg, #000 225deg 270deg, 
                var(--dark-red) 270deg 315deg, #000 315deg 360deg
            );
            border: 5px solid #222;
            position: relative;
            transition: transform 4s cubic-bezier(0.1, 0, 0.1, 1);
            overflow: hidden;
        }

        .segment-text {
            position: absolute;
            width: 100%;
            height: 100%;
            text-align: center;
            color: var(--gold);
            font-weight: 800;
            font-size: 12px;
            padding-top: 15px;
        }

        .btn-spin {
            background: linear-gradient(180deg, var(--gold), #005f7e);
            color: #000;
            border: none;
            padding: 18px 70px;
            border-radius: 50px;
            font-size: 20px;
            font-weight: 900;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 8px 0 #004055, 0 15px 20px rgba(0,0,0,0.5);
            transition: 0.1s;
        }

        .btn-spin:active { transform: translateY(4px); box-shadow: 0 4px 0 #004055; }
        .btn-spin:disabled { background: #444; color: #777; box-shadow: none; cursor: not-allowed; }

        /* --- Professional Side Menu --- */
       
        /* --- Side Menu (Styled like Dashboard) --- */
.side-menu {
    position: fixed; 
    top: 0; 
    left: -100%; 
    width: 280px; 
    height: 100%;
    background: var(--white); 
    z-index: 2100; 
    color: #1e293b;
    transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 30px 20px; 
    box-shadow: 25px 0 50px rgba(0,0,0,0.3);
    display: block; /* Ensure it overrides any flex settings */
}

.side-menu.active { left: 0; }

.menu-header {
    margin-bottom: 25px; 
    border-bottom: 1px solid #f1f5f9; 
    padding-bottom: 15px;
    background: none; /* Remove previous spin background */
}

.menu-brand { font-weight: 800; font-size: 20px; letter-spacing: -0.5px; color: #1e293b; }
.menu-brand span { color: var(--primary); }

.menu-item {
    display: flex; 
    align-items: center; 
    gap: 12px; 
    padding: 14px;
    color: #1e293b; 
    text-decoration: none; 
    font-weight: 600;
    border-radius: 12px; 
    margin-bottom: 5px; 
    font-size: 14px;
}

.menu-item i { width: 20px; color: #64748b; } /* Matches --text-muted */

.menu-item.active-page { 
    background: #f1f5f9; 
    color: var(--primary); 
}

.menu-item.active-page i { color: var(--primary); }

/* Logout styling from Dashboard */
.logout-item {
    color: var(--danger) !important; 
    margin-top: 10px; 
    border-top: 1px solid #f1f5f9; 
    padding-top: 20px;
}

        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: none; z-index: 2050; backdrop-filter: blur(3px); }
    </style>
</head>
<body>

    <!-- MOVING NOTIFICATION HEADER BANNER -->
    <div class="ticker-header">
        <div class="ticker-wrap">
            <div class="ticker-msg">
                <span class="ticker-badge">Success</span>
                <span>🎉 <strong>alice 078*****44</strong> successful withdrawn <strong>20000 rwf</strong> from paypesa africa 🔥</span>
            </div>
            <div class="ticker-msg">
                <span class="ticker-badge">Success</span>
                <span>⚡ <strong>Musa 079*****21</strong> successful withdrawn <strong>35000 rwf</strong> from paypesa africa 🚀</span>
            </div>
            <div class="ticker-msg">
                <span class="ticker-badge">Success</span>
                <span>💎 <strong>Karasira 078*****05</strong> successful withdrawn <strong>50000 rwf</strong> from paypesa africa 💰</span>
            </div>
        </div>
    </div>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <div class="header">
        <div class="menu-btn" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="balance-container">
            <span class="balance-label">Task Balance 💰</span>
            <span class="balance-value" id="headerTaskBalance">0 RWF</span>
        </div>
    </div>

    <div class="main-content">
        <!-- TRUST LAYOUT STRIP -->
        <div class="trust-badge-container">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Secured Payment Nodes Active • Guaranteed Remittance 🔒</span>
        </div>

        <h1 style="color: var(--gold); margin-top: 10px; text-shadow: 0 0 15px rgba(0, 195, 255, 0.4);">🎰 LUCKY CASINO 🎰</h1>
        <p style="color: #94a3b8; margin-bottom: 30px; font-weight: 700;">Remaining Spins: <span id="spinLimitText" style="color: var(--premium-glow);">2</span> ✨</p>

        <div class="wheel-outer">
            <div class="pointer"><i class="fa-solid fa-caret-down"></i></div>
            <div class="wheel" id="wheel">
                <div class="segment-text" style="transform: rotate(0deg)">100,000</div>
                <div class="segment-text" style="transform: rotate(45deg)">200</div>
                <div class="segment-text" style="transform: rotate(90deg)">5,000</div>
                <div class="segment-text" style="transform: rotate(135deg)">30,000</div>
                <div class="segment-text" style="transform: rotate(180deg)">10,000</div>
                <div class="segment-text" style="transform: rotate(225deg)">500</div>
                <div class="segment-text" style="transform: rotate(270deg)">50,000</div>
                <div class="segment-text" style="transform: rotate(315deg)">00</div>
            </div>
        </div>

        <button class="btn-spin" id="spinBtn" onclick="processSpin()">Spin Now 🚀</button>
    </div>

   <div class="side-menu" id="sideMenu">
    <div class="menu-header">
        <div class="menu-brand">Line<span>Stay</span></div>
        <div id="displayUser" style="font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase; margin-top: 5px;">@User</div>
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
        
        <a href="login.html" onclick="logout()" class="menu-item logout-item">
            <i class="fa-solid fa-right-from-bracket"></i> Logout Account
        </a>
    </nav>
</div>

<script>
    const currentUser = localStorage.getItem("current_user");
    let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
    let userData = users.find(u => u.username === currentUser);

    if(!userData) window.location.href = 'login.html';

    if (userData.taskBalance === undefined) userData.taskBalance = 0;
    if (userData.spinsPerformed === undefined) userData.spinsPerformed = 0;

    function updateUI() {
        document.getElementById("displayUser").innerText = "@" + currentUser;
        document.getElementById("headerTaskBalance").innerText = userData.taskBalance.toLocaleString() + " RWF";
        document.getElementById("spinLimitText").innerText = (2 - userData.spinsPerformed);
        
        const btn = document.getElementById("spinBtn");
        if(userData.spinsPerformed >= 2) {
            btn.disabled = true;
            btn.innerText = "OUT OF SPINS";
            btn.style.opacity = "0.5";
        } else if (userData.spinsPerformed === 1) {
            btn.disabled = false;
            btn.innerText = "SPIN AGAIN!";
        }
    }
    updateUI();

    function processSpin() {
        const wheel = document.getElementById("wheel");
        const btn = document.getElementById("spinBtn");
        btn.disabled = true;
        btn.innerText = "SPINNING...";

        let amountWon = 0;
        let finalRotation = 0;

        if (userData.spinsPerformed === 0) {
            amountWon = 200;
            finalRotation = 3600 - 45; 
        } else if (userData.spinsPerformed === 1) {
            amountWon = 10000;
            finalRotation = 7200 - 180; 
        }

        wheel.style.transform = `rotate(${finalRotation}deg)`;

        setTimeout(() => {
            userData.taskBalance += amountWon;
            userData.spinsPerformed += 1;
            users = users.map(u => u.username === currentUser ? userData : u);
            localStorage.setItem("mula_users", JSON.stringify(users));

            alert(`🎉 WINNER! You earned ${amountWon.toLocaleString()} RWF!`);
            updateUI();
        }, 4100);
    }

    function toggleMenu() {
        const menu = document.getElementById("sideMenu");
        const overlay = document.getElementById("overlay");
        menu.classList.toggle('active');
        overlay.style.display = menu.classList.contains('active') ? 'block' : 'none';
    }

    function logout() {
        localStorage.removeItem("current_user");
        window.location.href = 'login.html';
    }
</script>
</body>
</html>