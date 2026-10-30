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

if ($user && $user['isActivated']) {
    header("Location: dashboard.php");
    exit;
}

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pay_phone = trim($_POST['pay_phone'] ?? '');
    if (!empty($pay_phone)) {
        // Insert or record payment into activation_fees table so admin sees it in the activation fees page
        try {
            $stmtCheck = $pdo->prepare("SELECT id FROM activation_fees WHERE username = ? AND status = 'Pending'");
            $stmtCheck->execute([$username]);
            if (!$stmtCheck->fetch()) {
                $stmtInsert = $pdo->prepare("INSERT INTO activation_fees (username, phone, amount, status) VALUES (?, ?, 5000, 'Pending')");
                $stmtInsert->execute([$username, $pay_phone]);
            }
        } catch (Exception $e) {
            // Fallback if table structure needs inline logging
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
    <title>Activation Payment | PESA AFRICA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --mtn-yellow: #ffcc00; --black: #111111; --white: #ffffff; --gray: #f9fafb; --border: #e5e7eb; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Inter", Arial, sans-serif; }
        body { background: #f4f2ed; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .card { background: var(--white); width: 100%; max-width: 440px; border-radius: 20px; padding: 35px 28px; box-shadow: 0 24px 55px -18px rgba(0,0,0,0.2); text-align: center; border: 1px solid rgba(0,0,0,0.04); }
        .logo-img { height: 48px; width: auto; margin-bottom: 12px; }
        .mtn-badge { display: inline-flex; align-items: center; justify-content: center; background: var(--mtn-yellow); color: var(--black); font-weight: 900; padding: 8px 18px; border-radius: 50px; font-size: 13px; margin-bottom: 15px; gap: 8px; box-shadow: 0 4px 12px rgba(255,204,0,0.3); }
        h2 { font-size: 20px; font-weight: 800; color: var(--black); margin-bottom: 6px; }
        p { font-size: 12px; color: #6b7280; line-height: 1.5; margin-bottom: 20px; }
        .info-box { background: var(--gray); border: 1.5px dashed var(--border); border-radius: 14px; padding: 16px; margin-bottom: 20px; text-align: left; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; font-weight: 600; }
        .info-row span:last-child { color: var(--black); font-weight: 800; }
        .ussd-box { background: #fffbec; border: 1.5px solid #fef08a; padding: 12px 16px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .ussd-code { font-weight: 800; color: #854d0e; font-size: 15px; letter-spacing: 0.5px; }
        .copy-btn { background: var(--black); color: white; border: none; padding: 8px 14px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: 0.2s; }
        .copy-btn:hover { background: #333; }
        .form-group { margin-bottom: 16px; text-align: left; }
        .label { display: block; font-size: 10px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; color: #374151; }
        .input-field { width: 100%; padding: 14px; background: #fafafa; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; outline: none; }
        .input-field:focus { border-color: var(--mtn-yellow); background: #fff; }
        .submit-btn { width: 100%; padding: 15px; background: var(--mtn-yellow); color: var(--black); border: none; border-radius: 11px; font-size: 14px; font-weight: 900; text-transform: uppercase; cursor: pointer; box-shadow: 0 4px 12px rgba(255,204,0,0.3); transition: 0.2s; }
        .submit-btn:hover { background: #facc15; }
        .pending-card { background: #fffbeb; border: 1px solid #fde047; padding: 22px; border-radius: 14px; margin-top: 15px; text-align: center; }
        .btn-outline { display: block; width: 100%; padding: 12px; background: white; color: var(--black); border: 1.5px solid var(--black); border-radius: 10px; font-weight: 800; text-decoration: none; margin-top: 15px; font-size: 12px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="card">
        <img src="assets/logo.png" alt="Pesa Africa Logo" class="logo-img" onerror="this.style.display='none'">
        
        <div class="mtn-badge">
            <i class="fa-solid fa-mobile-screen-button"></i> MTN MoMo Activation
        </div>
        
        <h2>Fungura Konti Yawe</h2>
        <p>Kugirango utangire gukoresha Pesa Africa, banza wishyure amafaranga y'ifatabuguriro ry'ingenzi.</p>

        <?php if ($success): ?>
            <div class="pending-card">
                <div style="font-size: 32px; color: #ca8a04; margin-bottom: 10px;"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 6px;">Ubusabe Bwawe Bwakiriwe!</h3>
                <p style="font-size: 12px; color: #713f12; margin-bottom: 0;">
                    Turasuzuma ubwishyu bwawe ako kanya. Nyuma y'akanya gato, Admin araba yemeje konti yawe maze uhite winjira kuri Dashboard. Murakoze kwihangana!
                </p>
            </div>
            <a href="login.php" class="btn-outline"><i class="fa-solid fa-arrow-left"></i> Subira kuri Login</a>
        <?php else: ?>
            <div class="info-box">
                <div class="info-row"><span>Amafaranga:</span><span>5,000 RWF</span></div>
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
            <a href="login.php" class="btn-outline" style="margin-top: 15px; border: none; color: #6b7280; background: transparent;"><i class="fa-solid fa-arrow-left"></i> Subira Inyuma</a>
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
                    btn.style.background = '#111111';
                }, 2000);
            });
        }
    </script>
</body>
</html>