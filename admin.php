<?php
require_once 'db.php';

// Admin Login Check via Phone Number (0782008066) or Username (Mukarugira)
if (!isset($_SESSION['admin_logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $identity = trim($_POST['identity'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (($identity === '0782008066' || $identity === 'Mukarugira') && $password === '121212') {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin.php");
            exit;
        } else {
            $error = "Invalid Admin Credentials!";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login | Pesa Africa</title>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary: #0f172a;
                --accent: #2563eb;
                --success: #16a34a;
                --bg: #f8fafc;
                --card-bg: #ffffff;
                --text-main: #1e293b;
                --text-muted: #64748b;
                --border: #e2e8f0;
            }
            body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--primary); color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
            .login-card { background: var(--card-bg); color: var(--text-main); padding: 45px 35px; border-radius: 24px; width: 100%; max-width: 400px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1); text-align: center; }
            .logo-img { height: 50px; width: auto; margin-bottom: 20px; }
            h2 { margin-bottom: 8px; font-size: 22px; font-weight: 800; color: var(--primary); }
            p { color: var(--text-muted); font-size: 13px; margin-bottom: 30px; font-weight: 500; }
            .input-group { text-align: left; margin-bottom: 20px; }
            .input-group label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; letter-spacing: 0.5px; }
            input { width: 100%; padding: 15px; border-radius: 12px; border: 2px solid var(--border); background: var(--bg); color: var(--text-main); font-size: 14px; font-weight: 600; box-sizing: border-box; outline: none; transition: 0.2s; }
            input:focus { border-color: var(--accent); background: white; }
            button { width: 100%; padding: 16px; background: var(--primary); color: white; border: none; border-radius: 12px; font-weight: 800; font-size: 15px; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 12px rgba(15,23,42,0.2); }
            button:hover { background: #1e293b; }
            .error { color: #dc2626; font-size: 13px; margin-bottom: 20px; font-weight: 700; background: #fee2e2; padding: 10px; border-radius: 8px; }
        </style>
    </head>
    <body>
        <div class="login-card">
            <img src="assets/logo.png" alt="Pesa Africa Logo" class="logo-img" onerror="this.style.display='none'">
            <h2>Admin Terminal</h2>
            <p>Secure Executive Sign In</p>
            <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
            <form method="POST">
                <div class="input-group">
                    <label>Phone or Username</label>
                    <input type="text" name="identity" placeholder="e.g. 0782008066" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit">Authenticate & Enter</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Handle Logout
if (isset($_GET['logout'])) {
    unset($_SESSION['admin_logged_in']);
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Handle Admin Actions & Redirection back to appropriate section tab & subpage
$section = isset($_GET['section']) ? $_GET['section'] : '';
$subpage = isset($_GET['subpage']) ? $_GET['subpage'] : 'page1';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $redirect_section = '';
    $redirect_subpage = $subpage;

    if ($action === 'activate' && $id) {
        $pdo->prepare("UPDATE users SET isActivated = 1 WHERE id = ?")->execute([$id]);
        $redirect_section = 'users';
        $redirect_subpage = 'page1';
    } elseif ($action === 'inactivate' && $id) {
        $pdo->prepare("UPDATE users SET isActivated = 0 WHERE id = ?")->execute([$id]);
        $redirect_section = 'users';
        $redirect_subpage = 'page1';
    } elseif ($action === 'approve_token' && $id) {
        $pdo->prepare("UPDATE users SET hasPaidToken = 1 WHERE id = ?")->execute([$id]);
        $redirect_section = 'users';
        $redirect_subpage = 'page2';
    } elseif ($action === 'suspend' && $id) {
        $pdo->prepare("UPDATE users SET status = 'inactive' WHERE id = ?")->execute([$id]);
        $redirect_section = 'users';
        $redirect_subpage = 'page2';
    } elseif ($action === 'unsuspend' && $id) {
        $pdo->prepare("UPDATE users SET status = 'active' WHERE id = ?")->execute([$id]);
        $redirect_section = 'users';
        $redirect_subpage = 'page2';
    } elseif ($action === 'delete_user' && $id) {
        $pdo->prepare("DELETE FROM users WHERE id = ? AND username != 'Mukarugira'")->execute([$id]);
        $redirect_section = 'users';
        $redirect_subpage = 'page1';
    } elseif ($action === 'approve_withdrawal' && $id) {
        $pdo->prepare("UPDATE withdrawals SET status = 'Approved' WHERE id = ?")->execute([$id]);
        $redirect_section = 'withdraws';
    } elseif ($action === 'deny_withdrawal' && $id) {
        $pdo->prepare("UPDATE withdrawals SET status = 'Rejected' WHERE id = ?")->execute([$id]);
        $redirect_section = 'withdraws';
    } elseif ($action === 'delete_withdrawal' && $id) {
        $pdo->prepare("DELETE FROM withdrawals WHERE id = ?")->execute([$id]);
        $redirect_section = 'withdraws';
    } elseif ($action === 'approve_activation' && $id) {
        // Approve activation fee: update record status and activate associated user account
        $actStmt = $pdo->prepare("SELECT username FROM activation_fees WHERE id = ?");
        $actStmt->execute([$id]);
        $actRecord = $actStmt->fetch();
        if ($actRecord) {
            $pdo->prepare("UPDATE users SET isActivated = 1 WHERE username = ?")->execute([$actRecord['username']]);
        }
        $pdo->prepare("UPDATE activation_fees SET status = 'Approved' WHERE id = ?")->execute([$id]);
        $redirect_section = 'activations';
    } elseif ($action === 'delete_activation' && $id) {
        $pdo->prepare("DELETE FROM activation_fees WHERE id = ?")->execute([$id]);
        $redirect_section = 'activations';
    } elseif ($action === 'delete_all_activations') {
        $pdo->prepare("DELETE FROM activation_fees")->execute();
        $redirect_section = 'activations';
    } elseif ($action === 'approve_token_payment' && $id) {
        // Approve withdraw token payment: update record status and grant user token privilege
        $tokStmt = $pdo->prepare("SELECT username FROM withdrawal_tokens WHERE id = ?");
        $tokStmt->execute([$id]);
        $tokRecord = $tokStmt->fetch();
        if ($tokRecord) {
            $pdo->prepare("UPDATE users SET hasPaidToken = 1 WHERE username = ?")->execute([$tokRecord['username']]);
        }
        $pdo->prepare("UPDATE withdrawal_tokens SET status = 'Approved' WHERE id = ?")->execute([$id]);
        $redirect_section = 'tokens';
    } elseif ($action === 'delete_token' && $id) {
        $pdo->prepare("DELETE FROM withdrawal_tokens WHERE id = ?")->execute([$id]);
        $redirect_section = 'tokens';
    } elseif ($action === 'delete_all_tokens') {
        $pdo->prepare("DELETE FROM withdrawal_tokens")->execute();
        $redirect_section = 'tokens';
    } elseif ($action === 'change_password' && isset($_POST['user_id'], $_POST['new_password'])) {
        $uid = intval($_POST['user_id']);
        $new_pass = trim($_POST['new_password']);
        if (!empty($new_pass)) {
            $pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$new_pass, $uid]);
        }
        $redirect_section = 'users';
        $redirect_subpage = 'page2';
    }
    
    $query_string = "?section=$redirect_section" . ($redirect_section === 'users' ? "&subpage=$redirect_subpage" : "");
    header("Location: admin.php" . $query_string);
    exit;
}

// Fetch Pending Counts & Data Records
$pendingActivationsCount = $pdo->query("SELECT COUNT(*) FROM activation_fees WHERE status = 'Pending'")->fetchColumn();
$pendingTokensCount = $pdo->query("SELECT COUNT(*) FROM withdrawal_tokens WHERE status = 'Pending'")->fetchColumn();
$pendingWithdrawalsCount = $pdo->query("SELECT COUNT(*) FROM withdrawals WHERE status = 'Pending'")->fetchColumn();
$totalUsersCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesa Africa | Executive Admin Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0f172a;
            --success: #16a34a;
            --danger: #dc2626;
            --warning: #d97706;
            --info: #2563eb;
            --bg: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); margin: 0; color: var(--text-main); }
        
        /* Classic Header */
        .header { background: var(--primary); color: white; padding: 18px 35px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 20px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 1000; }
        .header-brand { display: flex; align-items: center; gap: 14px; text-decoration: none; color: white; }
        .header-brand img { height: 38px; width: auto; }
        .header-brand h2 { font-size: 17px; margin: 0; font-weight: 800; letter-spacing: -0.3px; }
        .btn-logout { background: rgba(220, 38, 38, 0.15); color: #fca5a5; padding: 8px 16px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 13px; border: 1px solid rgba(220,38,38,0.3); transition: 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .btn-logout:hover { background: var(--danger); color: white; }

        .container { padding: 35px; max-width: 1400px; margin: 0 auto; }
        
        /* Stats Summary Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--white); padding: 22px 26px; border-radius: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid var(--border); border-left: 5px solid var(--info); }
        .stat-card.warning { border-left-color: var(--warning); }
        .stat-card.danger { border-left-color: var(--danger); }
        .stat-card h3 { font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin: 0 0 8px 0; font-weight: 800; letter-spacing: 0.5px; }
        .stat-card span { font-size: 30px; font-weight: 800; color: var(--primary); letter-spacing: -0.5px; }

        /* Spacious Official Section Navigation Buttons Bar */
        .nav-sections-bar { display: flex; gap: 15px; margin-bottom: 35px; flex-wrap: wrap; background: var(--white); padding: 20px; border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .nav-section-link { padding: 14px 24px; background: #f1f5f9; color: var(--text-muted); text-decoration: none; font-weight: 700; font-size: 13px; border-radius: 12px; transition: 0.2s; display: inline-flex; align-items: center; gap: 10px; border: 1px solid #e2e8f0; }
        .nav-section-link:hover { background: #e2e8f0; color: var(--primary); transform: translateY(-1px); }
        .nav-section-link.active { background: var(--primary); color: white; border-color: var(--primary); box-shadow: 0 4px 12px rgba(15,23,42,0.2); }

        /* Subpages Navigation Bar for Registered Users */
        .subpage-tabs-bar { display: flex; gap: 10px; margin-bottom: 20px; }
        .subpage-tab { padding: 10px 20px; background: #e2e8f0; color: var(--text-muted); text-decoration: none; font-weight: 800; font-size: 12px; border-radius: 10px; transition: 0.2s; text-transform: uppercase; }
        .subpage-tab.active { background: var(--info); color: white; box-shadow: 0 4px 12px rgba(37,99,235,0.2); }

        /* Clean Section Box Container */
        .section-box { background: var(--white); border-radius: 20px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid var(--border); }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; border-bottom: 2px solid #f8fafc; padding-bottom: 15px; }
        .section-header h3 { margin: 0; font-size: 18px; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: 10px; }
        .search-box { padding: 12px 18px; border-radius: 12px; border: 2px solid var(--border); width: 280px; font-size: 13px; font-weight: 600; outline: none; transition: 0.2s; background: var(--bg); }
        .search-box:focus { border-color: var(--accent); background: white; }

        /* Professional Tables */
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #f1f5f9; white-space: nowrap; }
        th { background: #f8fafc; font-weight: 800; color: var(--text-muted); text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        
        .badge { padding: 6px 14px; border-radius: 50px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.3px; }
        .badge.active { background: #dcfce7; color: var(--success); }
        .badge.inactive { background: #fee2e2; color: var(--danger); }
        .badge.pending { background: #fef3c7; color: var(--warning); }

        .btn { padding: 7px 14px; border-radius: 9px; font-size: 11px; font-weight: 800; border: none; cursor: pointer; text-decoration: none; display: inline-block; margin: 2px; transition: 0.2s; letter-spacing: 0.3px; }
        .btn-green { background: var(--success); color: white; }
        .btn-green:hover { background: #15803d; }
        .btn-blue { background: var(--info); color: white; }
        .btn-blue:hover { background: #1d4ed8; }
        .btn-yellow { background: var(--warning); color: white; }
        .btn-yellow:hover { background: #b45309; }
        .btn-red { background: var(--danger); color: white; }
        .btn-red:hover { background: #b91c1c; }
        
        .pass-form { display: inline-flex; gap: 6px; margin-top: 4px; }
        .pass-input { padding: 6px 10px; border-radius: 8px; border: 1px solid var(--border); font-size: 11px; width: 110px; font-weight: 600; outline: none; }
        .pass-input:focus { border-color: var(--info); }

        /* Classic Clean Landing View */
        .welcome-prompt { text-align: center; padding: 80px 20px; background: var(--white); border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .welcome-prompt i { font-size: 56px; color: var(--info); margin-bottom: 20px; opacity: 0.9; }
        .welcome-prompt h3 { font-size: 22px; color: var(--primary); margin-bottom: 10px; font-weight: 800; }
        .welcome-prompt p { color: var(--text-muted); font-size: 14px; margin: 0; font-weight: 500; }
    </style>
</head>
<body>
    <div class="header">
        <a href="admin.php" class="header-brand">
            <img src="assets/logo.png" alt="Logo" onerror="this.style.display='none'">
            <h2>Pesa Africa | Admin Terminal</h2>
        </a>
        <a href="admin.php?logout=1" class="btn-logout"><i class="fa-solid fa-power-off"></i> Secure Logout</a>
    </div>

    <div class="container">
        <!-- PENDING SUMMARY STATS CARDS -->
        <div class="stats-grid">
            <div class="stat-card warning">
                <h3>Pending Activation Fees</h3>
                <span><?php echo $pendingActivationsCount; ?></span>
            </div>
            <div class="stat-card warning">
                <h3>Pending Withdraw Tokens</h3>
                <span><?php echo $pendingTokensCount; ?></span>
            </div>
            <div class="stat-card danger">
                <h3>Pending Withdrawal Payouts</h3>
                <span><?php echo $pendingWithdrawalsCount; ?></span>
            </div>
            <div class="stat-card">
                <h3>Total Registered Users</h3>
                <span><?php echo $totalUsersCount; ?></span>
            </div>
        </div>

        <!-- SPACED OFFICIAL SECTION NAVIGATION BUTTONS -->
        <div class="nav-sections-bar">
            <a href="admin.php?section=users&subpage=page1" class="nav-section-link <?php echo ($section === 'users') ? 'active' : ''; ?>"><i class="fa-solid fa-users"></i> Registered Users</a>
            <a href="admin.php?section=withdraws" class="nav-section-link <?php echo ($section === 'withdraws') ? 'active' : ''; ?>"><i class="fa-solid fa-money-bill-transfer"></i> Withdraw Records</a>
            <a href="admin.php?section=activations" class="nav-section-link <?php echo ($section === 'activations') ? 'active' : ''; ?>"><i class="fa-solid fa-bolt"></i> Activation Fees</a>
            <a href="admin.php?section=tokens" class="nav-section-link <?php echo ($section === 'tokens') ? 'active' : ''; ?>"><i class="fa-solid fa-key"></i> Withdraw Tokens</a>
        </div>

        <?php if (empty($section)): ?>
            <!-- CLEAN DEFAULT LANDING SCREEN UPON LOGIN -->
            <div class="welcome-prompt">
                <i class="fa-solid fa-shield-halved"></i>
                <h3>Welcome to Pesa Africa Administration Portal</h3>
                <p>Please select one of the section navigation tabs above to manage accounts, review activations, or approve payouts.</p>
            </div>
        <?php else: ?>

            <?php if ($section === 'users'): 
                $allUsers = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
            ?>
            <!-- 1. REGISTERED USERS SECTION WITH 2 SUB-PAGES -->
            <div class="section-box">
                <div class="subpage-tabs-bar">
                    <a href="admin.php?section=users&subpage=page1" class="subpage-tab <?php echo ($subpage === 'page1') ? 'active' : ''; ?>"><i class="fa-solid fa-user-check"></i> Page One: Activate / Inactivate / Delete</a>
                    <a href="admin.php?section=users&subpage=page2" class="subpage-tab <?php echo ($subpage === 'page2') ? 'active' : ''; ?>"><i class="fa-solid fa-key"></i> Page Two: Update Password & Suspension</a>
                </div>

                <?php if ($subpage === 'page1'): ?>
                <!-- PAGE ONE: Activation, Inactivation & Deletion -->
                <div class="section-header">
                    <h3><i class="fa-solid fa-user-shield"></i> Registered Users - Page One (Activation & Deletion)</h3>
                    <input type="text" class="search-box" placeholder="Search by username or phone..." onkeyup="filterTable('usersTablePage1', this.value)">
                </div>
                <div style="overflow-x: auto;">
                    <table id="usersTablePage1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Task Bal</th>
                                <th>Bonus Bal</th>
                                <th>Activation Status</th>
                                <th>Actions (Activate / Inactivate / Delete)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allUsers as $u): ?>
                            <tr>
                                <td><?php echo $u['id']; ?></td>
                                <td><strong>@<?php echo htmlspecialchars($u['username']); ?></strong></td>
                                <td><?php echo htmlspecialchars($u['mobile']); ?></td>
                                <td><?php echo number_format($u['task_balance'] ?? 0); ?> RWF</td>
                                <td><?php echo number_format($u['bonus_balance'] ?? 0); ?> RWF</td>
                                <td>
                                    <?php if($u['isActivated']): ?>
                                        <span class="badge active">Activated</span>
                                    <?php else: ?>
                                        <span class="badge inactive">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(!$u['isActivated']): ?>
                                        <a href="admin.php?section=users&subpage=page1&action=activate&id=<?php echo $u['id']; ?>" class="btn btn-green">Activate</a>
                                    <?php else: ?>
                                        <a href="admin.php?section=users&subpage=page1&action=inactivate&id=<?php echo $u['id']; ?>" class="btn btn-yellow">Inactivate</a>
                                    <?php endif; ?>

                                    <?php if($u['username'] !== 'Mukarugira'): ?>
                                        <a href="admin.php?section=users&subpage=page1&action=delete_user&id=<?php echo $u['id']; ?>" class="btn btn-red" onclick="return confirm('Permanently delete user?')">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <!-- PAGE TWO: Password Updates & Suspension / Token Approvals -->
                <div class="section-header">
                    <h3><i class="fa-solid fa-lock"></i> Registered Users - Page Two (Password Updates & Suspension)</h3>
                    <input type="text" class="search-box" placeholder="Search users..." onkeyup="filterTable('usersTablePage2', this.value)">
                </div>
                <div style="overflow-x: auto;">
                    <table id="usersTablePage2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Token Status</th>
                                <th>Account Status</th>
                                <th>Actions (Token / Suspend / Password Update)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allUsers as $u): ?>
                            <tr>
                                <td><?php echo $u['id']; ?></td>
                                <td><strong>@<?php echo htmlspecialchars($u['username']); ?></strong></td>
                                <td><?php echo htmlspecialchars($u['mobile']); ?></td>
                                <td>
                                    <?php if($u['hasPaidToken']): ?>
                                        <span class="badge active">Approved</span>
                                    <?php else: ?>
                                        <span class="badge inactive">Not Approved</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?php echo ($u['status'] ?? 'active') === 'active' ? 'active' : 'inactive'; ?>">
                                        <?php echo ucfirst($u['status'] ?? 'active'); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if(!$u['hasPaidToken']): ?>
                                        <a href="admin.php?section=users&subpage=page2&action=approve_token&id=<?php echo $u['id']; ?>" class="btn btn-blue">Approve Token</a>
                                    <?php endif; ?>

                                    <?php if(($u['status'] ?? 'active') === 'active'): ?>
                                        <a href="admin.php?section=users&subpage=page2&action=suspend&id=<?php echo $u['id']; ?>" class="btn btn-yellow">Suspend</a>
                                    <?php else: ?>
                                        <a href="admin.php?section=users&subpage=page2&action=unsuspend&id=<?php echo $u['id']; ?>" class="btn btn-green">Unsuspend</a>
                                    <?php endif; ?>

                                    <!-- Inline Password Update Form -->
                                    <form action="admin.php?section=users&subpage=page2&action=change_password" method="POST" class="pass-form">
                                        <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                        <input type="text" name="new_password" placeholder="New Password" class="pass-input" required>
                                        <button type="submit" class="btn btn-blue" style="padding:6px 10px;">Update</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($section === 'withdraws'): 
                $allWithdrawals = $pdo->query("SELECT * FROM withdrawals ORDER BY id DESC")->fetchAll();
            ?>
            <!-- 2. WITHDRAWAL RECORDS SECTION -->
            <div class="section-box">
                <div class="section-header">
                    <h3><i class="fa-solid fa-money-bill-transfer"></i> Withdrawal Records & Payout Audit</h3>
                    <input type="text" class="search-box" placeholder="Search withdrawals..." onkeyup="filterTable('withdrawsTable', this.value)">
                </div>
                <div style="overflow-x: auto;">
                    <table id="withdrawsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Wallet Type</th>
                                <th>Amount</th>
                                <th>Phone Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allWithdrawals as $w): ?>
                            <tr>
                                <td><?php echo $w['id']; ?></td>
                                <td>@<?php echo htmlspecialchars($w['username']); ?></td>
                                <td><?php echo ucfirst($w['type']); ?></td>
                                <td><strong><?php echo number_format($w['amount']); ?> RWF</strong></td>
                                <td><?php echo htmlspecialchars($w['phone']); ?></td>
                                <td>
                                    <span class="badge <?php echo ($w['status'] === 'Approved') ? 'active' : (($w['status'] === 'Rejected') ? 'inactive' : 'pending'); ?>">
                                        <?php echo $w['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($w['status'] !== 'Approved'): ?>
                                        <a href="admin.php?section=withdraws&action=approve_withdrawal&id=<?php echo $w['id']; ?>" class="btn btn-green">Approve</a>
                                    <?php endif; ?>
                                    <?php if($w['status'] !== 'Rejected'): ?>
                                        <a href="admin.php?section=withdraws&action=deny_withdrawal&id=<?php echo $w['id']; ?>" class="btn btn-yellow">Deny</a>
                                    <?php endif; ?>
                                    <a href="admin.php?section=withdraws&action=delete_withdrawal&id=<?php echo $w['id']; ?>" class="btn btn-red" onclick="return confirm('Delete record?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($section === 'activations'): 
                $allActivations = $pdo->query("SELECT * FROM activation_fees ORDER BY id DESC")->fetchAll();
            ?>
            <!-- 3. ACTIVATION FEES SECTION WITH APPROVAL & DELETE -->
            <div class="section-box">
                <div class="section-header">
                    <h3><i class="fa-solid fa-bolt"></i> Activation Fees Verification Records</h3>
                    <div>
                        <input type="text" class="search-box" placeholder="Search activations..." onkeyup="filterTable('activationsTable', this.value)">
                        <a href="admin.php?section=activations&action=delete_all_activations" class="btn btn-red" onclick="return confirm('Delete all activation records?')">Delete All</a>
                    </div>
                </div>
                <div style="overflow-x: auto;">
                    <table id="activationsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Registered / Paid Number</th>
                                <th>Amount Paid</th>
                                <th>Status</th>
                                <th>Actions (Approve / Delete)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allActivations as $act): ?>
                            <tr>
                                <td><?php echo $act['id']; ?></td>
                                <td><strong>@<?php echo htmlspecialchars($act['username']); ?></strong></td>
                                <td><?php echo htmlspecialchars($act['phone']); ?></td>
                                <td><?php echo number_format($act['amount']); ?> RWF</td>
                                <td>
                                    <span class="badge <?php echo (($act['status'] ?? 'Pending') === 'Approved') ? 'active' : 'pending'; ?>">
                                        <?php echo htmlspecialchars($act['status'] ?? 'Pending'); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if(($act['status'] ?? 'Pending') !== 'Approved'): ?>
                                        <a href="admin.php?section=activations&action=approve_activation&id=<?php echo $act['id']; ?>" class="btn btn-green">Approve</a>
                                    <?php endif; ?>
                                    <a href="admin.php?section=activations&action=delete_activation&id=<?php echo $act['id']; ?>" class="btn btn-red" onclick="return confirm('Delete record?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($section === 'tokens'): 
                $allTokens = $pdo->query("SELECT * FROM withdrawal_tokens ORDER BY id DESC")->fetchAll();
            ?>
            <!-- 4. WITHDRAW TOKENS SECTION WITH APPROVAL & DELETE -->
            <div class="section-box">
                <div class="section-header">
                    <h3><i class="fa-solid fa-key"></i> Withdrawal Tokens Records</h3>
                    <div>
                        <input type="text" class="search-box" placeholder="Search tokens..." onkeyup="filterTable('tokensTable', this.value)">
                        <a href="admin.php?section=tokens&action=delete_all_tokens" class="btn btn-red" onclick="return confirm('Delete all token records?')">Delete All</a>
                    </div>
                </div>
                <div style="overflow-x: auto;">
                    <table id="tokensTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Registered / Paid Number</th>
                                <th>Amount Paid</th>
                                <th>Status</th>
                                <th>Actions (Approve / Delete)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allTokens as $tok): ?>
                            <tr>
                                <td><?php echo $tok['id']; ?></td>
                                <td><strong>@<?php echo htmlspecialchars($tok['username']); ?></strong></td>
                                <td><?php echo htmlspecialchars($tok['phone']); ?></td>
                                <td><?php echo number_format($tok['amount']); ?> RWF</td>
                                <td>
                                    <span class="badge <?php echo (($tok['status'] ?? 'Pending') === 'Approved') ? 'active' : 'pending'; ?>">
                                        <?php echo htmlspecialchars($tok['status'] ?? 'Pending'); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if(($tok['status'] ?? 'Pending') !== 'Approved'): ?>
                                        <a href="admin.php?section=tokens&action=approve_token_payment&id=<?php echo $tok['id']; ?>" class="btn btn-green">Approve</a>
                                    <?php endif; ?>
                                    <a href="admin.php?section=tokens&action=delete_token&id=<?php echo $tok['id']; ?>" class="btn btn-red" onclick="return confirm('Delete record?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

    <!-- Live Search Table Filtering Script -->
    <script>
        function filterTable(tableId, query) {
            const filter = query.toLowerCase();
            const table = document.getElementById(tableId);
            if (!table) return;
            const trs = table.querySelectorAll('tbody tr');
            trs.forEach(tr => {
                const text = tr.innerText.toLowerCase();
                tr.style.display = text.includes(filter) ? '' : 'none';
            });
        }
    </script>
</body>
</html>