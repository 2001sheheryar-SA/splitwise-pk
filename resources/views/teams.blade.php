<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ChatApp - Teams</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
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
            flex-wrap: wrap;
            gap: 16px;
        }

        .header h1 {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
        }

        .header .actions {
            display: flex;
            gap: 12px;
            align-items: center;
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
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header .actions .btn:hover {
            background: #2563eb;
        }

        .header .actions .btn-outline {
            background: transparent;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
            font-size: 14px;
        }

        .header .actions .btn-outline:hover {
            background: #f1f5f9;
        }

        /* ---------- SEARCH BAR ---------- */
        .search-bar {
            background: #ffffff;
            border-radius: 12px;
            padding: 12px 20px;
            border: 1px solid #e9edf2;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .search-bar i {
            color: #94a3b8;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex: 1;
            font-size: 14px;
            color: #0f172a;
        }

        .search-bar input::placeholder {
            color: #94a3b8;
        }

        /* ---------- TEAMS GRID ---------- */
        .teams-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }

        .team-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e9edf2;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: 0.2s;
        }

        .team-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .team-card .team-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
        }

        .team-card .team-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            flex-shrink: 0;
        }

        .team-card .team-icon.blue {
            background: #3b82f6;
        }
        .team-card .team-icon.green {
            background: #22c55e;
        }
        .team-card .team-icon.purple {
            background: #8b5cf6;
        }
        .team-card .team-icon.orange {
            background: #f59e0b;
        }
        .team-card .team-icon.red {
            background: #ef4444;
        }
        .team-card .team-icon.pink {
            background: #ec4899;
        }

        .team-card .team-name {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
        }

        .team-card .team-meta {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 16px;
            display: flex;
            gap: 16px;
        }

        .team-card .team-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .team-card .team-meta i {
            font-size: 14px;
        }

        .team-card .team-members {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .team-card .member-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
        }

        .team-card .member-avatar.more {
            background: #e2e8f0;
            color: #475569;
            font-size: 11px;
        }

        .team-card .team-actions {
            display: flex;
            gap: 8px;
            border-top: 1px solid #f1f5f9;
            padding-top: 14px;
            flex-wrap: wrap;
        }

        .team-card .team-actions button {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 60px;
        }

        .team-card .team-actions .btn-view {
            background: #eff6ff;
            color: #3b82f6;
        }

        .team-card .team-actions .btn-view:hover {
            background: #dbeafe;
        }

        .team-card .team-actions .btn-edit {
            background: #fefce8;
            color: #eab308;
        }

        .team-card .team-actions .btn-edit:hover {
            background: #fef08a;
        }

        .team-card .team-actions .btn-delete {
            background: #fef2f2;
            color: #ef4444;
        }

        .team-card .team-actions .btn-delete:hover {
            background: #fecaca;
        }

        /* ---------- MODAL (Create Team) ---------- */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            background: #ffffff;
            border-radius: 20px;
            padding: 32px;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal h2 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .modal .subtitle {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 24px;
        }

        .modal label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .modal input,
        .modal select,
        .modal textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 18px;
            outline: none;
            transition: 0.2s;
        }

        .modal input:focus,
        .modal select:focus,
        .modal textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .modal textarea {
            resize: vertical;
            min-height: 60px;
        }

        .modal .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }

        .modal .modal-actions button {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-size: 14px;
            flex: 1;
        }

        .modal .modal-actions .btn-cancel {
            background: #f1f5f9;
            color: #475569;
        }

        .modal .modal-actions .btn-cancel:hover {
            background: #e2e8f0;
        }

        .modal .modal-actions .btn-create {
            background: #3b82f6;
            color: #ffffff;
        }

        .modal .modal-actions .btn-create:hover {
            background: #2563eb;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 900px) {
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
            .teams-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 500px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .header .actions {
                width: 100%;
                flex-wrap: wrap;
            }
            .header .actions .btn,
            .header .actions .btn-outline {
                flex: 1;
                justify-content: center;
            }
            .team-card .team-actions button {
                flex: 1;
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
            <a href="index.html"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
            <a href="teams.html" class="active"><i class="fas fa-users"></i><span>Teams</span></a>
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
            <h1><i class="fas fa-users" style="color:#3b82f6; margin-right:12px;"></i> Teams</h1>
            <div class="actions">
                <button class="btn-outline"><i class="fas fa-download"></i> Export</button>
                <button class="btn" onclick="openModal()"><i class="fas fa-plus"></i> New Team</button>
            </div>
        </div>

        <!-- SEARCH -->
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search teams by name..." />
        </div>

        <!-- TEAMS GRID -->
        <div class="teams-grid">

            <!-- Team 1 -->
            <div class="team-card">
                <div class="team-header">
                    <div class="team-icon blue"><i class="fas fa-code"></i></div>
                    <div>
                        <div class="team-name">Engineering</div>
                    </div>
                </div>
                <div class="team-meta">
                    <span><i class="fas fa-user"></i> 8 members</span>
                    <span><i class="fas fa-hashtag"></i> 3 channels</span>
                    <span><i class="far fa-calendar"></i> Created Jan 2026</span>
                </div>
                <div class="team-members">
                    <div class="member-avatar">JD</div>
                    <div class="member-avatar">SM</div>
                    <div class="member-avatar">AK</div>
                    <div class="member-avatar">MR</div>
                    <div class="member-avatar more">+4</div>
                </div>
                <div class="team-actions">
                    <button class="btn-view"><i class="fas fa-eye"></i> View</button>
                    <button class="btn-edit"><i class="fas fa-user-plus"></i> Add</button>
                    <button class="btn-delete"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>

            <!-- Team 2 -->
            <div class="team-card">
                <div class="team-header">
                    <div class="team-icon purple"><i class="fas fa-paint-brush"></i></div>
                    <div>
                        <div class="team-name">Design</div>
                    </div>
                </div>
                <div class="team-meta">
                    <span><i class="fas fa-user"></i> 5 members</span>
                    <span><i class="fas fa-hashtag"></i> 2 channels</span>
                    <span><i class="far fa-calendar"></i> Created Feb 2026</span>
                </div>
                <div class="team-members">
                    <div class="member-avatar">JD</div>
                    <div class="member-avatar">AL</div>
                    <div class="member-avatar">EM</div>
                    <div class="member-avatar more">+2</div>
                </div>
                <div class="team-actions">
                    <button class="btn-view"><i class="fas fa-eye"></i> View</button>
                    <button class="btn-edit"><i class="fas fa-user-plus"></i> Add</button>
                    <button class="btn-delete"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>

            <!-- Team 3 -->
            <div class="team-card">
                <div class="team-header">
                    <div class="team-icon green"><i class="fas fa-chart-line"></i></div>
                    <div>
                        <div class="team-name">Marketing</div>
                    </div>
                </div>
                <div class="team-meta">
                    <span><i class="fas fa-user"></i> 6 members</span>
                    <span><i class="fas fa-hashtag"></i> 4 channels</span>
                    <span><i class="far fa-calendar"></i> Created Mar 2026</span>
                </div>
                <div class="team-members">
                    <div class="member-avatar">JD</div>
                    <div class="member-avatar">SP</div>
                    <div class="member-avatar">MN</div>
                    <div class="member-avatar">RK</div>
                    <div class="member-avatar more">+2</div>
                </div>
                <div class="team-actions">
                    <button class="btn-view"><i class="fas fa-eye"></i> View</button>
                    <button class="btn-edit"><i class="fas fa-user-plus"></i> Add</button>
                    <button class="btn-delete"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>

            <!-- Team 4 -->
            <div class="team-card">
                <div class="team-header">
                    <div class="team-icon orange"><i class="fas fa-users"></i></div>
                    <div>
                        <div class="team-name">Operations</div>
                    </div>
                </div>
                <div class="team-meta">
                    <span><i class="fas fa-user"></i> 4 members</span>
                    <span><i class="fas fa-hashtag"></i> 1 channel</span>
                    <span><i class="far fa-calendar"></i> Created Apr 2026</span>
                </div>
                <div class="team-members">
                    <div class="member-avatar">JD</div>
                    <div class="member-avatar">TR</div>
                    <div class="member-avatar">WS</div>
                    <div class="member-avatar more">+1</div>
                </div>
                <div class="team-actions">
                    <button class="btn-view"><i class="fas fa-eye"></i> View</button>
                    <button class="btn-edit"><i class="fas fa-user-plus"></i> Add</button>
                    <button class="btn-delete"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>

            <!-- Team 5 (Empty state example) -->
            <div class="team-card" style="border: 2px dashed #e2e8f0; background: #fafbfc;">
                <div style="text-align: center; padding: 20px 0;">
                    <i class="fas fa-plus-circle" style="font-size: 40px; color: #94a3b8;"></i>
                    <div style="font-weight: 600; color: #475569; margin-top: 12px;">Create New Team</div>
                    <div style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Click "New Team" to get started</div>
                </div>
            </div>

        </div>

    </main>

    <!-- ===== MODAL: Create Team ===== -->
    <div class="modal-overlay" id="createModal">
        <div class="modal">
            <h2><i class="fas fa-users" style="color:#3b82f6; margin-right:10px;"></i> Create New Team</h2>
            <p class="subtitle">Add a new team to your company workspace.</p>

            <form id="createTeamForm">
                <label for="teamName">Team Name *</label>
                <input type="text" id="teamName" placeholder="e.g. Product, Sales, HR" required />

                <label for="teamDescription">Description (optional)</label>
                <textarea id="teamDescription" placeholder="What's this team all about?"></textarea>

                <label for="teamColor">Team Color</label>
                <select id="teamColor">
                    <option value="blue">Blue</option>
                    <option value="green">Green</option>
                    <option value="purple">Purple</option>
                    <option value="orange">Orange</option>
                    <option value="red">Red</option>
                    <option value="pink">Pink</option>
                </select>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-create"><i class="fas fa-plus"></i> Create Team</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Open modal
        function openModal() {
            document.getElementById('createModal').classList.add('show');
        }

        // Close modal
        function closeModal() {
            document.getElementById('createModal').classList.remove('show');
        }

        // Close modal on outside click
        document.getElementById('createModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Handle form submission
        document.getElementById('createTeamForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('teamName').value;
            const desc = document.getElementById('teamDescription').value;
            const color = document.getElementById('teamColor').value;

            // In a real app, you'd send this to your API
            alert(`Team "${name}" created successfully! 🎉\nDescription: ${desc || 'None'}\nColor: ${color}`);

            closeModal();
            this.reset();
        });
    </script>

</body>
</html>