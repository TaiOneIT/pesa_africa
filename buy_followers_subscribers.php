<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PESA AFRICA | Growth Portal</title>
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
            --primary: #d80707;
            --insta-gradient: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            --yt-red: #FF0000;
            --secondary: #160368;
            --success: #22c55e;
            --danger: #ef4444;
            --bg-light: #fafafa;
            --text-dark: #262626;
            --text-muted: #8e8e8e;
            --white: #ffffff;
            --card-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-light); margin: 0; color: var(--text-dark); overflow-x: hidden; }

        /* --- Header --- */
        .header {
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            border-bottom: 1px solid #dbdbdb;
            position: sticky; top: 0; z-index: 1000;
        }

        .menu-toggle { 
            font-size: 22px; cursor: pointer; color: var(--text-dark);
            background: #f1f5f9; width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center; border-radius: 10px;
        }

        .brand-text { font-weight: 800; font-size: 20px; }
        .brand-text span { color: var(--primary); }

        /* --- Tabs Navigation --- */
        .tabs-nav {
            display: flex;
            background: white;
            border-bottom: 1px solid #dbdbdb;
        }
        .tab-btn {
            flex: 1;
            padding: 15px;
            text-align: center;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            color: var(--text-muted);
            transition: 0.3s;
            border-bottom: 3px solid transparent;
        }
        .tab-btn.active.insta { color: #bc1888; border-color: #bc1888; }
        .tab-btn.active.yt { color: var(--yt-red); border-color: var(--yt-red); }

        /* --- Content Sections --- */
        .tab-content { display: none; animation: fadeIn 0.4s ease; }
        .tab-content.active { display: block; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .hero-section { padding: 30px 20px; text-align: center; background: white; }
        
        .logo-ring {
            width: 70px; height: 70px; padding: 3px; border-radius: 50%; margin: 0 auto 15px;
            display: flex; align-items: center; justify-content: center; font-size: 35px;
        }
        .insta-ring { background: var(--insta-gradient); color: white; }
        .yt-ring { background: var(--yt-red); color: white; }

        .input-box { max-width: 400px; margin: 20px auto; position: relative; }
        .input-box input {
            width: 100%; padding: 15px 45px; border-radius: 12px;
            border: 1px solid #dbdbdb; background: #fafafa; font-size: 14px; outline: none;
        }
        .input-box i { position: absolute; left: 15px; top: 17px; color: var(--text-muted); }

        /* --- Packages --- */
        .container { padding: 20px; }
        .package-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .package-card {
            background: white; border-radius: 20px; padding: 20px;
            text-align: center; border: 1px solid #dbdbdb;
            box-shadow: var(--card-shadow); transition: 0.3s; cursor: pointer;
        }
        .package-card:active { transform: scale(0.95); }
        .qty { font-size: 18px; font-weight: 800; display: block; }
        .label { font-size: 10px; color: var(--text-muted); font-weight: 700; margin-bottom: 5px; display: block; }
        .price-tag { color: var(--primary); font-weight: 800; font-size: 14px; margin: 8px 0; }
        .btn-buy {
            width: 100%; padding: 8px; border-radius: 8px;
            border: none; color: white; font-weight: 700;
        }
        .insta-btn { background: #0095f6; }
        .yt-btn { background: var(--yt-red); }

        /* --- Side Menu --- */
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

        /* --- Modal --- */
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7); backdrop-filter: blur(5px);
            display: none; align-items: center; justify-content: center; z-index: 3000; padding: 20px;
        }
        .modal-content {
            background: white; padding: 30px; border-radius: 25px; text-align: center; max-width: 350px; width: 100%;
        }
        .btn-token {
            display: block; width: 100%; padding: 15px; background: var(--primary);
            color: white; text-decoration: none; border-radius: 12px;
            font-weight: 800; margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <div class="modal" id="tokenModal">
        <div class="modal-content">
            <i class="fa-solid fa-lock" style="font-size: 40px; color: var(--primary); margin-bottom: 15px;"></i>
            <h3 style="margin: 0;">Unlock Required</h3>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 10px;">
                Purchase a <b>Withdrawal Token Card</b> (4,000 RWF) to unlock your task balance for social growth services.
            </p>
            <a href="pay_token.html" class="btn-token">PAY WITHDRAWAL TOKEN</a>
            <p onclick="closeModal()" style="margin-top: 15px; font-size: 12px; cursor: pointer; font-weight: 700;">Cancel</p>
        </div>
    </div>

    <div class="header">
        <div class="menu-toggle" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="brand-text">PESA <N> <span>AFRICA</span></div>
        <div style="font-weight: 800; color: var(--success); font-size: 13px;" id="taskBalDisplay">0 RWF</div>
    </div>

    <div class="tabs-nav">
        <div class="tab-btn active insta" onclick="switchTab('insta')">INSTAGRAM</div>
        <div class="tab-btn yt" onclick="switchTab('yt')">YOUTUBE</div>
    </div>

    <div id="insta" class="tab-content active">
        <div class="hero-section">
            <div class="logo-ring insta-ring"><i class="fa-brands fa-instagram"></i></div>
            <h2 style="margin: 0; font-size: 18px;">Instagram Followers</h2>
            <div class="input-box">
                <i class="fa-solid fa-at"></i>
                <input type="text" id="instaUser" placeholder="Enter Instagram Username">
            </div>
        </div>
        <div class="container">
            <div class="package-grid">
                <div class="package-card" onclick="initPurchase(3000, '1,000', 'Followers', 'instaUser')">
                    <span class="label">POPULAR</span><span class="qty">1,000</span><span class="price-tag">3,000 RWF</span>
                    <button class="btn-buy insta-btn">Buy Now</button>
                </div>
                <div class="package-card" onclick="initPurchase(5000, '2,000', 'Followers', 'instaUser')">
                    <span class="label">BEST VALUE</span><span class="qty">2,000</span><span class="price-tag">5,000 RWF</span>
                    <button class="btn-buy insta-btn">Buy Now</button>
                </div>
                <div class="package-card" onclick="initPurchase(10000, '5,000', 'Followers', 'instaUser')">
                    <span class="label">PREMIUM</span><span class="qty">5,000</span><span class="price-tag">10,000 RWF</span>
                    <button class="btn-buy insta-btn">Buy Now</button>
                </div>
                <div class="package-card" onclick="initPurchase(20000, '10,000', 'Followers', 'instaUser')">
                    <span class="label">ELITE</span><span class="qty">10,000</span><span class="price-tag">20,000 RWF</span>
                    <button class="btn-buy insta-btn">Buy Now</button>
                </div>
            </div>
        </div>
    </div>

    <div id="yt" class="tab-content">
        <div class="hero-section">
            <div class="logo-ring yt-ring"><i class="fa-brands fa-youtube"></i></div>
            <h2 style="margin: 0; font-size: 18px;">YouTube Subscribers</h2>
            <div class="input-box">
                <i class="fa-solid fa-link"></i>
                <input type="text" id="ytUser" placeholder="Channel Link or Name">
            </div>
        </div>
        <div class="container">
            <div class="package-grid">
                <div class="package-card" onclick="initPurchase(3000, '1,000', 'Subscribers', 'ytUser')">
                    <span class="label">STARTER</span><span class="qty">1,000</span><span class="price-tag">3,000 RWF</span>
                    <button class="btn-buy yt-btn">Buy Now</button>
                </div>
                <div class="package-card" onclick="initPurchase(5000, '2,000', 'Subscribers', 'ytUser')">
                    <span class="label">CREATOR</span><span class="qty">2,000</span><span class="price-tag">5,000 RWF</span>
                    <button class="btn-buy yt-btn">Buy Now</button>
                </div>
                <div class="package-card" onclick="initPurchase(10000, '5,000', 'Subscribers', 'ytUser')">
                    <span class="label">INFLUENCER</span><span class="qty">5,000</span><span class="price-tag">10,000 RWF</span>
                    <button class="btn-buy yt-btn">Buy Now</button>
                </div>
                <div class="package-card" onclick="initPurchase(20000, '10,000', 'Subscribers', 'ytUser')">
                    <span class="label">PRO</span><span class="qty">10,000</span><span class="price-tag">20,000 RWF</span>
                    <button class="btn-buy yt-btn">Buy Now</button>
                </div>
            </div>
        </div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div id="menuUser" style="font-weight: 800; font-size: 18px;">User</div>
            <div style="font-size: 11px; color: var(--primary); font-weight: 700; text-transform: uppercase;">Standard Account</div>
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
            <a href="login.html" onclick="logout()" class="menu-item" style="color: var(--danger); margin-top: 10px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <i class="fa-solid fa-right-from-bracket"></i> Logout Account
            </a>
        </nav>
    </div>

    <script>
        const currentUser = localStorage.getItem("current_user");
        let users = JSON.parse(localStorage.getItem("mula_users") || "[]");
        let userData = users.find(u => u.username === currentUser);

        function updateUI() {
            if(!userData) window.location.href = 'login.html';
            document.getElementById("menuUser").innerText = currentUser;
            document.getElementById("taskBalDisplay").innerText = (userData.taskBalance || 0).toLocaleString() + " RWF";
        }

        function switchTab(type) {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById(type).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        function initPurchase(cost, qty, service, inputId) {
            const identifier = document.getElementById(inputId).value;
            if(!identifier) { alert(`Please enter ${service === 'Followers' ? 'Instagram username' : 'YouTube link'}!`); return; }
            if((userData.taskBalance || 0) < cost) { alert("Insufficient Task Balance."); return; }

            if(!userData.hasPaidToken) {
                document.getElementById("tokenModal").style.display = 'flex';
            } else {
                alert(`Confirmed! ${qty} ${service} for ${identifier} are being processed.`);
            }
        }

        function closeModal() { document.getElementById("tokenModal").style.display = 'none'; }
        function toggleMenu() {
            const menu = document.getElementById("sideMenu");
            const overlay = document.getElementById("overlay");
            menu.classList.toggle('active');
            overlay.style.display = menu.classList.contains('active') ? 'block' : 'none';
        }
        function logout() { localStorage.removeItem("current_user"); window.location.href = 'login.html'; }
        updateUI();
    </script>
</body>
</html>