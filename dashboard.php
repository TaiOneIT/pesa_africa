<?php
require_once 'db.php';
if (!isset($_SESSION['current_user'])) {
    header("Location: login.php");
    exit;
}

$username =$_SESSION['current_user'];
$stmt =$pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$userData =$stmt->fetch();

if (!$userData) {
    session_destroy();
    header("Location: login.php");
    exit;
}
if (!$userData['isActivated']) {
    header("Location: pay_activation.php");
    exit;
}

// Safely check if welcome_claimed column exists in database result
$welcomeClaimed =$userData['welcome_claimed'] ?? 0;

// Handle Welcome Bonus Claim via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['claim_welcome'])) {
    if (!$welcomeClaimed) {
        try {
            $updateStmt =$pdo->prepare("UPDATE users SET bonus_balance = bonus_balance + 15000, welcome_claimed = 1 WHERE username = ?");
            $updateStmt->execute([$username]);$_SESSION['success_msg'] = "🎉 15,000 RWF Welcome Bonus successfully credited to your earning portfolio!";
        } catch (Exception $e) {
            $updateStmt =$pdo->prepare("UPDATE users SET bonus_balance = bonus_balance + 15000 WHERE username = ?");
            $updateStmt->execute([$username]);$_SESSION['success_msg'] = "🎉 15,000 RWF Welcome Bonus successfully credited to your earning portfolio!";
        }
        header("Location: dashboard.php");
        exit;
    }
}

// Calculate Totals
$taskBalance =$userData['task_balance'] ?? 0;
$bonusBalance =$userData['bonus_balance'] ?? 0;
$totalBalance = $taskBalance +$bonusBalance;
$referralLink = "https://pesaafrica.rw/register.php?ref=" . urlencode($username);
$showWelcomeModal = !$welcomeClaimed;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PESA AFRICA | Ultimate Earning Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { 
            --bg-light: #f4f7fb;
            --card-bg: #ffffff;
            --primary-green: #059669;
            --emerald-money: #10b981;
            --emerald-light: #ecfdf5;
            --gold-accent: #d97706;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-soft: 0 12px 30px rgba(15, 23, 42, 0.06);
            --shadow-hover: 0 20px 40px rgba(16, 185, 129, 0.15);
            --danger: #ef4444;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { color: var(--text-main); background: var(--bg-light); padding-bottom: 110px; overflow-x: hidden; }

        /* BRIGHT HEADER NAVBAR */
        .header { position: sticky; top: 0; z-index: 1000; width: 100%; height: 80px; padding: 0 40px; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.95); border-bottom: 1px solid var(--border-color); backdrop-filter: blur(15px); box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .header-left { display: flex; align-items: center; gap: 16px; }
        .menu-toggle-btn { width: 46px; height: 46px; display: flex; align-items: center; justify-content: center; border: 1.5px solid var(--border-color); border-radius: 12px; background: #ffffff; cursor: pointer; color: var(--text-main); font-size: 20px; transition: 0.3s; }
        .menu-toggle-btn:hover { background: var(--emerald-light); color: var(--primary-green); border-color: var(--emerald-money); }
        
        .brand-logo-area { display: flex; align-items: center; gap: 12px; }
        .brand-logo-area img { height: 42px; width: auto; filter: drop-shadow(0 4px 8px rgba(5,150,105,0.2)); }
        .brand-logo { font-size: 24px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px; }
        .brand-logo span { color: var(--primary-green); }

        .header-right { display: flex; align-items: center; gap: 16px; }
        .user-pill { display: flex; align-items: center; gap: 12px; padding: 6px 18px 6px 6px; background: #f8fafc; border: 1.5px solid var(--border-color); border-radius: 40px; }
        .user-pill-avatar { width: 36px; height: 36px; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 900; box-shadow: 0 4px 10px rgba(16,185,129,0.3); }
        .user-pill-name { font-size: 14px; font-weight: 800; color: #0f172a; }

        /* WIDE MAIN CONTAINER */
        .main-container { max-width: 1200px; margin: 35px auto; padding: 0 30px; }

        /* SUCCESS ALERT BANNER */
        .alert-banner { background: var(--emerald-light); border: 1.5px solid #a7f3d0; color: #065f46; padding: 18px 24px; border-radius: 16px; font-size: 15px; font-weight: 700; margin-bottom: 30px; display: flex; align-items: center; gap: 14px; box-shadow: 0 10px 25px rgba(16,185,129,0.1); }

        /* GIANT EXECUTIVE NET WORTH HERO BANNER */
        .hero-banner { background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); border: 2px solid #a7f3d0; border-radius: 28px; padding: 45px 50px; margin-bottom: 35px; box-shadow: var(--shadow-soft); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 30px; position: relative; overflow: hidden; }
        .hero-banner::after { content: '💸 💰 🚀 💵'; position: absolute; right: -20px; bottom: -30px; font-size: 140px; opacity: 0.03; pointer-events: none; }
        
        .hero-left h1 { font-size: 32px; font-weight: 900; letter-spacing: -0.5px; margin-bottom: 8px; color: #0f172a; }
        .hero-left p { font-size: 15px; color: var(--text-muted); font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .vip-badge { background: #fffbeb; color: var(--gold-accent); border: 1.5px solid #fef3c7; font-size: 12px; font-weight: 900; padding: 6px 14px; border-radius: 30px; display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase; box-shadow: 0 4px 10px rgba(217,119,6,0.1); }

        .hero-right { background: #ffffff; padding: 28px 40px; border-radius: 22px; border: 2px solid #d1fae5; min-width: 340px; text-align: right; box-shadow: 0 10px 25px rgba(16,185,129,0.1); }
        .hero-net-label { font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; color: var(--primary-green); margin-bottom: 8px; display: block; }
        .hero-net-amount { font-size: 42px; font-weight: 900; color: #0f172a; letter-spacing: -1px; text-shadow: 0 2px 10px rgba(0,0,0,0.05); }

        /* MONEY METRICS GRID & HIGHLY VISIBLE WITHDRAW BUTTONS */
        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px; margin-bottom: 35px; }
        .metric-card { background: var(--card-bg); border: 1.5px solid var(--border-color); border-radius: 22px; padding: 30px; box-shadow: var(--shadow-soft); display: flex; justify-content: space-between; align-items: center; transition: 0.3s; position: relative; overflow: hidden; }
        .metric-card:hover { border-color: var(--emerald-money); transform: translateY(-4px); box-shadow: var(--shadow-hover); }
        
        .metric-info span { font-size: 13px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.8px; display: block; margin-bottom: 8px; }
        .metric-info h3 { font-size: 32px; font-weight: 900; color: #0f172a; margin-bottom: 15px; }
        .metric-icon-box { width: 64px; height: 64px; border-radius: 18px; background: var(--emerald-light); color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-size: 26px; border: 1.5px solid #a7f3d0; box-shadow: 0 4px 15px rgba(16,185,129,0.15); }
        
        /* High Visibility Prominent Withdraw Buttons */
        .btn-withdraw-action { margin-top: 10px; display: inline-flex; align-items: center; justify-content: center; gap: 10px; font-size: 14px; font-weight: 900; color: #ffffff; text-decoration: none; padding: 12px 22px; background: linear-gradient(135deg, #059669, #10b981); border-radius: 12px; transition: 0.3s; box-shadow: 0 6px 20px rgba(5,150,105,0.35); text-transform: uppercase; letter-spacing: 0.5px; width: 100%; text-align: center; }
        .btn-withdraw-action:hover { background: linear-gradient(135deg, #047857, #059669); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(5,150,105,0.5); }

        /* SECTIONS GENERAL */
        .section-box { background: var(--card-bg); border: 1.5px solid var(--border-color); border-radius: 24px; padding: 35px; margin-bottom: 35px; box-shadow: var(--shadow-soft); }
        .section-title { font-size: 18px; font-weight: 900; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; letter-spacing: -0.3px; text-transform: uppercase; }
        .section-title i { color: var(--primary-green); }

        /* REFERRAL WIDGET WIDE */
        .referral-desc { font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 20px; font-weight: 600; }
        .referral-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; align-items: center; }
        @media(max-width: 768px) { .referral-layout { grid-template-columns: 1fr; } }
        
        .referral-box-group { display: flex; gap: 12px; }
        .referral-input-field { flex: 1; padding: 16px 20px; border: 1.5px solid var(--border-color); border-radius: 14px; font-size: 14px; background: #f8fafc; color: #0f172a; font-weight: 700; outline: none; }
        .btn-copy-ref { background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; padding: 0 28px; border-radius: 14px; font-weight: 900; font-size: 14px; cursor: pointer; box-shadow: 0 4px 15px rgba(16,185,129,0.3); transition: 0.2s; text-transform: uppercase; }
        .btn-copy-ref:hover { filter: brightness(1.1); transform: scale(1.02); }

        .social-row { display: flex; gap: 12px; }
        .btn-social-share { flex: 1; padding: 16px; border-radius: 14px; font-size: 14px; font-weight: 800; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; color: white; transition: 0.2s; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .btn-wa { background: #25d366; }
        .btn-tg { background: #0088cc; }
        .btn-social-share:hover { filter: brightness(1.1); transform: translateY(-2px); }

        /* SERVICES & MONEY TASKS GRID */
        .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .service-tile-card { background: #f8fafc; border: 1.5px solid var(--border-color); border-radius: 20px; padding: 26px; text-decoration: none; color: #0f172a; display: flex; flex-direction: column; gap: 16px; transition: all 0.3s ease; position: relative; }
        .service-tile-card:hover { border-color: var(--emerald-money); background: var(--emerald-light); transform: translateY(-5px); box-shadow: 0 12px 30px rgba(16,185,129,0.12); }
        
        .tile-top { display: flex; justify-content: space-between; align-items: center; }
        .tile-icon { width: 54px; height: 54px; border-radius: 16px; background: #ffffff; color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-size: 22px; border: 1.5px solid #a7f3d0; box-shadow: 0 4px 10px rgba(16,185,129,0.1); }
        .tile-arrow { color: #94a3b8; font-size: 16px; transition: 0.3s; }
        .service-tile-card:hover .tile-arrow { color: var(--primary-green); transform: translateX(5px); }
        
        .tile-content h4 { font-size: 18px; font-weight: 900; color: #0f172a; margin-bottom: 6px; }
        .tile-content p { font-size: 13px; color: var(--text-muted); font-weight: 600; }

        /* WELCOME BONUS POPUP MODAL */
        .modal-overlay { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(10px); z-index: 10000; display: <?php echo $showWelcomeModal ? 'flex' : 'none'; ?>; align-items: center; justify-content: center; padding: 25px; }
        .modal-card { background: #ffffff; width: 100%; max-width: 500px; border-radius: 32px; padding: 45px 35px; text-align: center; box-shadow: 0 30px 80px rgba(0,0,0,0.25); border: 2px solid #a7f3d0; animation: modalPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); }
        @keyframes modalPop { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        
        .modal-logo { height: 60px; width: auto; margin-bottom: 20px; filter: drop-shadow(0 4px 10px rgba(5,150,105,0.2)); }
        .modal-badge { background: #fffbeb; color: var(--gold-accent); border: 1.5px solid #fef3c7; font-size: 12px; font-weight: 900; padding: 6px 18px; border-radius: 30px; text-transform: uppercase; display: inline-block; margin-bottom: 18px; box-shadow: 0 4px 10px rgba(217,119,6,0.1); }
        .modal-card h2 { font-size: 28px; font-weight: 900; color: #0f172a; margin-bottom: 12px; letter-spacing: -0.5px; }
        .modal-card p { font-size: 14px; color: var(--text-muted); line-height: 1.7; margin-bottom: 25px; font-weight: 600; }
        
        .modal-bonus-box { background: var(--emerald-light); border: 2px dashed var(--emerald-money); border-radius: 20px; padding: 20px; margin-bottom: 30px; color: #065f46; font-weight: 900; font-size: 30px; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: inset 0 2px 10px rgba(16,185,129,0.1); }
        .btn-claim-giant { width: 100%; padding: 20px; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 16px; font-size: 16px; font-weight: 900; cursor: pointer; box-shadow: 0 10px 30px rgba(16,185,129,0.4); text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; }
        .btn-claim-giant:hover { background: #047857; transform: translateY(-3px); }

        /* SIDEBAR DRAWER */
        .side-menu { position: fixed; left: -360px; top: 0; bottom: 0; width: 320px; z-index: 5000; padding: 30px 24px; background: #ffffff; border-right: 1px solid var(--border-color); color: #0f172a; transition: .35s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 15px 0 50px rgba(0,0,0,0.15); overflow-y: auto; }
        .side-menu.active { left: 0; }
        .side-menu-header { display: flex; align-items: center; gap: 14px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color); }
        .side-menu-header img { height: 38px; width: auto; }
        .menu-item { display: flex; align-items: center; gap: 14px; padding: 14px 16px; margin-bottom: 6px; border-radius: 12px; color: #334155; text-decoration: none; font-size: 14px; font-weight: 800; transition: 0.2s; }
        .menu-item i { width: 22px; text-align: center; color: var(--primary-green); }
        .menu-item:hover, .menu-item.active { background: var(--emerald-light); color: var(--primary-green); }
        .menu-item.logout { color: #ef4444; margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 20px; }
        .menu-item.logout i { color: #ef4444; }
        .overlay { position: fixed; inset: 0; display: none; z-index: 4500; background: rgba(15,23,42,0.5); backdrop-filter: blur(4px); }

        /* MOBILE FLOATING DOCK */
        .mobile-bottom-nav { position: fixed; left: 20px; right: 20px; bottom: 15px; z-index: 3500; height: 72px; display: grid; grid-template-columns: repeat(5,1fr); align-items: center; background: rgba(255, 255, 255, 0.98); border-radius: 22px; border: 1.5px solid var(--border-color); box-shadow: 0 15px 40px rgba(0,0,0,0.12); max-width: 650px; margin: 0 auto; backdrop-filter: blur(15px); }
        .bottom-nav-item { display: flex; flex-direction: column; align-items: center; color: var(--text-muted); text-decoration: none; font-size: 10px; font-weight: 800; gap: 4px; transition: 0.2s; }
        .bottom-nav-item.active { color: var(--primary-green); }
        .bottom-nav-item i { font-size: 18px; }
    </style>
</head>
<body>

<!-- WELCOME BONUS GIANT MODAL -->
<div class="modal-overlay" id="welcomeModal">
    <div class="modal-card">
        <img src="assets/logo.png" alt="Pesa Africa Logo" class="modal-logo" onerror="this.style.display='none'">
        <div class="modal-badge"><i class="fa-solid fa-star"></i> Onboarding Bonus Reward 🎁</div>
        <h2>Welcome to Pesa Africa! 🚀</h2>
        <p>Your account is fully activated. Claim your instant onboarding gift reward right now to kickstart your earning portfolio balance!</p>
        
        <div class="modal-bonus-box">
            <span>🎁 +15,000 RWF</span>
        </div>

        <form method="POST">
            <input type="hidden" name="claim_welcome" value="1">
            <button type="submit" class="btn-claim-giant">Claim Bonus & Start Earning 💸</button>
        </form>
    </div>
</div>

<div class="overlay" id="overlay" onclick="toggleMenu()"></div>

<!-- FULL WIDTH BRIGHT HEADER -->
<div class="header">
    <div class="header-left">
        <div class="menu-toggle-btn" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="brand-logo-area">
            <img src="assets/logo.png" alt="Logo" onerror="this.style.display='none'">
            <div class="brand-logo">PESA <span>AFRICA</span></div>
        </div>
    </div>
    <div class="header-right">
        <div class="user-pill">
            <div class="user-pill-avatar"><?php echo strtoupper(substr($userData['username'], 0, 1)); ?></div>
            <span class="user-pill-name"><?php echo htmlspecialchars($userData['username']); ?></span>
        </div>
        <a href="logout.php" class="menu-toggle-btn" style="color: var(--danger);" title="Sign Out"><i class="fa-solid fa-right-from-bracket"></i></a>
    </div>
</div>

<!-- MAIN CONTAINER WIDE -->
<div class="main-container">
    
    <!-- SUCCESS ALERT -->
    <?php if(isset($_SESSION['success_msg'])): ?>
        <div class="alert-banner">
            <i class="fa-solid fa-circle-check" style="font-size: 22px;"></i> 
            <div><?php echo htmlspecialchars($_SESSION['success_msg']); unset($_SESSION['success_msg']); ?></div>
        </div>
    <?php endif; ?>

    <!-- GIANT HERO NET WORTH BANNER -->
    <div class="hero-banner">
        <div class="hero-left">
            <div class="vip-badge"><i class="fa-solid fa-crown"></i> Elite Earning Account 💎</div>
            <h1>Welcome Back, <?php echo htmlspecialchars($userData['username']); ?>! 🔥</h1>
            <p><i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($userData['mobile'] ?? 'Verified Active Member'); ?> | <span style="color: var(--primary-green); font-weight: 800;">Ready to Make Money Today 💸</span></p>
        </div>
        <div class="hero-right">
            <span class="hero-net-label">💰 Net Portfolio Balance 💰</span>
            <div class="hero-net-amount"><?php echo number_format($totalBalance); ?> <span style="font-size: 18px; color: var(--primary-green); font-weight: 800;">RWF</span></div>
        </div>
    </div>

    <!-- BALANCES & WITHDRAWAL METRICS GRID WITH HIGH-VISIBILITY BUTTONS -->
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-info" style="width: 100%;">
                <span>📈 Task Earning Balance 📈</span>
                <h3><?php echo number_format($taskBalance); ?> <span style="font-size: 16px; color: var(--text-muted);">RWF</span></h3>
                <a href="Withdraw_Task_Balance.php" class="btn-withdraw-action"><i class="fa-solid fa-money-bill-transfer"></i> Withdraw Task Cash 💸</a>
            </div>
            <div class="metric-icon-box"><i class="fa-solid fa-wallet"></i></div>
        </div>

        <div class="metric-card">
            <div class="metric-info" style="width: 100%;">
                <span>🎁 Bonus Reward Balance 🎁</span>
                <h3 style="color: var(--primary-green);"><?php echo number_format($bonusBalance); ?> <span style="font-size: 16px; color: var(--text-muted);">RWF</span></h3>
                <a href="Withdraw_bonus.php" class="btn-withdraw-action"><i class="fa-solid fa-gift"></i> Withdraw Bonus Cash 🚀</a>
            </div>
            <div class="metric-icon-box" style="color: var(--gold-accent); background: #fffbeb; border-color: #fef3c7;"><i class="fa-solid fa-gift"></i></div>
        </div>
    </div>

    <!-- REFERRAL & AFFILIATE MONEY MACHINE -->
    <div class="section-box">
        <div class="section-title"><i class="fa-solid fa-user-plus"></i> Invite Friends & Earn Cash Daily 💵</div>
        <p class="referral-desc">Share your referral link with friends on WhatsApp and Telegram. Earn instant generous cash commissions every time they join and activate their Pesa Africa accounts! 🚀</p>
        
        <div class="referral-layout">
            <div class="referral-box-group">
                <input type="text" class="referral-input-field" id="referralLinkInput" value="<?php echo htmlspecialchars($referralLink); ?>" readonly>
                <button class="btn-copy-ref" onclick="copyReferralLink()"><i class="fa-solid fa-copy"></i> Copy</button>
            </div>
            <div class="social-row">
                <a href="https://api.whatsapp.com/send?text=Join%20Pesa%20Africa%20and%20earn%20real%20cash%20daily!%20Register%20here:%20<?php echo urlencode($referralLink); ?>" target="_blank" class="btn-social-share btn-wa"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                <a href="https://t.me/share/url?url=<?php echo urlencode($referralLink); ?>&text=Join%20Pesa%20Africa%20and%20earn%20real%20cash!" target="_blank" class="btn-social-share btn-tg"><i class="fa-brands fa-telegram"></i> Telegram</a>
            </div>
        </div>
    </div>

    <!-- SERVICES & EARNING TASKS -->
    <div class="section-box">
        <div class="section-title" style="margin-bottom: 24px;"><i class="fa-solid fa-bolt"></i> High-Paying Earning Modules & Tasks 💰</div>
        
        <div class="services-grid">
            <a href="image_task.php" class="service-tile-card">
                <div class="tile-top">
                    <div class="tile-icon"><i class="fa-solid fa-image"></i></div>
                    <i class="fa-solid fa-chevron-right tile-arrow"></i>
                </div>
                <div class="tile-content">
                    <h4>Image Tasks 🖼️</h4>
                    <p>View images and earn cash instantly per completion.</p>
                </div>
            </a>

            <a href="video_task.php" class="service-tile-card">
                <div class="tile-top">
                    <div class="tile-icon"><i class="fa-solid fa-video"></i></div>
                    <i class="fa-solid fa-chevron-right tile-arrow"></i>
                </div>
                <div class="tile-content">
                    <h4>Video Tasks 🎬</h4>
                    <p>Watch sponsored videos and grow your wallet balance.</p>
                </div>
            </a>

            <a href="Forex_Trading_Task.php" class="service-tile-card">
                <div class="tile-top">
                    <div class="tile-icon"><i class="fa-solid fa-chart-line"></i></div>
                    <i class="fa-solid fa-chevron-right tile-arrow"></i>
                </div>
                <div class="tile-content">
                    <h4>Forex Tasks 📊</h4>
                    <p>Analyze currency markets and collect high-tier payouts.</p>
                </div>
            </a>

            <a href="buy_followers_subscribers.php" class="service-tile-card">
                <div class="tile-top">
                    <div class="tile-icon"><i class="fa-solid fa-users"></i></div>
                    <i class="fa-solid fa-chevron-right tile-arrow"></i>
                </div>
                <div class="tile-content">
                    <h4>Social Growth 📱</h4>
                    <p>Boost your social media presence and engagement.</p>
                </div>
            </a>

            <a href="spin.php" class="service-tile-card">
                <div class="tile-top">
                    <div class="tile-icon"><i class="fa-solid fa-rotate"></i></div>
                    <i class="fa-solid fa-chevron-right tile-arrow"></i>
                </div>
                <div class="tile-content">
                    <h4>Lucky Spin Wheel 🎡</h4>
                    <p>Spin daily to win massive cash prizes and rewards.</p>
                </div>
            </a>

            <a href="aviator.php" class="service-tile-card">
                <div class="tile-top">
                    <div class="tile-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <i class="fa-solid fa-chevron-right tile-arrow"></i>
                </div>
                <div class="tile-content">
                    <h4>Multiplier Hub ✈️</h4>
                    <p>Engage in high-yield trading simulations & multipliers.</p>
                </div>
            </a>
        </div>
    </div>

</div>

<!-- SIDEBAR DRAWER MENU -->
<div class="side-menu" id="sideMenu">
    <div class="side-menu-header">
        <img src="assets/logo.png" alt="Logo" onerror="this.style.display='none'">
        <div>
            <div style="font-size: 15px; font-weight: 900; color: #0f172a;"><?php echo htmlspecialchars($userData['username']); ?></div>
            <div style="color: var(--primary-green); font-size: 11px; font-weight: 800; text-transform: uppercase; margin-top: 3px;">💎 Verified Earner</div>
        </div>
    </div>
    <nav>
        <a href="dashboard.php" class="menu-item active"><i class="fa-solid fa-house"></i> Earning Dashboard 🏠</a>
        <a href="Withdraw_Task_Balance.php" class="menu-item"><i class="fa-solid fa-money-bill-transfer"></i> Withdraw Task Cash 💸</a>
        <a href="Withdraw_bonus.php" class="menu-item"><i class="fa-solid fa-wallet"></i> Withdraw Bonus Balance 🎁</a>
        <a href="image_task.php" class="menu-item"><i class="fa-solid fa-image"></i> Image Tasks 🖼️</a>
        <a href="video_task.php" class="menu-item"><i class="fa-solid fa-video"></i> Video Tasks 🎬</a>
        <a href="Forex_Trading_Task.php" class="menu-item"><i class="fa-solid fa-chart-line"></i> Forex Trading 📊</a>
        <a href="buy_followers_subscribers.php" class="menu-item"><i class="fa-solid fa-users"></i> Social Growth Hub 📱</a>
        <a href="spin.php" class="menu-item"><i class="fa-solid fa-rotate"></i> Reward Spin 🎡</a>
        <a href="aviator.php" class="menu-item"><i class="fa-solid fa-chart-pie"></i> Multiplier Hub ✈️</a>
        <a href="logout.php" class="menu-item logout"><i class="fa-solid fa-right-from-bracket"></i> Sign Out Securely 🔒</a>
    </nav>
</div>

<!-- MOBILE BOTTOM FLOATING DOCK -->
<div class="mobile-bottom-nav">
    <a href="dashboard.php" class="bottom-nav-item active"><i class="fa-solid fa-house"></i><span>Home</span></a>
    <a href="image_task.php" class="bottom-nav-item"><i class="fa-solid fa-briefcase"></i><span>Tasks</span></a>
    <a href="Withdraw_Task_Balance.php" class="bottom-nav-item"><i class="fa-solid fa-wallet"></i><span>Withdraw</span></a>
    <a href="spin.php" class="bottom-nav-item"><i class="fa-solid fa-rotate"></i><span>Spin</span></a>
    <a href="#" onclick="toggleMenu(); return false;" class="bottom-nav-item"><i class="fa-solid fa-bars"></i><span>Menu</span></a>
</div>

<script>
function toggleMenu() {
    const menu = document.getElementById("sideMenu");
    const overlay = document.getElementById("overlay");
    const active = menu.classList.toggle("active");
    overlay.style.display = active ? "block" : "none";
}

function copyReferralLink() {
    const input = document.getElementById("referralLinkInput");
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        alert("📋 Referral link successfully copied to clipboard! Share and earn cash! 🚀");
    });
}
</script>
</body>
</html>