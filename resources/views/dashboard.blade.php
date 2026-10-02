<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | GlobalPark Pathfinder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dashboard-page">
    <div class="dashboard-shell" data-dashboard>
        <aside class="dashboard-sidebar" data-sidebar>
            <div class="sidebar-brand-row">
                <button class="icon-button sidebar-toggle" type="button" aria-label="Collapse sidebar" data-sidebar-toggle>
                    <img src="{{ asset('assets/pathfinder/dashboard/menu.svg') }}" width="24" height="24" alt="">
                </button>
                <a class="sidebar-brand" href="{{ route('dashboard') }}" aria-label="GlobalPark Pathfinder dashboard">
                    <img class="brand-mark" src="{{ asset('assets/pathfinder/dashboard/logo-mark.svg') }}" alt="">
                    <img class="brand-wordmark" src="{{ asset('assets/pathfinder/dashboard/logo-wordmark.svg') }}" alt="GlobalPark">
                </a>
            </div>

            <nav class="sidebar-navigation" aria-label="Main navigation">
                <p class="sidebar-section-label">PATHFINDER</p>
                <a class="sidebar-link is-active" href="{{ route('dashboard') }}" aria-current="page">
                    <img src="{{ asset('assets/pathfinder/dashboard/nav-dashboard.svg') }}" width="24" height="24" alt="">
                    <span>Dashboard</span>
                </a>
                <button class="sidebar-link is-upcoming" type="button" disabled>
                    <img src="{{ asset('assets/pathfinder/dashboard/nav-site.svg') }}" width="24" height="24" alt="">
                    <span>Sites &amp; locations</span>
                    <span class="nav-tag">Soon</span>
                </button>
                <button class="sidebar-link is-upcoming" type="button" disabled>
                    <span class="nav-icon-placeholder" aria-hidden="true">◉</span>
                    <span>Devices</span>
                    <span class="nav-tag">Soon</span>
                </button>
                <button class="sidebar-link is-upcoming" type="button" disabled>
                    <span class="nav-icon-placeholder route-icon" aria-hidden="true">⌁</span>
                    <span>Maps &amp; routing</span>
                    <span class="nav-tag">Soon</span>
                </button>

                <p class="sidebar-section-label sidebar-section-secondary">WORKSPACE</p>
                <button class="sidebar-link is-upcoming" type="button" disabled>
                    <span class="nav-icon-placeholder" aria-hidden="true">⚙</span>
                    <span>Settings</span>
                    <span class="nav-tag">Soon</span>
                </button>
            </nav>

            <div class="sidebar-footer">
                <span class="sidebar-status-dot"></span>
                <span>Pathfinder preview</span>
            </div>
        </aside>

        <div class="dashboard-main">
            <header class="dashboard-topbar">
                <div class="topbar-heading">
                    <button class="icon-button mobile-menu-toggle" type="button" aria-label="Open navigation" data-sidebar-toggle>
                        <img src="{{ asset('assets/pathfinder/dashboard/menu.svg') }}" width="24" height="24" alt="">
                    </button>
                    <div class="topbar-title">
                        <h1>Dashboard</h1>
                        <div class="breadcrumbs" aria-label="Breadcrumb">
                            <span>Pathfinder</span>
                            <img src="{{ asset('assets/pathfinder/dashboard/breadcrumb.svg') }}" width="16" height="16" alt="">
                            <span class="breadcrumb-current">Overview</span>
                        </div>
                    </div>
                </div>

                <div class="topbar-actions">
                    <span class="workspace-switcher">
                        <span class="workspace-avatar">G</span>
                        <span class="workspace-copy">
                            <strong>GlobalPark Partner</strong>
                            <small>Preview workspace</small>
                        </span>
                        <img src="{{ asset('assets/pathfinder/dashboard/chevron-down.svg') }}" width="20" height="20" alt="">
                    </span>
                    <button class="icon-button notification-button" type="button" aria-label="Notifications">
                        <img src="{{ asset('assets/pathfinder/dashboard/bell.svg') }}" width="20" height="20" alt="">
                        <span class="notification-dot"></span>
                    </button>
                    <div class="profile-menu" data-profile-menu>
                        <button class="profile-trigger" type="button" aria-expanded="false" data-profile-toggle>
                            <span class="profile-avatar">
                                <img src="{{ asset('assets/pathfinder/dashboard/profile.svg') }}" width="24" height="24" alt="">
                            </span>
                            <span class="profile-copy">
                                <strong>{{ auth()->user()->name }}</strong>
                                <small>{{ auth()->user()->email }}</small>
                            </span>
                            <img class="profile-chevron" src="{{ asset('assets/pathfinder/dashboard/chevron-down.svg') }}" width="20" height="20" alt="">
                        </button>
                        <div class="profile-dropdown" data-profile-dropdown hidden>
                            <div class="dropdown-user">
                                <strong>{{ auth()->user()->name }}</strong>
                                <span>{{ auth()->user()->email }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="logout-button">Log out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="dashboard-content">
                <div class="content-heading">
                    <div>
                        <h2>Workspace overview</h2>
                        <p>Monitor your Pathfinder sites, devices, and navigation activity.</p>
                    </div>
                    <span class="preview-badge"><span></span> Preview data</span>
                </div>

                <section class="dashboard-toolbar" aria-label="Dashboard filters and actions">
                    <div class="toolbar-filters">
                        <label class="toolbar-select-wrap">
                            <span class="sr-only">Filter by site</span>
                            <select class="toolbar-select" data-site-filter>
                                <option value="all">All sites</option>
                                <option value="Pavilion Damansara Heights">Pavilion Damansara Heights</option>
                                <option value="GlobalPark Demo Site">GlobalPark Demo Site</option>
                                <option value="Kelana Jaya Pilot">Kelana Jaya Pilot</option>
                            </select>
                        </label>
                        <label class="toolbar-select-wrap period-select-wrap">
                            <span class="sr-only">Filter by time period</span>
                            <img src="{{ asset('assets/pathfinder/dashboard/calendar.svg') }}" width="20" height="20" alt="">
                            <select class="toolbar-select" data-period-filter>
                                <option value="all">All time periods</option>
                                <option value="7">Last 7 days</option>
                                <option value="30">Last 30 days</option>
                            </select>
                        </label>
                    </div>
                    <button class="primary-button" type="button" data-setup-button>
                        <img src="{{ asset('assets/pathfinder/dashboard/plus.svg') }}" width="20" height="20" alt="">
                        <span>Set up a site</span>
                    </button>
                </section>

                <section class="metric-grid" aria-label="Workspace summary">
                    <article class="metric-card">
                        <span class="metric-icon metric-icon-dark"><img src="{{ asset('assets/pathfinder/dashboard/metric-sites.svg') }}" width="16" height="16" alt=""></span>
                        <span class="metric-copy"><strong>03</strong><span>Sites</span></span>
                    </article>
                    <article class="metric-card">
                        <span class="metric-icon metric-icon-purple"><img src="{{ asset('assets/pathfinder/dashboard/metric-beacons.svg') }}" width="16" height="16" alt=""></span>
                        <span class="metric-copy"><strong>128</strong><span>Beacons registered</span></span>
                    </article>
                    <article class="metric-card">
                        <span class="metric-icon metric-icon-muted"><img src="{{ asset('assets/pathfinder/dashboard/metric-activity.svg') }}" width="16" height="16" alt=""></span>
                        <span class="metric-copy"><strong>24</strong><span>Active sessions</span></span>
                    </article>
                    <article class="metric-card">
                        <span class="metric-icon metric-icon-green"><img src="{{ asset('assets/pathfinder/dashboard/metric-routes.svg') }}" width="16" height="16" alt=""></span>
                        <span class="metric-copy"><strong>98.4%</strong><span>Route availability</span></span>
                    </article>
                </section>

                <section class="activity-panel" aria-labelledby="activity-heading">
                    <div class="table-heading">
                        <div>
                            <h2 id="activity-heading">Recent device activity</h2>
                            <p>Sample beacon records shown for dashboard preview.</p>
                        </div>
                        <label class="table-search-wrap">
                            <span class="sr-only">Search devices</span>
                            <span class="search-icon" aria-hidden="true"></span>
                            <input type="search" placeholder="Search devices" data-table-search>
                        </label>
                    </div>

                    <div class="table-scroll-region">
                        <table class="activity-table">
                            <thead>
                                <tr>
                                    <th><button type="button" data-sort="device">Device <img src="{{ asset('assets/pathfinder/dashboard/sort.svg') }}" width="16" height="16" alt=""></button></th>
                                    <th><button type="button" data-sort="site">Site <img src="{{ asset('assets/pathfinder/dashboard/sort.svg') }}" width="16" height="16" alt=""></button></th>
                                    <th><button type="button" data-sort="level">Level <img src="{{ asset('assets/pathfinder/dashboard/sort.svg') }}" width="16" height="16" alt=""></button></th>
                                    <th><button type="button" data-sort="lastSeen">Last seen <img src="{{ asset('assets/pathfinder/dashboard/sort.svg') }}" width="16" height="16" alt=""></button></th>
                                    <th><button type="button" data-sort="status">Status <img src="{{ asset('assets/pathfinder/dashboard/sort.svg') }}" width="16" height="16" alt=""></button></th>
                                    <th class="table-action-heading">Action</th>
                                </tr>
                            </thead>
                            <tbody data-table-body></tbody>
                        </table>
                        <div class="table-empty" data-table-empty hidden>
                            <span class="empty-state-icon">⌕</span>
                            <strong>No devices match your search</strong>
                            <span>Try another device name or site.</span>
                        </div>
                    </div>

                    <div class="table-pagination" data-pagination>
                        <label class="page-size-wrap">
                            <span class="sr-only">Items per page</span>
                            <select data-page-size>
                                <option value="10">10 items / page</option>
                                <option value="25">25 items / page</option>
                                <option value="50">50 items / page</option>
                            </select>
                        </label>
                        <div class="page-buttons" aria-label="Pagination controls">
                            <button class="page-arrow" type="button" data-page-first aria-label="First page"><img src="{{ asset('assets/pathfinder/dashboard/chevrons-left.svg') }}" width="20" height="20" alt=""></button>
                            <button class="page-arrow" type="button" data-page-prev aria-label="Previous page"><img src="{{ asset('assets/pathfinder/dashboard/chevron-left.svg') }}" width="20" height="20" alt=""></button>
                            <div class="page-numbers" data-page-numbers></div>
                            <button class="page-arrow" type="button" data-page-next aria-label="Next page"><img src="{{ asset('assets/pathfinder/dashboard/chevron-right.svg') }}" width="20" height="20" alt=""></button>
                            <button class="page-arrow" type="button" data-page-last aria-label="Last page"><img src="{{ asset('assets/pathfinder/dashboard/chevrons-right.svg') }}" width="20" height="20" alt=""></button>
                        </div>
                        <label class="go-to-page">
                            <span>Go to</span>
                            <select aria-label="Go to page" data-go-to-page></select>
                        </label>
                    </div>
                    <p class="table-count" data-table-count></p>
                </section>
            </main>
        </div>
    </div>

    <dialog class="setup-dialog" data-setup-dialog>
        <form method="dialog" class="dialog-close-row"><button class="dialog-close" aria-label="Close">×</button></form>
        <span class="dialog-icon"><img src="{{ asset('assets/pathfinder/dashboard/nav-site.svg') }}" width="24" height="24" alt=""></span>
        <h2>Site setup is coming soon</h2>
        <p>This dashboard currently uses preview data. Site management will be connected when the Pathfinder partner and site modules are ready.</p>
        <button class="primary-button dialog-primary" type="button" data-dialog-close>Got it</button>
    </dialog>

    <div class="toast-message" role="status" aria-live="polite" data-toast></div>
</body>
</html>
