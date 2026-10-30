<?php
require_once 'db.php';
$login_error = '';
$register_error = '';
$active_tab = 'login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
        $active_tab = 'login';
        $mobile = trim($_POST['mobile'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Check for Admin login credentials
        if (($mobile === '0782008066' || $mobile === 'Mukarugira') && $password === '121212') {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['current_user'] = 'Mukarugira';
            header("Location: admin.php");
            exit;
        }

        // Regular user login check
        $stmt = $pdo->prepare("SELECT * FROM users WHERE mobile = ? OR username = ?");
        $stmt->execute([$mobile, $mobile]);
        $user = $stmt->fetch();

        if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
            if ($user['status'] === 'inactive') {
                $login_error = "Konti yawe yahagaritswe n'umuyobozi.";
            } else {
                $_SESSION['current_user'] = $user['username'];
                if (!$user['isActivated']) {
                    header("Location: pay_activation.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit;
            }
        } else {
            $login_error = "Nimero cyangwa ijambo ry'ibanga si byo!";
        }
    } elseif ($action === 'register') {
        $active_tab = 'register';
        $username = trim($_POST['username'] ?? '');
        $mobile = trim($_POST['mobile'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $stmt = $pdo->prepare("SELECT id FROM users WHERE mobile = ?");
        $stmt->execute([$mobile]);

        if ($stmt->rowCount() > 0) {
            $register_error = "Iyi nimero ya telefoni isanzwe yanditse!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO users (username, mobile, password, isActivated, status) VALUES (?, ?, ?, 0, 'active')");
            if ($insert->execute([$username, $mobile, $hashedPassword])) {
                $_SESSION['current_user'] = $username;
                header("Location: pay_activation.php");
                exit;
            } else {
                $register_error = "Habaye ikibazo, yongera ugerageze.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="rw">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PESA AFRICA - Injira / Kwiyandikisha</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root { --black: #111111; --gold: #c9a227; --white: #ffffff; --red: #b42318; --green: #1f7a4d; --border: #e5e5e5; }
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Inter", Arial, sans-serif; }
    body { min-height: 100vh; background: #f4f2ed; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px; }
    .card { background: var(--white); width: 100%; max-width: 440px; border-radius: 20px; padding: 35px 28px; box-shadow: 0 24px 55px -18px rgba(0, 0, 0, 0.28); border: 1px solid rgba(0, 0, 0, 0.04); text-align: center; }
    .logo-img { height: 48px; width: auto; margin-bottom: 12px; }
    .tab-container { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; background: #f1f1ef; padding: 5px; border-radius: 12px; margin-bottom: 24px; }
    .tab-btn { padding: 12px; border: none; background: transparent; font-size: 12px; font-weight: 800; color: #6b7280; border-radius: 9px; cursor: pointer; transition: 0.2s; text-transform: uppercase; }
    .tab-btn.active { background: var(--black); color: var(--white); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .form-section { display: none; text-align: left; }
    .form-section.active { display: block; }
    .heading { font-size: 20px; font-weight: 800; color: var(--black); margin-bottom: 4px; }
    .subheading { font-size: 11px; font-weight: 600; color: #6b7280; text-transform: uppercase; margin-bottom: 20px; }
    .error-alert { background: #fff5f4; border: 1px solid #f0c4bf; color: var(--red); padding: 12px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 18px; }
    .form-group { margin-bottom: 16px; }
    .label { display: flex; align-items: center; gap: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; }
    .input-field { width: 100%; padding: 14px 16px; background: #fafafa; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; outline: none; }
    .input-field:focus { border-color: var(--gold); background: #ffffff; }
    .password-wrapper { position: relative; width: 100%; }
    .toggle-password { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; cursor: pointer; }
    .submit-btn { width: 100%; padding: 15px; background: var(--black); color: #ffffff; border: none; border-radius: 11px; font-size: 14px; font-weight: 800; text-transform: uppercase; cursor: pointer; margin-top: 6px; }
    .submit-btn:hover { background: #222; }
  </style>
</head>
<body>
  <div class="card">
    <img src="assets/logo.png" alt="Pesa Africa Logo" class="logo-img" onerror="this.style.display='none'">
    
    <!-- Tab Navigation Buttons -->
    <div class="tab-container">
      <button type="button" class="tab-btn <?php echo $active_tab === 'login' ? 'active' : ''; ?>" onclick="switchTab('login')">Kwinjira</button>
      <button type="button" class="tab-btn <?php echo $active_tab === 'register' ? 'active' : ''; ?>" onclick="switchTab('register')">Kwiyandikisha</button>
    </div>

    <!-- LOGIN FORM -->
    <div id="loginSection" class="form-section <?php echo $active_tab === 'login' ? 'active' : ''; ?>">
      <h2 class="heading">Murakaza Neza!</h2>
      <p class="subheading">Injira muri konti yawe ukoresheje nimero</p>

      <?php if(!empty($login_error)): ?>
        <div class="error-alert"><i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($login_error); ?></div>
      <?php endif; ?>

      <form method="POST">
        <input type="hidden" name="action" value="login">
        <div class="form-group">
          <label class="label"><i class="fa-solid fa-phone"></i> NIMERO YA TELEFONE</label>
          <input type="text" name="mobile" class="input-field" placeholder="0782008066" required>
        </div>
        <div class="form-group">
          <label class="label"><i class="fa-solid fa-lock"></i> IJAMBO RY'IBANGA</label>
          <div class="password-wrapper">
            <input type="password" name="password" id="loginPassword" class="input-field" placeholder="••••••••" required>
            <i class="fa-solid fa-eye toggle-password" onclick="togglePass('loginPassword', this)"></i>
          </div>
        </div>
        <button type="submit" class="submit-btn"><i class="fa-solid fa-right-to-bracket"></i> INJIRA MURI KONTI</button>
      </form>
    </div>

    <!-- REGISTER FORM -->
    <div id="registerSection" class="form-section <?php echo $active_tab === 'register' ? 'active' : ''; ?>">
      <h2 class="heading">Kora Konti Nshya</h2>
      <p class="subheading">Tangira urugendo rwo kwinjiza amafaranga</p>

      <?php if(!empty($register_error)): ?>
        <div class="error-alert"><i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($register_error); ?></div>
      <?php endif; ?>

      <form method="POST">
        <input type="hidden" name="action" value="register">
        <div class="form-group">
          <label class="label"><i class="fa-solid fa-user"></i> AMAZINA YAWE</label>
          <input type="text" name="username" class="input-field" placeholder="Andika Amazina Yawe" required>
        </div>
        <div class="form-group">
          <label class="label"><i class="fa-solid fa-phone"></i> NIMERO YA TELEFONE</label>
          <input type="tel" name="mobile" class="input-field" placeholder="0780000000" maxlength="10" required>
        </div>
        <div class="form-group">
          <label class="label"><i class="fa-solid fa-lock"></i> PASSWORD</label>
          <div class="password-wrapper">
            <input type="password" name="password" id="regPassword" class="input-field" placeholder="Password" required>
            <i class="fa-solid fa-eye toggle-password" onclick="togglePass('regPassword', this)"></i>
          </div>
        </div>
        <button type="submit" class="submit-btn"><i class="fa-solid fa-user-plus"></i> KORA KONTI HANO</button>
      </form>
    </div>
  </div>

  <script>
    function switchTab(tab) {
      document.getElementById('loginSection').classList.remove('active');
      document.getElementById('registerSection').classList.remove('active');
      document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

      if (tab === 'login') {
        document.getElementById('loginSection').classList.add('active');
        document.querySelectorAll('.tab-btn')[0].classList.add('active');
      } else {
        document.getElementById('registerSection').classList.add('active');
        document.querySelectorAll('.tab-btn')[1].classList.add('active');
      }
    }

    function togglePass(id, el) {
      const input = document.getElementById(id);
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
      el.classList.toggle('fa-eye');
      el.classList.toggle('fa-eye-slash');
    }
  </script>
</body>
</html>