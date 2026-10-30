<?php
require_once 'db.php';
if (!isset($_SESSION['current_user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['current_user'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$userData = $stmt->fetch();

if (!$userData) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Redirect unactivated users to activation page
if (!$userData['isActivated']) {
    header("Location: pay_activation.php");
    exit;
}

// Security Check: Block users who haven't paid/been approved for the withdrawal token
if (!isset($userData['hasPaidToken']) || !$userData['hasPaidToken']) {
    header("Location: pay_token.php");
    exit;
}

$bonusBalance = $userData['bonus_balance'] ?? 0;
$msg = "";

// Handle Bonus Withdrawal POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    $phone = trim($_POST['phone'] ?? '');

    if ($amount <= 0 || empty($phone)) {
        $msg = "<div class='error-alert'>Nyamuneka shyiramo umubare w'amafaranga n'nimero ya terefone bikwiye.</div>";
    } elseif ($amount < 5000) {
        $msg = "<div class='error-alert'>Umusanzu muto ushobora kubikuza ku bonus balance ni 5,000 RWF.</div>";
    } elseif ($amount > $bonusBalance) {
        $msg = "<div class='error-alert'>Ntabwo ufite uyu mubare wose muri Bonus Wallet Balance yawe!</div>";
    } else {
        $pdo->beginTransaction();
        try {
            // Deduct from bonus balance
            $upd = $pdo->prepare("UPDATE users SET bonus_balance = bonus_balance - ? WHERE username = ?");
            $upd->execute([$amount, $username]);

            // Insert into withdrawals table for admin audit
            $ins = $pdo->prepare("INSERT INTO withdrawals (username, type, amount, phone, status) VALUES (?, 'bonus', ?, ?, 'Pending')");
            $ins->execute([$username, $amount, $phone]);

            $pdo->commit();
            $msg = "<div class='success-alert'>🎉 Ubusabe bwawe bwo kubikuza " . number_format($amount) . " RWF bwoherejwe neza! Buri mu bategereje kwemezwa na Admin.</div>";

            // Refresh user data
            $stmt->execute([$username]);
            $userData = $stmt->fetch();
            $bonusBalance = $userData['bonus_balance'] ?? 0;
        } catch (Exception $e) {
            $pdo->rollBack();
            $msg = "<div class='error-alert'>Habaye ikibazo mu kohereza ubusabe bwawe. Ongera ugerageze.</div>";
        }
    }
}

// Fetch user's past bonus withdrawals
$histStmt = $pdo->prepare("SELECT * FROM withdrawals WHERE username = ? AND type = 'bonus' ORDER BY id DESC");
$histStmt->execute([$username]);
$history = $histStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Withdraw Bonus | PESA AFRICA</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --brand-main: #000000; --brand-secondary: #000000; --success: #00c853; 
            --warning: #f59e0b; --danger: #ef4444; --bg-light: #f8faff; --white: #ffffff;
            --text-dark: #1a1f36; --text-muted: #64748b; --border: #e3e8ee; --premium-gold: #ffab00;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-light); margin: 0; color: var(--text-dark); overflow-x: hidden; padding-top: 40px; }

        .ticker-header {
            position: fixed; top: 0; left: 0; width: 100%; height: 40px;
            background: linear-gradient(90deg, #000000, #0c101b);
            border-bottom: 2px solid var(--premium-gold); color: #ffffff;
            font-size: 12px; font-weight: 700; display: flex; align-items: center;
            overflow: hidden; white-space: nowrap; z-index: 2001; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .ticker-wrap { display: inline-block; padding-left: 100%; animation: marquee-scroll 28s linear infinite; }
        .ticker-msg { display: inline-flex; align-items: center; gap: 8px; margin-right: 60px; background: rgba(255, 255, 255, 0.06); padding: 4px 12px; border-radius: 50px; border: 1px solid rgba(255, 171, 0, 0.2); }
        .ticker-badge { background: var(--success); color: white; font-size: 9px; text-transform: uppercase; padding: 2px 6px; border-radius: 4px; font-weight: 800; }
        @keyframes marquee-scroll { 0% { transform: translate3d(0, 0, 0); } 100% { transform: translate3d(-100%, 0, 0); } }

        .live-sticker {
            position: absolute; top: 20px; right: 20px; background: #ff007f; color: white;
            font-size: 9px; font-weight: 800; padding: 4px 10px; border-radius: 50px;
            display: flex; align-items: center; gap: 4px; z-index: 10; text-transform: uppercase;
        }

        .header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: var(--white); border-bottom: 1px solid var(--border); position: sticky; top: 40px; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .menu-btn { background: #f0f4ff; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; border-radius: 12px; cursor: pointer; color: var(--brand-main); }
        .brand-logo { font-weight: 800; font-size: 20px; color: var(--brand-secondary); display: flex; align-items: center; gap: 5px; }
        .brand-logo span { color: #0046ff; }

        .container { padding: 20px; max-width: 500px; margin: 0 auto; }
        
        .balance-card { background: linear-gradient(135deg, #01040c 0%, #0e1628 100%); border-radius: 24px; padding: 28px 25px; color: white; position: relative; overflow: hidden; box-shadow: 0 12px 25px rgba(0,0,0,0.2); margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.08); }
        .card-label { font-size: 11px; font-weight: 700; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 5px; }
        .balance-val { font-size: 34px; font-weight: 800; margin: 10px 0; letter-spacing: -0.5px; }
        .verified-tag { background: rgba(0,200,83,0.2); color: #00ff6a; font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 100px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(0,200,83,0.2); }

        .withdraw-form { background: var(--white); border-radius: 24px; padding: 25px; border: 1px solid var(--border); box-shadow: 0 4px 20px rgba(0,0,0,0.01); }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; font-size: 13px; font-weight: 800; color: var(--brand-secondary); margin-bottom: 8px; text-transform: uppercase; }
        .input-group select, .input-group input { width: 100%; padding: 16px; border-radius: 14px; border: 2px solid #f1f5f9; font-size: 15px; font-weight: 700; background: #fdfeff; color: var(--text-dark); outline: none; }
        .input-group select:focus, .input-group input:focus { border-color: #0046ff; background: #ffffff; }

        .btn-submit { width: 100%; padding: 18px; border-radius: 16px; background: linear-gradient(90deg, #000000, #111111); color: white; border: none; font-size: 16px; font-weight: 800; cursor: pointer; box-shadow: 0 8px 20px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: center; gap: 8px; }

        .history-title { font-size: 15px; font-weight: 800; color: var(--brand-secondary); margin: 30px 0 15px; display: flex; align-items: center; gap: 10px; text-transform: uppercase; }
        .history-card { background: var(--white); border-radius: 20px; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.01); }
        .history-item { padding: 16px 20px; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center; }
        .history-item:last-child { border-bottom: none; }
        .status-pill { font-size: 10px; font-weight: 800; padding: 6px 14px; border-radius: 100px; text-transform: uppercase; }
        .status-pill.pending { background: #fff7ed; color: var(--warning); border: 1px solid #ffedd5; }
        .status-pill.approved { background: #ecfdf5; color: var(--success); border: 1px solid #a7f3d0; }
        .status-pill.rejected { background: #fee2e2; color: var(--danger); border: 1px solid #fca5a5; }

        .side-menu { position: fixed; top: 0; left: -100%; width: 80%; max-width: 300px; height: 100%; background: var(--white); z-index: 2100; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); padding: 40px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.15); }
        .side-menu.active { left: 0; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 14px 16px; color: var(--text-dark); text-decoration: none; font-weight: 700; border-radius: 14px; margin-bottom: 6px; font-size: 14px; }
        .menu-item:hover { background: #f8faff; }
        .menu-item i { width: 20px; text-align: center; color: var(--text-muted); }
        .menu-item.active { background: #f0f4ff; color: var(--brand-main); }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: none; z-index: 2050; backdrop-filter: blur(3px); }

        .success-alert { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; }
        .error-alert { background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; padding: 14px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="ticker-header">
        <div class="ticker-wrap">
            <div class="ticker-msg"><span class="ticker-badge">Live Payout</span><span>🎉 <strong>alice 078*****44</strong> successful withdrawn <strong>20000 rwf</strong> from pesa africa 🔥</span></div>
            <div class="ticker-msg"><span class="ticker-badge">Live Payout</span><span>⚡ <strong>Eric 079*****12</strong> successful withdrawn <strong>45000 rwf</strong> from pesa africa 🚀</span></div>
            <div class="ticker-msg"><span class="ticker-badge">Live Payout</span><span>💎 <strong>Diane 078*****89</strong> successful withdrawn <strong>15000 rwf</strong> from pesa africa 💰</span></div>
        </div>
    </div>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <div class="header">
        <div class="menu-btn" onclick="toggleMenu()"><i class="fa-solid fa-bars-staggered"></i></div>
        <div class="brand-logo">💎 PESA <span>AFRICA</span></div>
        <div class="menu-btn" onclick="location.reload()"><i class="fa-solid fa-rotate-right"></i></div>
    </div>

    <div class="container">
        <?php echo $msg; ?>

        <div class="balance-card">
            <div class="live-sticker"><i class="fa-solid fa-bolt"></i> INSTANT PAYOUT ✨</div>
            <div class="card-label">Bonus Wallet Balance 💸</div>
            <div class="balance-val"><?php echo number_format($bonusBalance); ?> RWF</div>
            <div class="verified-tag"><i class="fa-solid fa-circle-check"></i> Available for Payout ✅</div>
        </div>

        <div class="withdraw-form">
            <form method="POST">
                <div class="input-group">
                    <label>📲 Mobile Network</label>
                    <select name="channel">
                        <option value="mtn">MTN Mobile Money</option>
                        <option value="airtel">Airtel Money</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>🔑 Phone Number</label>
                    <input type="tel" name="phone" placeholder="07xxxxxxxx" maxlength="10" required>
                </div>
                <div class="input-group">
                    <label>💵 Amount (RWF)</label>
                    <input type="number" name="amount" placeholder="Min: 5,000 RWF" min="5000" max="<?php echo $bonusBalance; ?>" required>
                </div>
                <button type="submit" class="btn-submit">SUBMIT REQUEST 🚀</button>
            </form>
        </div>

        <div class="history-title"><i class="fa-solid fa-clock-rotate-left" style="color: #0046ff;"></i> Payout Audit Log</div>
        <div class="history-card">
            <?php if (empty($history)): ?>
                <p style="text-align: center; color: var(--text-muted); font-size: 13px; padding: 35px; font-weight: 600;">No pending or completed withdrawals.</p>
            <?php else: ?>
                <?php foreach ($history as $h): ?>
                    <div class="history-item">
                        <div>
                            <div style="font-weight: 800; font-size: 14px;">💰 <?php echo number_format($h['amount']); ?> RWF</div>
                            <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px; font-weight: 600;"><?php echo htmlspecialchars($h['phone']); ?> • <?php echo $h['created_at']; ?></div>
                        </div>
                        <span class="status-pill <?php echo strtolower($h['status']); ?>"><?php echo $h['status']; ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 22px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div style="font-weight: 800; font-size: 20px;"><?php echo htmlspecialchars($userData['username']); ?></div>
            <div style="font-size: 11px; color: var(--success); font-weight: 800; margin-top: 5px; text-transform: uppercase;"><i class="fa-solid fa-circle-check"></i> Verified Member Account</div>
        </div>
        <nav>
            <a href="dashboard.php" class="menu-item"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="Withdraw_bonus.php" class="menu-item active"><i class="fa-solid fa-plane-up"></i> Withdraw Bonus</a>
            <a href="Withdraw_Task_Balance.php" class="menu-item"><i class="fa-solid fa-plane-up"></i> Withdraw Task Balance</a>
            <a href="spin.php" class="menu-item"><i class="fa-solid fa-dharmachakra"></i> Daily Bonus</a>
            <a href="aviator.php" class="menu-item"><i class="fa-solid fa-plane-up"></i> Multiplier Hub</a>
            <a href="image_task.php" class="menu-item"><i class="fa-solid fa-image"></i> Image Tasks</a>
            <a href="video_task.php" class="menu-item"><i class="fa-solid fa-circle-play"></i> Video Tasks</a>
            <a href="Forex_Trading_Task.php" class="menu-item"><i class="fa-solid fa-chart-simple"></i> Forex Trading</a>
            <a href="buy_followers_subscribers.php" class="menu-item"><i class="fa-solid fa-users-viewfinder"></i> Social Growth</a>
            <a href="logout.php" class="menu-item" style="color: var(--danger);"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </nav>
    </div>

    <script>
    function toggleMenu() {
        const menu = document.getElementById("sideMenu");
        const overlay = document.getElementById("overlay");
        menu.classList.toggle('active');
        overlay.style.display = menu.classList.contains('active') ? 'block' : 'none';
    }
    </script>
</body>
</html>