<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ChatApp Dashboard</title>
    <!-- Font Awesome for icons -->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <style>
        /* ---------- RESET & BASE ---------- */
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
        background: #f0f2f5;
        display: flex;
        height: 100vh;
        }

        /* ---------- SIDEBAR ---------- */
        .sidebar {
        width: 240px;
        background: #1e293b;
        color: #e2e8f0;
        display: flex;
        flex-direction: column;
        padding: 24px 16px;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        }

        .sidebar .logo {
        font-size: 22px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 32px;
        letter-spacing: -0.5px;
        }

        .sidebar .logo i {
        color: #38bdf8;
        margin-right: 10px;
        }

        .sidebar nav a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 10px;
        color: #cbd5e1;
        text-decoration: none;
        font-weight: 500;
        transition: 0.2s;
        margin-bottom: 4px;
        }

        .sidebar nav a:hover {
        background: #334155;
        color: #ffffff;
        }

        .sidebar nav a.active {
        background: #3b82f6;
        color: #ffffff;
        }

        .sidebar nav a i {
        width: 20px;
        text-align: center;
        }

        .sidebar .user-info {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid #334155;
        display: flex;
        align-items: center;
        gap: 12px;
        }

        .sidebar .user-info .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #fff;
        }

        .sidebar .user-info .name {
        font-weight: 600;
        font-size: 14px;
        }

        .sidebar .user-info .role {
        font-size: 12px;
        color: #94a3b8;
        }

        /* ---------- MAIN CONTENT ---------- */
        .main {
        margin-left: 240px;
        flex: 1;
        padding: 28px 36px;
        overflow-y: auto;
        }

        /* header */
        .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        }

        .header h1 {
        font-size: 26px;
        font-weight: 700;
        color: #0f172a;
        }

        .header .actions {
        display: flex;
        gap: 16px;
        align-items: center;
        }

        .header .actions .notif {
        font-size: 20px;
        color: #475569;
        cursor: pointer;
        }

        .header .actions .btn {
        background: #3b82f6;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        font-size: 14px;
        }

        .header .actions .btn:hover {
        background: #2563eb;
        }

        /* ---------- STATS CARDS ---------- */
        .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
        }

        .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 22px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        border: 1px solid #e9edf2;
        }

        .stat-card .label {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        }

        .stat-card .value {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin: 6px 0 2px;
        }

        .stat-card .change {
        font-size: 13px;
        color: #22c55e;
        }

        .stat-card .change.down {
        color: #ef4444;
        }

        /* ---------- TWO COLUMN LAYOUT ---------- */
        .row {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 24px;
        }

        /* ---------- CARDS (common) ---------- */
        .card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px 22px;
        border: 1px solid #e9edf2;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .card h3 {
        font-size: 18px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        }

        .card h3 a {
        font-size: 13px;
        font-weight: 500;
        color: #3b82f6;
        text-decoration: none;
        }

        /* ---------- TEAM LIST ---------- */
        .team-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        }

        .team-item:last-child {
        border-bottom: none;
        }

        .team-item .icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        }

        .team-item .info {
        flex: 1;
        }

        .team-item .info .name {
        font-weight: 600;
        color: #0f172a;
        }

        .team-item .info .members {
        font-size: 13px;
        color: #64748b;
        }

        .team-item .badge {
        font-size: 12px;
        background: #e2e8f0;
        padding: 4px 12px;
        border-radius: 30px;
        color: #334155;
        }

        /* ---------- ACTIVITY / MESSAGES ---------- */
        .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        }

        .activity-item:last-child {
        border-bottom: none;
        }

        .activity-item .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #3b82f6;
        margin-top: 6px;
        flex-shrink: 0;
        }

        .activity-item .dot.green {
        background: #22c55e;
        }

        .activity-item .dot.orange {
        background: #f59e0b;
        }

        .activity-item .text {
        font-size: 14px;
        color: #1e293b;
        }

        .activity-item .text strong {
        font-weight: 600;
        }

        .activity-item .time {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 2px;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 900px) {
        .row {
            grid-template-columns: 1fr;
        }
        .sidebar {
            width: 72px;
            padding: 16px 8px;
        }
        .sidebar .logo span,
        .sidebar nav a span,
        .sidebar .user-info .name,
        .sidebar .user-info .role {
            display: none;
        }
        .sidebar .user-info .avatar {
            width: 36px;
            height: 36px;
        }
        .sidebar nav a {
            justify-content: center;
            padding: 12px;
        }
        .main {
            margin-left: 72px;
            padding: 20px;
        }
        }

        @media (max-width: 500px) {
        .stats {
            grid-template-columns: 1fr 1fr;
        }
        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <div class="logo">
        <i class="fas fa-comment-dots"></i><span>ChatApp</span>
        </div>

        <nav>
        <a href="#" class="active"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
        <a href="#"><i class="fas fa-users"></i><span>Teams</span></a>
        <a href="#"><i class="fas fa-hashtag"></i><span>Channels</span></a>
        <a href="#"><i class="fas fa-envelope"></i><span>Messages</span></a>
        <a href="#"><i class="fas fa-user-plus"></i><span>Invitations</span></a>
        <a href="#"><i class="fas fa-cog"></i><span>Settings</span></a>
        </nav>

        <div class="user-info">
        <div class="avatar">JD</div>
        <div>
            <div class="name">John Doe</div>
            <div class="role">Admin</div>
        </div>
        </div>
    </aside>

    <!-- ===== MAIN ===== -->
    <main class="main">

        <!-- HEADER -->
        <div class="header">
        <h1>Dashboard</h1>
        <div class="actions">
            <i class="fas fa-bell notif"></i>
            <button class="btn"><i class="fas fa-plus"></i> New Team</button>
        </div>
        </div>

        <!-- STATS -->
        <div class="stats">
        <div class="stat-card">
            <div class="label">Teams</div>
            <div class="value">4</div>
            <div class="change"><i class="fas fa-arrow-up"></i> +1 this month</div>
        </div>
        <div class="stat-card">
            <div class="label">Channels</div>
            <div class="value">12</div>
            <div class="change"><i class="fas fa-arrow-up"></i> +3 this week</div>
        </div>
        <div class="stat-card">
            <div class="label">Members</div>
            <div class="value">28</div>
            <div class="change"><i class="fas fa-arrow-up"></i> +5 invited</div>
        </div>
        <div class="stat-card">
            <div class="label">Messages</div>
            <div class="value">1.2k</div>
            <div class="change down"><i class="fas fa-arrow-down"></i> -8% vs last week</div>
        </div>
        </div>

        <!-- ROW: Teams + Recent Activity -->
        <div class="row">

        <!-- LEFT: Teams -->
        <div class="card">
            <h3>
            Your Teams
            <a href="#">View All</a>
            </h3>

            <div class="team-item">
            <div class="icon"><i class="fas fa-code"></i></div>
            <div class="info">
                <div class="name">Engineering</div>
                <div class="members"><i class="fas fa-user"></i> 8 members</div>
            </div>
            <span class="badge">3 channels</span>
            </div>

            <div class="team-item">
            <div class="icon"><i class="fas fa-paint-brush"></i></div>
            <div class="info">
                <div class="name">Design</div>
                <div class="members"><i class="fas fa-user"></i> 5 members</div>
            </div>
            <span class="badge">2 channels</span>
            </div>

            <div class="team-item">
            <div class="icon"><i class="fas fa-chart-line"></i></div>
            <div class="info">
                <div class="name">Marketing</div>
                <div class="members"><i class="fas fa-user"></i> 6 members</div>
            </div>
            <span class="badge">4 channels</span>
            </div>

            <div class="team-item">
            <div class="icon"><i class="fas fa-users"></i></div>
            <div class="info">
                <div class="name">Operations</div>
                <div class="members"><i class="fas fa-user"></i> 4 members</div>
            </div>
            <span class="badge">1 channel</span>
            </div>
        </div>

        <!-- RIGHT: Recent Activity / Messages -->
        <div class="card">
            <h3>
            Recent Activity
            <a href="#">See all</a>
            </h3>

            <div class="activity-item">
            <div class="dot green"></div>
            <div>
                <div class="text"><strong>Sarah</strong> joined #engineering</div>
                <div class="time">2 min ago</div>
            </div>
            </div>

            <div class="activity-item">
            <div class="dot"></div>
            <div>
                <div class="text"><strong>Mike</strong> sent a message in #random</div>
                <div class="time">18 min ago</div>
            </div>
            </div>

            <div class="activity-item">
            <div class="dot orange"></div>
            <div>
                <div class="text"><strong>You</strong> created channel #project-alpha</div>
                <div class="time">1 hour ago</div>
            </div>
            </div>

            <div class="activity-item">
            <div class="dot green"></div>
            <div>
                <div class="text"><strong>Emma</strong> accepted invitation</div>
                <div class="time">3 hours ago</div>
            </div>
            </div>

            <div class="activity-item">
            <div class="dot"></div>
            <div>
                <div class="text"><strong>Alex</strong> added 2 members to Design team</div>
                <div class="time">5 hours ago</div>
            </div>
            </div>
        </div>

        </div>
        <!-- end row -->

    </main>

</body>
</html>