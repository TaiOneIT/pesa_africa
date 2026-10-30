<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PESA AFRICA | Image Tasks</title>
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
            --primary: #050504; --secondary: #000000; --success: #22c55e;
            --danger: #445eef; --bg-light: #f8fafc; --text-dark: #1e293b;
            --text-muted: #64748b; --white: #ffffff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-light); margin: 0; color: var(--text-dark); overflow-x: hidden; }

        /* Header */
        .header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: var(--white); border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 1000; }
        .menu-toggle { font-size: 22px; cursor: pointer; background: #f1f5f9; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
        .brand-text { font-weight: 800; font-size: 20px; }
        .brand-text span { color: var(--primary); }

        /* Balance Display */
        .top-balance-card { margin: 20px; padding: 25px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border-radius: 24px; color: white; text-align: center; box-shadow: 0 10px 20px rgba(78, 68, 231, 0.2); }
        .bal-label { font-size: 11px; text-transform: uppercase; font-weight: 700; opacity: 0.9; letter-spacing: 1px; }
        .bal-value { font-size: 32px; font-weight: 800; display: block; margin-top: 5px; }

        /* Task Grid */
        .container { padding: 0 20px 100px; }
        .section-title { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding-left: 5px; }
        
        .task-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .task-card { background: var(--white); border-radius: 20px; overflow: hidden; border: 1px solid #edf2f7; box-shadow: var(--card-shadow); transition: 0.3s; }
        .img-area { height: 120px; background: #f1f5f9; position: relative; overflow: hidden; }
        .img-area img { width: 100%; height: 100%; object-fit: cover; }
        .img-area .placeholder-icon { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #cbd5e1; }

        .task-info { padding: 12px; text-align: center; }
        .task-name { font-weight: 700; font-size: 13px; color: var(--text-dark); display: block; margin-bottom: 4px; }
        .reward-tag { color: var(--success); font-weight: 800; font-size: 12px; display: block; margin-bottom: 10px; }
        
        .btn-claim { 
            width: 100%; padding: 10px; border-radius: 12px; border: none; 
            background: var(--danger); color: white; font-weight: 800; 
            font-size: 11px; text-transform: uppercase; cursor: pointer;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2); transition: 0.2s;
        }
        .btn-claim:disabled { background: #cbd5e1; box-shadow: none; cursor: not-allowed; }
        .btn-claim:active { transform: scale(0.95); }

        /* Sidebar Styles (Updated to match buy_followers_subscribers.html) */
        .side-menu { 
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%; 
            background: var(--white); z-index: 2000; color: #1e293b;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 30px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.1); 
        }
        .side-menu.active { left: 0; }
        .menu-item { 
            display: flex; align-items: center; gap: 12px; padding: 14px; 
            color: #1e293b; text-decoration: none; font-weight: 600; 
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
        <div class="brand-text">Claim <n><span>Image</span></div>
        <div onclick="logout()" style="cursor:pointer;"><i class="fa-solid fa-power-off" style="color: var(--danger); font-size: 20px;"></i></div>
    </div>

    <div class="top-balance-card">
        <span class="bal-label">My Task Balance</span>
        <span class="bal-value" id="taskBalDisplay">0 RWF</span>
    </div>

    <div class="container">
        <h3 class="section-title">Image Earning Portal (15 Tasks)</h3>
        <div class="task-grid" id="imageTaskContainer"></div>
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
            <a href="image_task.html" class="menu-item active"><i class="fa-solid fa-image"></i> Image Tasks</a>
            <a href="video_task.html" class="menu-item"><i class="fa-solid fa-circle-play"></i> Video Tasks</a>
            <a href="Forex_Trading_Task.html" class="menu-item"><i class="fa-solid fa-chart-simple"></i> Forex Task</a>
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

        if(!userData) window.location.href = 'login.html';

        const images = [
            "im1.jpg", "im2.jpg", "im3.jpg", 
            "im4.jpg", "im5.jpg", "im6.webp",
            "im7.webp", "im8.webp", "im9.webp",
            "im13.webp", "im12.webp", "im15.webp",
            "im16.webp", "im17.webp", "im18.webp"
        ];

        function updateUI() {
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("taskBalDisplay").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
        }

        function generateTasks() {
            const container = document.getElementById("imageTaskContainer");
            const claimed = userData.claimedImages || [];

            for (let i = 1; i <= 15; i++) {
                const isClaimed = claimed.includes(i);
                const imgPath = images[i-1] || ""; 
                
                const card = document.createElement("div");
                card.className = "task-card";
                card.innerHTML = `
                    <div class="img-area">
                        ${imgPath ? `<img src="${imgPath}" alt="Task ${i}">` : `<i class="fa-solid fa-image fa-2x placeholder-icon"></i>`}
                    </div>
                    <div class="task-info">
                        <span class="task-name">Photo Task #${i}</span>
                        <span class="reward-tag">+450 RWF</span>
                        <button class="btn-claim" id="btn-${i}" ${isClaimed ? 'disabled' : ''} onclick="claimReward(${i})">
                            ${isClaimed ? 'COMPLETED' : 'LIKE & EARN'}
                        </button>
                    </div>
                `;
                container.appendChild(card);
            }
        }

        function claimReward(taskId) {
            const reward = 450;
            userData.taskBalance = (userData.taskBalance || 0) + reward;
            if(!userData.claimedImages) userData.claimedImages = [];
            userData.claimedImages.push(taskId);
            saveData();
            updateUI();
            const btn = document.getElementById(`btn-${taskId}`);
            btn.innerText = "COMPLETED";
            btn.disabled = true;
            alert("Success! 450 RWF added to your task balance.");
        }

        /* Updated toggleMenu to match buy_followers_subscribers.html logic */
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
        generateTasks();
    </script>
</body>
</html>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PESA AFRICA | Image Tasks</title>
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
            --primary: #050504; --secondary: #000000; --success: #22c55e;
            --danger: #445eef; --bg-light: #f8fafc; --text-dark: #1e293b;
            --text-muted: #64748b; --white: #ffffff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --gold-accent: #ffb700;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-light); margin: 0; color: var(--text-dark); overflow-x: hidden; padding-top: 40px; }

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

        /* Header */
        .header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: var(--white); border-bottom: 1px solid #e2e8f0; position: sticky; top: 40px; z-index: 1000; }
        .menu-toggle { font-size: 22px; cursor: pointer; background: #f1f5f9; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
        .brand-text { font-weight: 800; font-size: 20px; }
        .brand-text span { color: var(--primary); }

        /* Trust & Verification Badging */
        .secure-badge-strip {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin: 15px 20px -5px;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
        }
        .secure-badge-strip span { display: inline-flex; align-items: center; gap: 4px; }
        .secure-badge-strip i { color: var(--success); }

        /* Balance Display */
        .top-balance-card { margin: 15px 20px 20px; padding: 25px; background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 24px; color: white; text-align: center; box-shadow: 0 12px 24px rgba(15, 23, 42, 0.15); border: 1px solid rgba(255, 255, 255, 0.05); position: relative; overflow: hidden; }
        .top-balance-card::after { content: '🔒 Secure Vault'; position: absolute; top: 12px; right: 15px; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.5; font-weight: 800; }
        .bal-label { font-size: 11px; text-transform: uppercase; font-weight: 700; opacity: 0.8; letter-spacing: 1px; display: block; }
        .bal-value { font-size: 34px; font-weight: 800; display: block; margin-top: 5px; color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }

        /* Task Grid */
        .container { padding: 0 20px 100px; }
        .section-title { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding-left: 5px; font-weight: 800; display: flex; align-items: center; gap: 6px; }
        
        .task-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .task-card { background: var(--white); border-radius: 20px; overflow: hidden; border: 1px solid #edf2f7; box-shadow: var(--card-shadow); transition: transform 0.2s, box-shadow 0.2s; }
        .task-card:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(0,0,0,0.08); }
        .img-area { height: 120px; background: #f1f5f9; position: relative; overflow: hidden; }
        .img-area img { width: 100%; height: 100%; object-fit: cover; }
        .img-area .placeholder-icon { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #cbd5e1; }
        .task-badge-sticker { position: absolute; top: 8px; left: 8px; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); color: white; font-size: 9px; font-weight: 800; padding: 3px 8px; border-radius: 50px; text-transform: uppercase; }

        .task-info { padding: 12px; text-align: center; }
        .task-name { font-weight: 700; font-size: 13px; color: var(--text-dark); display: block; margin-bottom: 4px; }
        .reward-tag { color: var(--success); font-weight: 800; font-size: 13px; display: block; margin-bottom: 10px; }
        
        .btn-claim { 
            width: 100%; padding: 11px; border-radius: 12px; border: none; 
            background: linear-gradient(135deg, var(--danger), #2b43cb); color: white; font-weight: 800; 
            font-size: 11px; text-transform: uppercase; cursor: pointer;
            box-shadow: 0 4px 12px rgba(68, 94, 239, 0.25); transition: 0.2s;
            letter-spacing: 0.5px;
        }
        .btn-claim:disabled { background: #e2e8f0 !important; color: #94a3b8 !important; box-shadow: none !important; cursor: not-allowed; }
        .btn-claim:active { transform: scale(0.96); }

        /* Sidebar Styles (Updated to match buy_followers_subscribers.html) */
        .side-menu { 
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%; 
            background: var(--white); z-index: 2100; color: #1e293b;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 30px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.15); 
        }
        .side-menu.active { left: 0; }
        .menu-item { 
            display: flex; align-items: center; gap: 12px; padding: 14px; 
            color: #1e293b; text-decoration: none; font-weight: 600; 
            border-radius: 12px; margin-bottom: 5px; font-size: 14px; 
        }
        .menu-item i { width: 20px; color: var(--text-muted); }
        .menu-item.active { background: #f1f5f9; color: var(--primary); }
        
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 2050; backdrop-filter: blur(2px); }
    </style>
</head>
<body>

  
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
        <div class="brand-text">Claim <span>Image</span> ✨</div>
        <div onclick="logout()" style="cursor:pointer;"><i class="fa-solid fa-power-off" style="color: rgba(239, 68, 68, 0.8); font-size: 20px;"></i></div>
    </div>


    <div class="secure-badge-strip">
        <span><i class="fa-solid fa-circle-check"></i> Verified System</span>
        <span><i class="fa-solid fa-shield"></i> Secured Gateway</span>
        <span><i class="fa-solid fa-bolt"></i> Instant Payouts</span>
    </div>

    <div class="top-balance-card">
        <span class="bal-label">My Task Balance 💸</span>
        <span class="bal-value" id="taskBalDisplay">0 RWF</span>
    </div>

    <div class="container">
        <h3 class="section-title">🚀 Image Earning Portal (15 Tasks Verified)</h3>
        <div class="task-grid" id="imageTaskContainer"></div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div id="menuUser" style="font-weight: 800; font-size: 18px;">User</div>
            <div style="font-size: 11px; color: var(--success); font-weight: 700; text-transform: uppercase;">Standard Account ✅</div>
        </div>
        <nav>
            <a href="dashboard.html" class="menu-item"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="Withdraw_bonus.html" class="menu-item"><i class="fa-solid fa-wallet"></i> Withdraw Bonus</a>
            <a href="Withdraw_Task_Balance.html" class="menu-item"><i class="fa-solid fa-money-bill-transfer"></i> Withdraw Task Balance</a>
            <a href="spin.html" class="menu-item"><i class="fa-solid fa-dharmachakra"></i> Lucky Spin</a>
            <a href="aviator.html" class="menu-item"><i class="fa-solid fa-plane-up"></i> Aviator Betting</a>
            <a href="image_task.html" class="menu-item active"><i class="fa-solid fa-image"></i> Image Tasks</a>
            <a href="video_task.html" class="menu-item"><i class="fa-solid fa-circle-play"></i> Video Tasks</a>
            <a href="Forex_Trading_Task.html" class="menu-item"><i class="fa-solid fa-chart-simple"></i> Forex Task</a>
            <a href="buy_followers_subscribers.html" class="menu-item"><i class="fa-solid fa-users-viewfinder"></i> Buy Follower&Subscribers</a>
            <a href="login.html" onclick="logout()" class="menu-item" style="color: #ef4444; margin-top: 10px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <i class="fa-solid fa-right-from-bracket"></i> Logout Account
            </a>
        </nav>
    </div>

    <script>
        const currentUser = localStorage.getItem("current_user");
        let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
        let userData = users.find(u => u.username === currentUser);

        if(!userData) window.location.href = 'login.html';

        const images = [
            "im1.jpg", "im2.jpg", "im3.jpg", 
            "im4.jpg", "im5.jpg", "im6.webp",
            "im7.webp", "im8.webp", "im9.webp",
            "im13.webp", "im12.webp", "im15.webp",
            "im16.webp", "im17.webp", "im18.webp"
        ];

        function updateUI() {
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("taskBalDisplay").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
        }

        function generateTasks() {
            const container = document.getElementById("imageTaskContainer");
            const claimed = userData.claimedImages || [];

            for (let i = 1; i <= 15; i++) {
                const isClaimed = claimed.includes(i);
                const imgPath = images[i-1] || ""; 
                
                const card = document.createElement("div");
                card.className = "task-card";
                card.innerHTML = `
                    <div class="img-area">
                        <span class="task-badge-sticker">Active 🔥</span>
                        ${imgPath ? `<img src="${imgPath}" alt="Task ${i}">` : `<i class="fa-solid fa-image fa-2x placeholder-icon"></i>`}
                    </div>
                    <div class="task-info">
                        <span class="task-name">Photo Task #${i}</span>
                        <span class="reward-tag">💰 +450 RWF</span>
                        <button class="btn-claim" id="btn-${i}" ${isClaimed ? 'disabled' : ''} onclick="claimReward(${i})">
                            ${isClaimed ? '✅ COMPLETED' : '⚡ LIKE & EARN'}
                        </button>
                    </div>
                `;
                container.appendChild(card);
            }
        }

        function claimReward(taskId) {
            const reward = 450;
            userData.taskBalance = (userData.taskBalance || 0) + reward;
            if(!userData.claimedImages) userData.claimedImages = [];
            userData.claimedImages.push(taskId);
            saveData();
            updateUI();
            const btn = document.getElementById(`btn-${taskId}`);
            btn.innerText = "✅ COMPLETED";
            btn.disabled = true;
            alert("Success! 450 RWF added to your task balance.");
        }

        /* Updated toggleMenu to match buy_followers_subscribers.html logic */
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
        generateTasks();
    </script>
</body>
</html>
-->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PESA AFRICA | Image Tasks</title>
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
            --primary: #050504; --secondary: #000000; --success: #22c55e;
            --danger: #445eef; --bg-light: #f8fafc; --text-dark: #1e293b;
            --text-muted: #64748b; --white: #ffffff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --gold-accent: #ffb700;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-light); margin: 0; color: var(--text-dark); overflow-x: hidden; padding-top: 40px; }

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

        /* Header */
        .header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: var(--white); border-bottom: 1px solid #e2e8f0; position: sticky; top: 40px; z-index: 1000; }
        .menu-toggle { font-size: 22px; cursor: pointer; background: #f1f5f9; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
        .brand-text { font-weight: 800; font-size: 20px; }
        .brand-text span { color: var(--primary); }

        /* Trust & Verification Badging */
        .secure-badge-strip {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin: 15px 20px -5px;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
        }
        .secure-badge-strip span { display: inline-flex; align-items: center; gap: 4px; }
        .secure-badge-strip i { color: var(--success); }

        /* Balance Display */
        .top-balance-card { margin: 15px 20px 20px; padding: 25px; background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 24px; color: white; text-align: center; box-shadow: 0 12px 24px rgba(15, 23, 42, 0.15); border: 1px solid rgba(255, 255, 255, 0.05); position: relative; overflow: hidden; }
        .top-balance-card::after { content: '🔒 Secure Vault'; position: absolute; top: 12px; right: 15px; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.5; font-weight: 800; }
        .bal-label { font-size: 11px; text-transform: uppercase; font-weight: 700; opacity: 0.8; letter-spacing: 1px; display: block; }
        .bal-value { font-size: 34px; font-weight: 800; display: block; margin-top: 5px; color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }

        /* Task Grid */
        .container { padding: 0 20px 100px; }
        .section-title { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; padding-left: 5px; font-weight: 800; display: flex; align-items: center; gap: 6px; }
        
        .task-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .task-card { background: var(--white); border-radius: 20px; overflow: hidden; border: 1px solid #edf2f7; box-shadow: var(--card-shadow); transition: transform 0.2s, box-shadow 0.2s; }
        .task-card:hover { transform: translateY(-2px); box-shadow: 0 12px 25px rgba(0,0,0,0.08); }
        .img-area { height: 120px; background: #f1f5f9; position: relative; overflow: hidden; }
        .img-area img { width: 100%; height: 100%; object-fit: cover; }
        .img-area .placeholder-icon { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #cbd5e1; }
        .task-badge-sticker { position: absolute; top: 8px; left: 8px; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); color: white; font-size: 9px; font-weight: 800; padding: 3px 8px; border-radius: 50px; text-transform: uppercase; }

        /* Actions Overlay Bar inside Image Frame */
        .img-actions-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 8px 10px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .action-icon-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
            border: none;
            color: white;
            padding: 5px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: 0.2s;
            text-decoration: none;
        }
        .action-icon-btn:hover { background: rgba(255, 255, 255, 0.4); }
        .action-icon-btn.liked { color: #f43f5e; background: rgba(255, 255, 255, 0.9); }

        .task-info { padding: 12px; text-align: center; }
        .task-name { font-weight: 700; font-size: 13px; color: var(--text-dark); display: block; margin-bottom: 4px; }
        .reward-tag { color: var(--success); font-weight: 800; font-size: 13px; display: block; margin-bottom: 10px; }
        
        .btn-claim { 
            width: 100%; padding: 11px; border-radius: 12px; border: none; 
            background: linear-gradient(135deg, var(--danger), #2b43cb); color: white; font-weight: 800; 
            font-size: 11px; text-transform: uppercase; cursor: pointer;
            box-shadow: 0 4px 12px rgba(68, 94, 239, 0.25); transition: 0.2s;
            letter-spacing: 0.5px;
        }
        .btn-claim:disabled { background: #e2e8f0 !important; color: #94a3b8 !important; box-shadow: none !important; cursor: not-allowed; }
        .btn-claim:active { transform: scale(0.96); }

        /* Sidebar Styles (Updated to match buy_followers_subscribers.html) */
        .side-menu { 
            position: fixed; top: 0; left: -100%; width: 280px; height: 100%; 
            background: var(--white); z-index: 2100; color: #1e293b;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 30px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.15); 
        }
        .side-menu.active { left: 0; }
        .menu-item { 
            display: flex; align-items: center; gap: 12px; padding: 14px; 
            color: #1e293b; text-decoration: none; font-weight: 600; 
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
        <div class="brand-text">Claim <span>Image</span> ✨</div>
        <div onclick="logout()" style="cursor:pointer;"><i class="fa-solid fa-power-off" style="color: rgba(239, 68, 68, 0.8); font-size: 20px;"></i></div>
    </div>

    <!-- TRUST BADGE STRIP -->
    <div class="secure-badge-strip">
        <span><i class="fa-solid fa-circle-check"></i> Verified System</span>
        <span><i class="fa-solid fa-shield"></i> Secured Gateway</span>
        <span><i class="fa-solid fa-bolt"></i> Instant Payouts</span>
    </div>

    <div class="top-balance-card">
        <span class="bal-label">My Task Balance 💸</span>
        <span class="bal-value" id="taskBalDisplay">0 RWF</span>
    </div>

    <div class="container">
        <h3 class="section-title">🚀 Image Earning Portal (15 Tasks Verified)</h3>
        <div class="task-grid" id="imageTaskContainer"></div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div id="menuUser" style="font-weight: 800; font-size: 18px;">User</div>
            <div style="font-size: 11px; color: var(--success); font-weight: 700; text-transform: uppercase;">Standard Account ✅</div>
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
            <a href="login.html" onclick="logout()" class="menu-item" style="color: #ef4444; margin-top: 10px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <i class="fa-solid fa-right-from-bracket"></i> Logout Account
            </a>
        </nav>
    </div>

    <script>
        const currentUser = localStorage.getItem("current_user");
        let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
        let userData = users.find(u => u.username === currentUser);

        if(!userData) window.location.href = 'login.html';

        const images = [
            "im1.jpg", "im2.jpg", "im3.jpg", 
            "im4.jpg", "im5.jpg", "im6.webp",
            "im7.webp", "im8.webp", "im9.webp",
            "im13.webp", "im12.webp", "im15.webp",
            "im16.webp", "im17.webp", "im18.webp"
        ];

        function updateUI() {
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("taskBalDisplay").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
        }

      function generateTasks() {

    const container =
        document.getElementById("imageTaskContainer");

    if (!container) {
        return;
    }

    container.innerHTML = "";

    const claimed =
        Array.isArray(userData.claimedImages)
            ? userData.claimedImages
            : [];


    for (let i = 1; i <= 15; i++) {

        const isClaimed =
            claimed.includes(i);


        /*
         * Reuse the 7 supplied professional images
         * across the 15 available tasks.
         */

        const imgPath =
            images[(i - 1) % images.length];


        const startingLikes =
            450 + (i * 17);


        const card =
            document.createElement("div");


        card.className =
            "task-card";


        card.innerHTML = `

            <div class="img-area">

                <span class="task-badge-sticker">
                    Active 🔥
                </span>


                <img
                    src="${imgPath}"
                    alt="PESA AFRICA Image Task ${i}"
                    loading="lazy"
                    onerror="
                        this.style.display='none';
                        this.nextElementSibling.style.display='flex';
                    "
                >


                <div
                    class="image-fallback"
                    style="
                        display:none;
                        width:100%;
                        height:100%;
                        align-items:center;
                        justify-content:center;
                        background:#f4f4f4;
                        color:#777;
                    "
                >

                    <i class="fa-solid fa-image fa-2x"></i>

                </div>


                <div class="img-actions-bar">

                    <button
                        type="button"
                        class="action-icon-btn"
                        onclick="toggleLike(this)"
                    >

                        <i class="fa-solid fa-heart"></i>

                        <span class="like-count">
                            ${startingLikes}
                        </span>

                    </button>


                    <a
                        href="${imgPath}"
                        download="PesaAfrica_Task_${i}.jpg"
                        class="action-icon-btn"
                    >

                        <i class="fa-solid fa-arrow-down"></i>

                        View Image

                    </a>

                </div>

            </div>


            <div class="task-info">

                <span class="task-name">
                    Photo Task #${i} 🖼️
                </span>


                <span class="reward-tag">
                    💰 +450 RWF
                </span>


                <button
                    class="btn-claim"
                    id="btn-${i}"
                    ${isClaimed ? "disabled" : ""}
                    onclick="claimReward(${i})"
                >

                    ${
                        isClaimed
                            ? "✅ COMPLETED"
                            : "⚡ LIKE & EARN"
                    }

                </button>

            </div>

        `;


        container.appendChild(card);
    }
}
         
        function toggleLike(btnElement) {
            const counter = btnElement.querySelector('.like-count');
            let currentLikes = parseInt(counter.innerText);
            if(btnElement.classList.contains('liked')) {
                btnElement.classList.remove('liked');
                counter.innerText = currentLikes - 1;
            } else {
                btnElement.classList.add('liked');
                counter.innerText = currentLikes + 1;
            }
        }

        function trackDownload(e, taskId) {
            // Safe helper script anchor hook if platform placeholder asset is loaded instead of absolute image link path
            const src = e.currentTarget.getAttribute('href');
            if (src === '#') {
                e.preventDefault();
                alert("Task sample loaded in secure viewing frame mode.");
            }
        }

        function claimReward(taskId) {
            const reward = 450;
            userData.taskBalance = (userData.taskBalance || 0) + reward;
            if(!userData.claimedImages) userData.claimedImages = [];
            userData.claimedImages.push(taskId);
            saveData();
            updateUI();
            const btn = document.getElementById(`btn-${taskId}`);
            btn.innerText = "✅ COMPLETED";
            btn.disabled = true;
            alert("Success! 450 RWF added to your task balance.");
        }

        /* Updated toggleMenu to match buy_followers_subscribers.html logic */
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
        generateTasks();
    </script>
</body>
</html>