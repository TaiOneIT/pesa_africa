<?php
require_once 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR mobile = ?");
    $stmt->execute([$username, $mobile]);
    
    if ($stmt->rowCount() > 0) {
        $error = "Iyi konti cyangwa nimero isanzwe yanditse!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO users (username, mobile, password, isActivated, status) VALUES (?, ?, ?, 0, 'active')");
        if ($insert->execute([$username, $mobile, $hashedPassword])) {
            $_SESSION['current_user'] = $username;
            header("Location: pay_activation.php");
            exit;
        } else {
            $error = "Habaye ikibazo, yongera ugerageze.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="rw">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PESA AFRICA - Kwiyandikisha</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root { --black: #111111; --gold: #c9a227; --white: #ffffff; --red: #b42318; --green: #1f7a4d; --border: #e5e5e5; }
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Inter", Arial, sans-serif; }
    body { min-height: 100vh; background: #f4f2ed; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px; }
    .card { background: var(--white); width: 100%; max-width: 440px; border-radius: 20px; padding: 40px 28px; box-shadow: 0 24px 55px -18px rgba(0, 0, 0, 0.28); border: 1px solid rgba(0, 0, 0, 0.04); text-align: center; }
    .logo-img { height: 45px; width: auto; margin-bottom: 15px; }
    .heading { font-size: 22px; font-weight: 800; color: var(--black); margin-bottom: 6px; }
    .subheading { font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 24px; }
    .error-alert { background: #fff5f4; border: 1px solid #f0c4bf; color: var(--red); padding: 12px; border-radius: 10px; font-size: 13px; margin-bottom: 15px; text-align: left; }
    .form-group { margin-bottom: 18px; text-align: left; }
    .label { display: flex; align-items: center; gap: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; }
    .input-field { width: 100%; padding: 14px; background: #fafafa; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; outline: none; }
    .input-field:focus { border-color: var(--gold); background: #fff; }
    .submit-btn { width: 100%; padding: 15px; background: var(--black); color: #fff; border: none; border-radius: 11px; font-size: 14px; font-weight: 800; text-transform: uppercase; cursor: pointer; margin-top: 5px; }
    .footer-text { font-size: 13px; color: #6b7280; margin-top: 22px; }
    .footer-text a { color: var(--black); text-decoration: none; font-weight: 800; border-bottom: 2px solid var(--gold); }
  </style>
</head>
<body>
  <div class="card">
    <img src="assets/logo.png" alt="Pesa Africa Logo" class="logo-img" onerror="this.style.display='none'">
    <h2 class="heading">IYANDIKISHE NAWE</h2>
    <p class="subheading">INZIRA YO KWINJIZA AMAFARANGA</p>

    <?php if(!empty($error)): ?>
      <div class="error-alert"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label class="label"><i class="fa-solid fa-user"></i> AMAZINA YAWE</label>
        <input type="text" name="username" class="input-field" placeholder="Amazina Yawe" required>
      </div>
      <div class="form-group">
        <label class="label"><i class="fa-solid fa-phone"></i> NIMERO YA TELEFONE</label>
        <input type="tel" name="mobile" class="input-field" placeholder="0780000000" maxlength="10" required>
      </div>
      <div class="form-group">
        <label class="label"><i class="fa-solid fa-lock"></i> PASSWORD</label>
        <input type="password" name="password" class="input-field" placeholder="Password" required>
      </div>
      <button type="submit" class="submit-btn"><i class="fa-solid fa-user-plus"></i> KORA KONTI HANO</button>
    </form>

    <p class="footer-text">Usanzwe Ufite Konti? <a href="login.php">Injira Hano</a></p>
  </div>
</body>
</html>