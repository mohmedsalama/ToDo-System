<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoDash — Premium Task Management</title>
    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --font-display: 'Outfit', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #3730a3;
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --primary-glow: rgba(99, 102, 241, 0.25);
            
            --success: #059669;
            --success-light: #10b981;
            --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 100%);
            --success-glow: rgba(16, 185, 129, 0.2);
            
            --warning: #d97706;
            --warning-light: #f59e0b;
            --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            
            --danger: #dc2626;
            --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            
            --bg-canvas: #f8fafc;
            --text-heading: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            
            --glass-bg: rgba(255, 255, 255, 0.78);
            --glass-border: rgba(255, 255, 255, 0.85);
            --glass-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.04), 0 8px 10px -6px rgba(15, 23, 42, 0.03);
            --card-radius: 20px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-canvas);
            background-image: 
                radial-gradient(circle at 12% 8%, rgba(99, 102, 241, 0.09) 0%, transparent 45%),
                radial-gradient(circle at 88% 15%, rgba(217, 70, 239, 0.07) 0%, transparent 40%),
                radial-gradient(circle at 50% 90%, rgba(14, 165, 233, 0.07) 0%, transparent 50%);
            background-attachment: fixed;
            color: var(--text-body);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: var(--font-display);
            color: var(--text-heading);
            letter-spacing: -0.02em;
        }

        /* Glass Container & Cards */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: var(--card-radius);
            box-shadow: var(--glass-shadow);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 30px -10px rgba(79, 70, 229, 0.1), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
            border-color: rgba(99, 102, 241, 0.25);
        }

        /* Glass Navbar */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-brand-badge {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--primary-gradient);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 12px var(--primary-glow);
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover .navbar-brand-badge {
            transform: rotate(-6deg) scale(1.05);
        }

        /* Gradient & Primary Buttons */
        .btn-gradient-primary {
            background: var(--primary-gradient);
            color: #ffffff !important;
            border: none;
            border-radius: 12px;
            padding: 0.65rem 1.4rem;
            font-weight: 600;
            font-size: 0.925rem;
            box-shadow: 0 4px 14px var(--primary-glow);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-gradient-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(79, 70, 229, 0.35);
            color: #ffffff;
        }

        .btn-gradient-primary:hover::after {
            left: 100%;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(226, 232, 240, 0.9);
            color: var(--text-body);
            border-radius: 12px;
            font-weight: 600;
            padding: 0.65rem 1.25rem;
            transition: all 0.2s ease;
        }

        .btn-glass:hover {
            background: #ffffff;
            border-color: rgba(99, 102, 241, 0.3);
            color: var(--primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        /* Stat Icon Badges */
        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            transition: transform 0.3s ease;
        }

        .glass-card-hover:hover .stat-icon {
            transform: scale(1.1) rotate(4deg);
        }

        .stat-icon-primary {
            background: rgba(99, 102, 241, 0.12);
            color: var(--primary);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .stat-icon-warning {
            background: rgba(245, 158, 11, 0.12);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .stat-icon-success {
            background: rgba(16, 185, 129, 0.12);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        /* Pill Badges with Glow */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.02em;
        }

        .status-pill-success {
            background: rgba(16, 185, 129, 0.12);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .status-pill-warning {
            background: rgba(245, 158, 11, 0.12);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-pill-success .pulse-dot {
            background-color: var(--success-light);
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
            animation: pulseSuccess 2s infinite;
        }

        .status-pill-warning .pulse-dot {
            background-color: var(--warning-light);
            box-shadow: 0 0 8px rgba(245, 158, 11, 0.6);
            animation: pulseWarning 2s infinite;
        }

        @keyframes pulseSuccess {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        @keyframes pulseWarning {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        /* Table Modernization */
        .table-glass {
            --bs-table-bg: transparent;
            margin-bottom: 0;
        }

        .table-glass th {
            font-family: var(--font-display);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            font-weight: 700;
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            background: rgba(248, 250, 252, 0.6);
        }

        .table-glass td {
            padding: 1.15rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(241, 245, 249, 0.9);
            color: var(--text-body);
        }

        .table-glass tr {
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .table-glass tbody tr:hover {
            background-color: rgba(241, 245, 249, 0.5);
        }

        .table-glass tbody tr:last-child td {
            border-bottom: none;
        }

        /* Action Icon Buttons */
        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(226, 232, 240, 0.9);
            background: #ffffff;
            color: var(--text-muted);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-action-edit:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px var(--primary-glow);
        }

        .btn-action-delete:hover {
            background: var(--danger);
            color: #ffffff;
            border-color: var(--danger);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.25);
        }

        /* Form Controls */
        .glass-input {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1.1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .glass-input:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px var(--primary-glow);
            outline: none;
            background: #ffffff;
        }

        /* Progress Bar */
        .progress-slim {
            height: 8px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .progress-bar-gradient {
            background: var(--primary-gradient);
            border-radius: 999px;
            transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body>

    <!-- Glass Navbar -->
    <nav class="glass-navbar py-3 mb-4 mb-lg-5">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none" href="{{ route('todos.index') }}">
                <div class="navbar-brand-badge">
                    <i class="bi bi-check2-all fs-4"></i>
                </div>
                <div>
                    <span class="fs-4 fw-bold brand-font text-dark mb-0 d-block leading-tight">Todo<span class="text-primary">Dash</span></span>
                    <span class="text-muted fw-medium d-none d-sm-block" style="font-size: 0.725rem; letter-spacing: 0.05em; text-transform: uppercase;">Workspace & Tasks</span>
                </div>
            </a>
            
            <div class="d-flex align-items-center gap-3">
                <a class="btn btn-gradient-primary d-inline-flex align-items-center gap-2" href="{{ route('todos.create') }}">
                    <i class="bi bi-plus-lg fs-6"></i>
                    <span class="d-none d-sm-inline">New Task</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container pb-5">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toast Notification Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Flash Messages
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        // Delete Confirmation with Styled SweetAlert2
        function confirmDelete(id) {
            Swal.fire({
                title: 'Delete this task?',
                text: "This action cannot be undone.",
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    popup: 'glass-card border-0 p-4',
                    title: 'brand-font fw-bold text-dark fs-4 mb-2',
                    htmlContainer: 'text-muted mb-4',
                    confirmButton: 'btn btn-danger px-4 py-2 me-2 rounded-3 fw-semibold',
                    cancelButton: 'btn btn-light border px-4 py-2 rounded-3 fw-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</body>
</html>
