<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PESA AFRICA | Video Tasks</title>
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
            --primary: #000000; --secondary: #000000; --success: #22c55e;
            --danger: #ef4444; --bg-light: #f1f5f9; --text-dark: #0f172a;
            --text-muted: #64748b; --white: #ffffff;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-light); 
            margin: 0; 
            color: var(--text-dark); 
            line-height: 1.5;
        }

        /* --- Mobile Responsive Header --- */
        .header { 
            padding: 12px 15px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: var(--white); 
            border-bottom: 1px solid #e2e8f0; 
            position: sticky; 
            top: 0; 
            z-index: 1000; 
        }
        .menu-toggle { font-size: 20px; cursor: pointer; background: #f1f5f9; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
        .brand-text { font-weight: 800; font-size: 18px; letter-spacing: -0.5px; }
        .brand-text span { color: var(--primary); }

        /* --- Mobile Balance Card --- */
        .balance-hero { 
            margin: 15px; 
            padding: 20px; 
            background: linear-gradient(135deg, var(--primary), var(--secondary)); 
            border-radius: 20px; 
            color: white; 
            text-align: center; 
            box-shadow: 0 10px 25px rgba(78, 68, 231, 0.25);
        }
        .bal-label { font-size: 10px; text-transform: uppercase; font-weight: 700; opacity: 0.9; letter-spacing: 1.2px; }
        .bal-value { font-size: 28px; font-weight: 800; display: block; margin-top: 4px; }

        /* --- Video Feed Styling --- */
        .container { padding: 0 15px 100px; }
        .section-title { 
            font-size: 11px; 
            color: var(--text-muted); 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            margin: 10px 5px 15px;
            font-weight: 700;
        }

        .video-card { 
            background: var(--white); 
            border-radius: 20px; 
            overflow: hidden; 
            border: 1px solid #ffffff; 
            box-shadow: var(--card-shadow); 
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        
        .video-player-box { 
            width: 100%; 
            aspect-ratio: 16 / 9;
            background: #000; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            position: relative; 
        }
        .video-player-box video { width: 100%; height: 100%; object-fit: cover; }
        
        .timer-overlay { 
            position: absolute; 
            top: 12px; 
            right: 12px; 
            background: rgba(0, 0, 0, 0.6); 
            backdrop-filter: blur(5px);
            color: white; 
            padding: 6px 14px; 
            border-radius: 30px; 
            font-size: 12px; 
            font-weight: 800; 
            display: none; 
            border: 1px solid rgba(255,255,255,0.2);
        }

        .video-info { padding: 15px; text-align: center; }
        .reward-amt { 
            color: var(--success); 
            font-weight: 800; 
            font-size: 18px; 
            display: block; 
            margin-bottom: 12px; 
        }
        
        .btn-watch { 
            width: 100%; 
            padding: 14px; 
            border-radius: 14px; 
            border: none; 
            background: var(--primary); 
            color: white; 
            font-weight: 800; 
            font-size: 14px;
            text-transform: uppercase; 
            cursor: pointer; 
            box-shadow: 0 4px 12px rgba(78, 68, 231, 0.2);
        }
        .btn-watch:active { transform: scale(0.98); }
        .btn-watch:disabled { background: #e2e8f0; color: #94a3b8; box-shadow: none; cursor: not-allowed; }

        /* --- Side Menu Mobile --- */
        .side-menu { 
            position: fixed; top: 0; left: -100%; width: 85%; max-width: 300px; height: 100%; 
            background: var(--white); z-index: 2000; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 30px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.1); 
        }
        .side-menu.active { left: 0; }
        .menu-item { 
            display: flex; align-items: center; gap: 12px; padding: 12px; 
            color: var(--text-dark); text-decoration: none; font-weight: 600; 
            border-radius: 12px; margin-bottom: 5px; font-size: 14px; 
        }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 1500; }
    </style>
</head>
<body>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <div class="header">
        <div class="menu-toggle" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="brand-text">Watch<span>Video</span></div>
        <div onclick="logout()" style="cursor:pointer;"><i class="fa-solid fa-power-off" style="color: var(--danger); font-size: 18px;"></i></div>
    </div>

    <div class="balance-hero">
        <span class="bal-label">Task Balance</span>
        <span class="bal-value" id="taskBalDisplay">0 RWF</span>
    </div>

    <div class="container">
        <h3 class="section-title">Daily Rewards</h3>
        <div id="videoContainer"></div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div id="menuUser" style="font-weight: 800; font-size: 18px;">User</div>
            <div style="font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase;">Creator Account</div>
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
            <a href="login.html" onclick="logout()" class="menu-item" style="color: var(--danger);"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </nav>
    </div>

    <script>
        const currentUser = localStorage.getItem("current_user");
        let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
        let userData = users.find(u => u.username === currentUser);

        if(!userData) window.location.href = 'login.html';

        const videos = ["vid1.mp4", "vid2.mp4", "vid3.mp4", "vid4.mp4", "vid1.mp4"];

        function updateUI() {
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("taskBalDisplay").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
        }

        function loadVideos() {
            const container = document.getElementById("videoContainer");
            const claimed = userData.claimedVideos || [];

            for (let i = 1; i <= 5; i++) {
                const isClaimed = claimed.includes(i);
                const vidPath = videos[i-1];

                const card = document.createElement("div");
                card.className = "video-card";
                card.innerHTML = `
                    <div class="video-player-box">
                        <div class="timer-overlay" id="timer-${i}">10s</div>
                        <video id="vid-tag-${i}" playsinline>
                            <source src="${vidPath}" type="video/mp4">
                        </video>
                        <i class="fa-solid fa-play fa-2x" id="play-icon-${i}" style="position:absolute; color:white; pointer-events:none;"></i>
                    </div>
                    <div class="video-info">
                        <div style="font-weight: 700; font-size: 15px; margin-bottom:5px;">Video Task #${i}</div>
                        <span class="reward-amt">1,000 RWF</span>
                        <button class="btn-watch" id="btn-${i}" ${isClaimed ? 'disabled' : ''} onclick="startVideo(${i})">
                            ${isClaimed ? 'COMPLETED' : 'START WATCHING'}
                        </button>
                    </div>
                `;
                container.appendChild(card);
            }
        }

        function startVideo(id) {
            const btn = document.getElementById(`btn-${id}`);
            const timerBox = document.getElementById(`timer-${id}`);
            const video = document.getElementById(`vid-tag-${id}`);
            const icon = document.getElementById(`play-icon-${id}`);

            btn.disabled = true;
            btn.innerText = "Watching...";
            timerBox.style.display = "block";
            icon.style.display = "none";
            video.play();

            let timeLeft = 10;
            const countdown = setInterval(() => {
                timeLeft--;
                timerBox.innerText = timeLeft + "s";
                
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    timerBox.style.background = "var(--success)";
                    timerBox.innerText = "READY";
                    btn.innerText = "CLAIM 1,000 RWF";
                    btn.disabled = false;
                    btn.style.background = "var(--success)";
                    btn.onclick = () => claimReward(id);
                }
            }, 1000);
        }

        function claimReward(id) {
            userData.taskBalance = (userData.taskBalance || 0) + 1000;
            if(!userData.claimedVideos) userData.claimedVideos = [];
            userData.claimedVideos.push(id);
            saveData();
            updateUI();
            
            const btn = document.getElementById(`btn-${id}`);
            btn.innerText = "COMPLETED";
            btn.disabled = true;
            btn.style.background = "#e2e8f0";
            alert("Reward Claimed!");
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

        function logout() { localStorage.removeItem("current_user"); window.location.href = 'login.html'; }

        updateUI();
        loadVideos();
    </script>
</body>
</html>
-->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PESA AFRICA | Video Tasks</title>
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
            --primary: #000000; --secondary: #000000; --success: #22c55e;
            --danger: #ef4444; --bg-light: #f1f5f9; --text-dark: #0f172a;
            --text-muted: #64748b; --white: #ffffff;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-light); 
            margin: 0; 
            color: var(--text-dark); 
            line-height: 1.5;
            padding-top: 40px;
        }

        /* --- MOVING NOTIFICATION HEADER BANNER --- */
        .ticker-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background: linear-gradient(90deg, #0f172a, #1e293b);
            border-bottom: 2px solid var(--success);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            overflow: hidden;
            white-space: nowrap;
            z-index: 2001;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
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
            background: rgba(255, 255, 255, 0.08);
            padding: 4px 14px;
            border-radius: 50px;
            border: 1px solid rgba(34, 197, 94, 0.25);
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

        /* --- Mobile Responsive Header --- */
        .header { 
            padding: 12px 15px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: var(--white); 
            border-bottom: 1px solid #e2e8f0; 
            position: sticky; 
            top: 40px; 
            z-index: 1000; 
        }
        .menu-toggle { font-size: 20px; cursor: pointer; background: #f1f5f9; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
        .brand-text { font-weight: 800; font-size: 18px; letter-spacing: -0.5px; }
        .brand-text span { color: var(--primary); }

        /* Trust & Verification Badging */
        .secure-badge-strip {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin: 15px 15px -5px;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
        }
        .secure-badge-strip span { display: inline-flex; align-items: center; gap: 4px; }
        .secure-badge-strip i { color: var(--success); }

        /* --- Mobile Balance Card --- */
        .balance-hero { 
            margin: 15px; 
            padding: 20px; 
            background: linear-gradient(135deg, #1e293b, #0f172a); 
            border-radius: 20px; 
            color: white; 
            text-align: center; 
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .balance-hero::after { content: '🔒 SECURE AUDIT'; position: absolute; top: 12px; right: 15px; font-size: 8px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.4; font-weight: 800; }
        .bal-label { font-size: 10px; text-transform: uppercase; font-weight: 700; opacity: 0.8; letter-spacing: 1.2px; }
        .bal-value { font-size: 28px; font-weight: 800; display: block; margin-top: 4px; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }

        /* --- Video Feed Styling --- */
        .container { padding: 0 15px 100px; }
        .section-title { 
            font-size: 11px; 
            color: var(--text-muted); 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            margin: 15px 5px 15px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .video-card { 
            background: var(--white); 
            border-radius: 20px; 
            overflow: hidden; 
            border: 1px solid #ffffff; 
            box-shadow: var(--card-shadow); 
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        
        .video-player-box { 
            width: 100%; 
            aspect-ratio: 16 / 9;
            background: #000; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            position: relative; 
        }
        .video-player-box video { width: 100%; height: 100%; object-fit: cover; }
        
        .timer-overlay { 
            position: absolute; 
            top: 12px; 
            right: 12px; 
            background: rgba(0, 0, 0, 0.7); 
            backdrop-filter: blur(5px);
            color: white; 
            padding: 6px 14px; 
            border-radius: 30px; 
            font-size: 12px; 
            font-weight: 800; 
            display: none; 
            border: 1px solid rgba(255,255,255,0.2);
            z-index: 10;
        }
        .video-badge-sticker { position: absolute; top: 12px; left: 12px; background: rgba(34, 197, 94, 0.85); backdrop-filter: blur(4px); color: white; font-size: 9px; font-weight: 800; padding: 4px 10px; border-radius: 50px; text-transform: uppercase; z-index: 10; letter-spacing: 0.5px; }

        .video-info { padding: 15px; text-align: center; }
        .reward-amt { 
            color: var(--success); 
            font-weight: 800; 
            font-size: 18px; 
            display: block; 
            margin-bottom: 12px; 
        }
        
        .btn-watch { 
            width: 100%; 
            padding: 14px; 
            border-radius: 14px; 
            border: none; 
            background: linear-gradient(135deg, #1e293b, #0f172a); 
            color: white; 
            font-weight: 800; 
            font-size: 14px;
            text-transform: uppercase; 
            cursor: pointer; 
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
            letter-spacing: 0.5px;
            transition: 0.2s;
        }
        .btn-watch:active { transform: scale(0.98); }
        .btn-watch:disabled { background: #e2e8f0 !important; color: #94a3b8 !important; box-shadow: none !important; cursor: not-allowed; }

        /* --- Side Menu Mobile --- */
        .side-menu { 
            position: fixed; top: 0; left: -100%; width: 85%; max-width: 300px; height: 100%; 
            background: var(--white); z-index: 2100; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 30px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.15); 
        }
        .side-menu.active { left: 0; }
        .menu-item { 
            display: flex; align-items: center; gap: 12px; padding: 12px; 
            color: var(--text-dark); text-decoration: none; font-weight: 600; 
            border-radius: 12px; margin-bottom: 5px; font-size: 14px; 
        }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 2050; backdrop-filter: blur(2px); }
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
        <div class="brand-text">Watch<span>Video</span> 🎬</div>
        <div onclick="logout()" style="cursor:pointer;"><i class="fa-solid fa-power-off" style="color: var(--danger); font-size: 18px;"></i></div>
    </div>

    <!-- TRUST BADGE STRIP -->
    <div class="secure-badge-strip">
        <span><i class="fa-solid fa-circle-check"></i> Verified Publisher</span>
        <span><i class="fa-solid fa-shield-halved"></i> Escrow Secured</span>
        <span><i class="fa-solid fa-bolt"></i> Instant Transfer</span>
    </div>

    <div class="balance-hero">
        <span class="bal-label">Task Balance 💸</span>
        <span class="bal-value" id="taskBalDisplay">0 RWF</span>
    </div>

    <div class="container">
        <h3 class="section-title">✨ Premium Daily Rewards</h3>
        <div id="videoContainer"></div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div id="menuUser" style="font-weight: 800; font-size: 18px;">User</div>
            <div style="font-size: 11px; color: var(--success); font-weight: 700; text-transform: uppercase;">Creator Account ✅</div>
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
            <a href="login.html" onclick="logout()" class="menu-item" style="color: var(--danger);"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </nav>
    </div>

    <script>
        const currentUser = localStorage.getItem("current_user");
        let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
        let userData = users.find(u => u.username === currentUser);

        if(!userData) window.location.href = 'login.html';

        const videos = ["vid1.mp4", "vid2.mp4", "vid3.mp4", "vid4.mp4", "vid1.mp4"];

        function updateUI() {
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("taskBalDisplay").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
        }

        function loadVideos() {
            const container = document.getElementById("videoContainer");
            const claimed = userData.claimedVideos || [];

            for (let i = 1; i <= 5; i++) {
                const isClaimed = claimed.includes(i);
                const vidPath = videos[i-1];

                const card = document.createElement("div");
                card.className = "video-card";
                card.innerHTML = `
                    <div class="video-player-box">
                        <span class="video-badge-sticker">Premium Live 🔥</span>
                        <div class="timer-overlay" id="timer-${i}">10s</div>
                        <video id="vid-tag-${i}" playsinline>
                            <source src="https://task-survey-paypesa-job.edgeone.dev/${vidPath}" type="video/mp4">
                        </video>
                        <i class="fa-solid fa-play fa-2x" id="play-icon-${i}" style="position:absolute; color:white; pointer-events:none;"></i>
                    </div>
                    <div class="video-info">
                        <div style="font-weight: 700; font-size: 15px; margin-bottom:5px;">Video Task #${i}</div>
                        <span class="reward-amt">💰 1,000 RWF</span>
                        <button class="btn-watch" id="btn-${i}" ${isClaimed ? 'disabled' : ''} onclick="startVideo(${i})">
                            ${isClaimed ? '✅ COMPLETED' : '⚡ START WATCHING'}
                        </button>
                    </div>
                `;
                container.appendChild(card);
            }
        }

        function startVideo(id) {
            const btn = document.getElementById(`btn-${id}`);
            const timerBox = document.getElementById(`timer-${id}`);
            const video = document.getElementById(`vid-tag-${id}`);
            const icon = document.getElementById(`play-icon-${id}`);

            btn.disabled = true;
            btn.innerText = "Watching video clip...";
            timerBox.style.display = "block";
            icon.style.display = "none";
            video.play();

            let timeLeft = 10;
            const countdown = setInterval(() => {
                timeLeft--;
                timerBox.innerText = timeLeft + "s";
                
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    timerBox.style.background = "var(--success)";
                    timerBox.innerText = "READY";
                    btn.innerText = "🎁 CLAIM 1,000 RWF";
                    btn.disabled = false;
                    btn.style.background = "var(--success)";
                    btn.onclick = () => claimReward(id);
                }
            }, 1000);
        }

        function claimReward(id) {
            userData.taskBalance = (userData.taskBalance || 0) + 1000;
            if(!userData.claimedVideos) userData.claimedVideos = [];
            userData.claimedVideos.push(id);
            saveData();
            updateUI();
            
            const btn = document.getElementById(`btn-${id}`);
            btn.innerText = "✅ COMPLETED";
            btn.disabled = true;
            btn.style.background = "#e2e8f0";
            alert("Reward Claimed!");
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

        function logout() { localStorage.removeItem("current_user"); window.location.href = 'login.html'; }

        updateUI();
        loadVideos();
    </script>
</body>
</html>











































































































































































































































