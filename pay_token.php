<?php
require_once 'db.php';
if (!isset($_SESSION['current_user'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['current_user'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && $user['hasPaidToken']) {
    header("Location: dashboard.php");
    exit;
}

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pay_phone = trim($_POST['pay_phone'] ?? '');
    if (!empty($pay_phone)) {
        // Insert or record payment into withdrawal_tokens table so admin sees it on withdraw token page
        try {
            $stmtCheck = $pdo->prepare("SELECT id FROM withdrawal_tokens WHERE username = ? AND status = 'Pending'");
            $stmtCheck->execute([$username]);
            if (!$stmtCheck->fetch()) {
                $stmtInsert = $pdo->prepare("INSERT INTO withdrawal_tokens (username, phone, amount, status) VALUES (?, ?, 4000, 'Pending')");
                $stmtInsert->execute([$username, $pay_phone]);
            }
        } catch (Exception $e) {
            // Fallback if table needs inline logging
        }
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="rw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Token Payment | PESA AFRICA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-blue: #2563eb; --accent-gold: #d97706; --black: #111111; --white: #ffffff; --gray: #f8fafc; --border: #e2e8f0; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Inter", Arial, sans-serif; }
        body { background: #f4f2ed; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .card { background: var(--white); width: 100%; max-width: 440px; border-radius: 20px; padding: 35px 28px; box-shadow: 0 24px 55px -18px rgba(0,0,0,0.2); text-align: center; border: 1px solid rgba(0,0,0,0.04); }
        .logo-img { height: 48px; width: auto; margin-bottom: 12px; }
        .token-badge { display: inline-flex; align-items: center; justify-content: center; background: #eff6ff; color: var(--primary-blue); font-weight: 900; padding: 8px 18px; border-radius: 50px; font-size: 13px; margin-bottom: 15px; gap: 8px; border: 1px solid #bfdbfe; }
        h2 { font-size: 20px; font-weight: 800; color: var(--black); margin-bottom: 6px; }
        p { font-size: 12px; color: #6b7280; line-height: 1.5; margin-bottom: 20px; }
        .info-box { background: var(--gray); border: 1.5px dashed var(--border); border-radius: 14px; padding: 16px; margin-bottom: 20px; text-align: left; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; font-weight: 600; }
        .info-row span:last-child { color: var(--black); font-weight: 800; }
        .ussd-box { background: #eff6ff; border: 1.5px solid #bfdbfe; padding: 12px 16px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .ussd-code { font-weight: 800; color: #1e40af; font-size: 15px; letter-spacing: 0.5px; }
        .copy-btn { background: var(--primary-blue); color: white; border: none; padding: 8px 14px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: 0.2s; }
        .copy-btn:hover { background: #1d4ed8; }
        .form-group { margin-bottom: 16px; text-align: left; }
        .label { display: block; font-size: 10px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; color: #374151; }
        .input-field { width: 100%; padding: 14px; background: #fafafa; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; outline: none; }
        .input-field:focus { border-color: var(--primary-blue); background: #fff; }
        .submit-btn { width: 100%; padding: 15px; background: var(--primary-blue); color: var(--white); border: none; border-radius: 11px; font-size: 14px; font-weight: 900; text-transform: uppercase; cursor: pointer; box-shadow: 0 4px 12px rgba(37,99,235,0.3); transition: 0.2s; }
        .submit-btn:hover { background: #1d4ed8; }
        .pending-card { background: #eff6ff; border: 1px solid #bfdbfe; padding: 22px; border-radius: 14px; margin-top: 15px; text-align: center; }
        .btn-outline { display: block; width: 100%; padding: 12px; background: white; color: var(--black); border: 1.5px solid var(--black); border-radius: 10px; font-weight: 800; text-decoration: none; margin-top: 15px; font-size: 12px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="card">
        <img src="assets/logo.png" alt="Pesa Africa Logo" class="logo-img" onerror="this.style.display='none'">
        
        <div class="token-badge">
            <i class="fa-solid fa-shield-halved"></i> Withdrawal Token Authorization
        </div>
        
        <h2>Wishyura Token yo Kubikuza</h2>
        <p>Kugirango ubashe kubikuza amafaranga yawe kuri konti, banza wishyure amafaranga y'ifatabuguriro rya Token.</p>

        <?php if ($success): ?>
            <div class="pending-card">
                <div style="font-size: 32px; color: var(--primary-blue); margin-bottom: 10px;"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 6px; color: #1e3a8a;">Ubusabe Bwawe Bwakiriwe!</h3>
                <p style="font-size: 12px; color: #1e40af; margin-bottom: 0;">
                    Ubwishyu bwawe burimo gusuzumwa na Admin. Token yawe izemezwa vuba cyane kugira ngo ubashe kubikuza amafaranga yawe kuri Dashboard.
                </p>
            </div>
            <a href="dashboard.php" class="btn-outline"><i class="fa-solid fa-arrow-left"></i> Subira kuri Dashboard</a>
        <?php else: ?>
            <div class="info-box">
                <div class="info-row"><span>Amafaranga:</span><span>4,000 RWF</span></div>
                <div class="info-row"><span>MoMo Code:</span><span>2265430</span></div>
                <div class="info-row"><span>Amazina:</span><span>Callixte</span></div>
            </div>

            <div class="ussd-box">
                <span class="ussd-code" id="ussdText">*182*8*1*2265430#</span>
                <button type="button" class="copy-btn" id="copyBtn" onclick="copyUSSD()"><i class="fa-solid fa-copy"></i> Koporora</button>
            </div>

            <form method="POST">
                <div class="form-group">
                    <label class="label">NIMERO WISHYURIJEHO (MOMO PHONE)</label>
                    <input type="tel" name="pay_phone" class="input-field" placeholder="0780000000" maxlength="10" required>
                </div>
                <button type="submit" class="submit-btn"><i class="fa-solid fa-circle-check"></i> NISHYURYE (I HAVE PAID)</button>
            </form>
            <a href="dashboard.php" class="btn-outline" style="margin-top: 15px; border: none; color: #6b7280; background: transparent;"><i class="fa-solid fa-arrow-left"></i> Subira Inyuma</a>
        <?php endif; ?>
    </div>

    <script>
        function copyUSSD() {
            const text = document.getElementById("ussdText").innerText;
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById("copyBtn");
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Byabitswe!';
                btn.style.background = '#10b981';
                setTimeout(() => {
                    btn.innerHTML = '<i class="fa-solid fa-copy"></i> Koporora';
                    btn.style.background = '#2563eb';
                }, 2000);
            });
        }
    </script>
</body>
</html>