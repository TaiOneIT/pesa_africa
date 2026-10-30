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

$taskBalance = $userData['task_balance'] ?? 0;
$msg = "";

// Handle Task Withdrawal POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    $phone = trim($_POST['phone'] ?? '');

    if ($amount <= 0 || empty($phone)) {
        $msg = "<div class='error-alert'>Nyamuneka shyiramo umubare w'amafaranga n'nimero ya terefone bikwiye.</div>";
    } elseif ($amount < 1000) {
        $msg = "<div class='error-alert'>Umusanzu muto ushobora kubikuza mu task balance ni 1,000 RWF.</div>";
    } elseif ($amount > $taskBalance) {
        $msg = "<div class='error-alert'>Ntabwo ufite uyu mubare wose muri Task Balance yawe!</div>";
    } else {
        $pdo->beginTransaction();
        try {
            // Deduct from task balance
            $upd = $pdo->prepare("UPDATE users SET task_balance = task_balance - ? WHERE username = ?");
            $upd->execute([$amount, $username]);

            // Insert into withdrawals table for admin audit
            $ins = $pdo->prepare("INSERT INTO withdrawals (username, type, amount, phone, status) VALUES (?, 'task', ?, ?, 'Pending')");
            $ins->execute([$username, $amount, $phone]);

            $pdo->commit();
            $msg = "<div class='success-alert'>🎉 Ubusabe bwawe bwo kubikuza " . number_format($amount) . " RWF bwoherejwe neza! Buri mu bategereje kwemezwa na Admin.</div>";

            // Refresh user data
            $stmt->execute([$username]);
            $userData = $stmt->fetch();
            $taskBalance = $userData['task_balance'] ?? 0;
        } catch (Exception $e) {
            $pdo->rollBack();
            $msg = "<div class='error-alert'>Habaye ikibazo mu kohereza ubusabe bwawe. Ongera ugerageze.</div>";
        }
    }
}

// Fetch user's past withdrawals
$histStmt = $pdo->prepare("SELECT * FROM withdrawals WHERE username = ? AND type = 'task' ORDER BY id DESC");
$histStmt->execute([$username]);
$history = $histStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Withdraw Task Balance | PESA AFRICA</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --brand-main: #000000; --brand-secondary: #000000; --success: #00c853; 
            --danger: #ef4444; --warning: #f59e0b; --bg: #f8faff; --white: #fff;
            --premium-gold: #ffab00;
            --text-dark: #1a1f36;
            --text-muted: #64748b;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); margin: 0; padding-top: 40px; }

        .ticker-header {
            position: fixed; top: 0; left: 0; width: 100%; height: 40px;
            background: linear-gradient(90deg, #000000, #0d1220);
            border-bottom: 2px solid var(--premium-gold); color: #ffffff;
            font-size: 12px; font-weight: 700; display: flex; align-items: center;
            overflow: hidden; white-space: nowrap; z-index: 2001; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .ticker-wrap { display: inline-block; padding-left: 100%; animation: marquee-scroll 28s linear infinite; }
        .ticker-msg { display: inline-flex; align-items: center; gap: 8px; margin-right: 60px; background: rgba(255, 255, 255, 0.06); padding: 4px 12px; border-radius: 50px; border: 1px solid rgba(255, 171, 0, 0.2); }
        .ticker-badge { background: var(--success); color: white; font-size: 9px; text-transform: uppercase; padding: 2px 6px; border-radius: 4px; font-weight: 800; }
        @keyframes marquee-scroll { 0% { transform: translate3d(0, 0, 0); } 100% { transform: translate3d(-100%, 0, 0); } }

        .live-node-badge {
            position: absolute; top: 20px; right: 20px; background: linear-gradient(135deg, #ff007f, #ff5252);
            color: white; font-size: 9px; font-weight: 800; padding: 4px 10px; border-radius: 50px;
            display: flex; align-items: center; gap: 4px; text-transform: uppercase;
        }

        .trust-indicator-card {
            background: #fff8eb; color: #b76e00; border: 1px solid #ffe8cc;
            padding: 8px 14px; border-radius: 14px; font-size: 11px; font-weight: 700;
            display: flex; align-items: center; gap: 6px; margin: 0 auto 20px; max-width: 500px;
        }

        .header { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; background: var(--white); border-bottom: 1px solid #eee; position: sticky; top: 40px; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .menu-btn { background: #f0f4ff; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; border-radius: 12px; color: var(--brand-main); cursor: pointer; }

        .container { padding: 20px; max-width: 500px; margin: 0 auto; }
        
        .task-card { background: linear-gradient(135deg, #02050e 0%, #0f172a 100%); border-radius: 24px; padding: 32px 20px; text-align: center; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 12px 25px rgba(0,0,0,0.2); margin-bottom: 25px; position: relative; overflow: hidden; }
        .task-card .label { font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .task-card .amount { font-size: 38px; font-weight: 800; color: #ffffff; margin: 12px 0; letter-spacing: -1px; }
        .task-card .badge { display: inline-block; padding: 6px 14px; background: rgba(0,200,83,0.15); color: #00ff6a; font-size: 11px; font-weight: 800; border-radius: 100px; border: 1px solid rgba(0,200,83,0.2); }

        .form-box { background: var(--white); padding: 25px; border-radius: 24px; border: 1px solid #eee; box-shadow: 0 4px 20px rgba(0,0,0,0.01); }
        .input-group { margin-bottom: 18px; text-align: left; }
        .input-group label { display: block; font-size: 12px; font-weight: 800; margin-bottom: 8px; color: var(--brand-secondary); text-transform: uppercase; }
        input { width: 100%; padding: 16px; border-radius: 14px; border: 2px solid #f1f5f9; font-size: 15px; font-weight: 700; box-sizing: border-box; background: #fdfefe; color: var(--text-dark); outline: none; }
        input:focus { border-color: #0046ff; background: #ffffff; }

        .withdraw-btn { width: 100%; padding: 18px; border-radius: 16px; background: linear-gradient(90deg, #000000, #161616); color: white; border: none; font-size: 16px; font-weight: 800; cursor: pointer; box-shadow: 0 8px 25px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: center; gap: 8px; }

        .history-section { margin-top: 35px; }
        .history-list { background: var(--white); border-radius: 20px; border: 1px solid #eee; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.01); }
        .row { display: flex; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid #f8fafc; align-items: center; }
        .row:last-child { border: none; }
        .status { font-size: 10px; font-weight: 800; padding: 5px 12px; border-radius: 100px; text-transform: uppercase; }
        .status.pending { color: var(--warning); background: #fffbeb; border: 1px solid #fef3c7; }
        .status.approved { color: var(--success); background: #ecfdf5; border: 1px solid #a7f3d0; }
        .status.rejected { color: var(--danger); background: #fee2e2; border: 1px solid #fca5a5; }

        .side-menu { position: fixed; top: 0; left: -100%; width: 80%; max-width: 300px; height: 100%; background: var(--white); z-index: 2100; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); padding: 40px 20px; box-shadow: 25px 0 50px rgba(0,0,0,0.15); }
        .side-menu.active { left: 0; }
        .menu-item { display: flex; align-items: center; gap: 12px; padding: 14px 16px; color: #1a1f36; text-decoration: none; font-weight: 700; border-radius: 14px; margin-bottom: 5px; font-size: 14px; }
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
        <div style="font-weight: 800; font-size: 18px; color: var(--brand-secondary);">💎 Withdraw Task Balance</div>
        <div onclick="window.history.back()" style="color: #94a3b8; cursor: pointer; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; background: #f8faff; border-radius: 12px;"><i class="fa-solid fa-chevron-left"></i></div>
    </div>

    <div class="container">
        <div class="trust-indicator-card">
            <i class="fa-solid fa-circle-check" style="color: var(--success);"></i>
            <span>Encrypted Node Sync • 100% Guaranteed Instant Wallet Remittance</span>
        </div>

        <?php echo $msg; ?>

        <div class="task-card">
            <div class="live-node-badge"><i class="fa-solid fa-circle" style="font-size: 6px; color: #fff;"></i> LIVE ENDPOINT ✨</div>
            <div class="label">Total Task Earning 💰</div>
            <div class="amount"><?php echo number_format($taskBalance); ?> RWF</div>
            <div class="badge"><i class="fa-solid fa-bolt"></i> Instant Payout Ready ✅</div>
        </div>

        <div class="form-box">
            <form method="POST">
                <div class="input-group">
                    <label>📲 Mobile Number (MTN/Airtel)</label>
                    <input type="tel" name="phone" placeholder="07xxxxxxxx" maxlength="10" required>
                </div>
                <div class="input-group">
                    <label>💵 Amount (RWF)</label>
                    <input type="number" name="amount" placeholder="Min 1,000 RWF" min="1000" max="<?php echo $taskBalance; ?>" required>
                </div>
                <button type="submit" class="withdraw-btn">WITHDRAW NOW 🚀</button>
            </form>
        </div>

        <div class="history-section">
            <div style="font-weight: 800; margin-bottom: 15px; color: var(--brand-secondary); text-transform: uppercase; font-size: 13px;"><i class="fa-solid fa-clock-rotate-left" style="color: #0046ff;"></i> Task Payout Audit History</div>
            <div class="history-list">
                <?php if (empty($history)): ?>
                    <p style="text-align: center; font-size: 13px; color: #94a3b8; padding: 30px; font-weight: 600;">No transaction history available.</p>
                <?php else: ?>
                    <?php foreach ($history as $h): ?>
                        <div class="row">
                            <div>
                                <div style="font-weight:700;">💰 <?php echo number_format($h['amount']); ?> RWF</div>
                                <div style="font-size:10px; color:#94a3b8;"><?php echo htmlspecialchars($h['phone']); ?> • <?php echo $h['created_at']; ?></div>
                            </div>
                            <span class="status <?php echo strtolower($h['status']); ?>"><?php echo $h['status']; ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="side-menu" id="sideMenu">
        <div style="margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;">
            <div style="font-weight: 800; font-size: 20px;"><?php echo htmlspecialchars($userData['username']); ?></div>
            <div style="font-size: 11px; color: var(--success); font-weight: 800; margin-top: 5px; text-transform: uppercase;"><i class="fa-solid fa-circle-check"></i> Verified Member Account</div>
        </div>
        <nav>
            <a href="dashboard.php" class="menu-item"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="Withdraw_bonus.php" class="menu-item"><i class="fa-solid fa-plane-up"></i> Withdraw Bonus</a>
            <a href="Withdraw_Task_Balance.php" class="menu-item active"><i class="fa-solid fa-plane-up"></i> Withdraw Task Balance</a>
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