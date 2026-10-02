import './bootstrap';

const emailInput = document.querySelector('#email');
const passwordInput = document.querySelector('#password');
const loginSubmit = document.querySelector('[data-login-submit]');
const passwordToggle = document.querySelector('[data-password-toggle]');

const updateLoginButton = () => {
    if (!emailInput || !passwordInput || !loginSubmit) {
        return;
    }

    loginSubmit.disabled = emailInput.value.trim() === '' || passwordInput.value === '';
};

emailInput?.addEventListener('input', updateLoginButton);
passwordInput?.addEventListener('input', updateLoginButton);

passwordToggle?.addEventListener('click', () => {
    if (!passwordInput) {
        return;
    }

    const isPasswordVisible = passwordInput.type === 'text';
    passwordInput.type = isPasswordVisible ? 'password' : 'text';
    passwordToggle.setAttribute('aria-pressed', String(!isPasswordVisible));
    passwordToggle.setAttribute('aria-label', isPasswordVisible ? 'Show password' : 'Hide password');
});

updateLoginButton();

const dashboard = document.querySelector('[data-dashboard]');

if (dashboard) {
    const dashboardShell = dashboard;
    const tableBody = dashboard.querySelector('[data-table-body]');
    const tableSearch = dashboard.querySelector('[data-table-search]');
    const siteFilter = dashboard.querySelector('[data-site-filter]');
    const periodFilter = dashboard.querySelector('[data-period-filter]');
    const pageSizeSelect = dashboard.querySelector('[data-page-size]');
    const pageNumbers = dashboard.querySelector('[data-page-numbers]');
    const goToPage = dashboard.querySelector('[data-go-to-page]');
    const emptyMessage = dashboard.querySelector('[data-table-empty]');
    const tableCount = dashboard.querySelector('[data-table-count]');
    const pagination = dashboard.querySelector('[data-pagination]');
    const toast = document.querySelector('[data-toast]');

    const sites = [
        'Pavilion Damansara Heights',
        'GlobalPark Demo Site',
        'Kelana Jaya Pilot',
    ];
    const levels = ['B1', 'B2', 'B3', 'L1'];
    const statuses = ['Online', 'Online', 'Idle', 'Online', 'Maintenance'];
    const beacons = Array.from({ length: 40 }, (_, index) => {
        const number = String(index + 1).padStart(3, '0');
        const minutesAgo = (index * 7 + 2) % 180;

        return {
            device: `Beacon PF-${number}`,
            site: sites[index % sites.length],
            level: levels[index % levels.length],
            lastSeen: minutesAgo < 60 ? `${minutesAgo} min ago` : `${Math.floor(minutesAgo / 60)} hr ago`,
            minutesAgo,
            daysAgo: (index * 3 + 1) % 30,
            status: statuses[index % statuses.length],
        };
    });

    let currentPage = 1;
    let pageSize = Number(pageSizeSelect?.value || 10);
    let sortKey = 'device';
    let sortDirection = 1;
    let toastTimeout;

    const filteredBeacons = () => {
        const query = (tableSearch?.value || '').trim().toLowerCase();
        const selectedSite = siteFilter?.value || 'all';
        const selectedPeriod = periodFilter?.value || 'all';

        return beacons
            .filter((beacon) => selectedSite === 'all' || beacon.site === selectedSite)
            .filter((beacon) => selectedPeriod === 'all' || beacon.daysAgo < Number(selectedPeriod))
            .filter((beacon) => !query || `${beacon.device} ${beacon.site} ${beacon.level} ${beacon.status}`.toLowerCase().includes(query))
            .sort((left, right) => {
                const leftValue = sortKey === 'lastSeen' ? left.minutesAgo : left[sortKey].toLowerCase();
                const rightValue = sortKey === 'lastSeen' ? right.minutesAgo : right[sortKey].toLowerCase();

                if (leftValue < rightValue) return -1 * sortDirection;
                if (leftValue > rightValue) return 1 * sortDirection;
                return 0;
            });
    };

    const showToast = (message) => {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('is-visible');
        window.clearTimeout(toastTimeout);
        toastTimeout = window.setTimeout(() => toast.classList.remove('is-visible'), 2600);
    };

    const pageButton = (page, totalPages) => {
        const button = document.createElement('button');
        button.className = `page-number${page === currentPage ? ' is-current' : ''}`;
        button.type = 'button';
        button.textContent = String(page);
        button.setAttribute('aria-label', `Page ${page}`);
        if (page === currentPage) button.setAttribute('aria-current', 'page');
        if (page < 1 || page > totalPages) button.disabled = true;
        button.addEventListener('click', () => {
            currentPage = page;
            renderTable();
        });
        return button;
    };

    const renderTable = () => {
        if (!tableBody || !pageNumbers || !goToPage) return;
        const results = filteredBeacons();
        const total = results.length;
        const totalPages = Math.max(1, Math.ceil(total / pageSize));
        currentPage = Math.min(currentPage, totalPages);
        const start = (currentPage - 1) * pageSize;
        const visibleRows = results.slice(start, start + pageSize);

        tableBody.innerHTML = visibleRows.map((beacon) => {
            const statusClass = beacon.status === 'Online' ? 'is-online' : beacon.status === 'Idle' ? 'is-idle' : 'is-maintenance';

            return `<tr>
                <td>${beacon.device}</td>
                <td>${beacon.site}</td>
                <td>${beacon.level}</td>
                <td>${beacon.lastSeen}</td>
                <td><span class="status-chip ${statusClass}">${beacon.status}</span></td>
                <td><button class="table-action-button" type="button" data-view-device="${beacon.device}">View</button></td>
            </tr>`;
        }).join('');

        if (emptyMessage) emptyMessage.hidden = total !== 0;
        if (pagination) pagination.hidden = total === 0;
        if (tableCount) {
            const first = total === 0 ? 0 : start + 1;
            const last = Math.min(start + pageSize, total);
            tableCount.textContent = total === 0 ? 'No devices found' : `Showing ${first}–${last} of ${total} preview devices`;
        }

        pageNumbers.replaceChildren();
        const firstVisiblePage = Math.max(1, Math.min(currentPage - 2, totalPages - 4));
        const lastVisiblePage = Math.min(totalPages, firstVisiblePage + 4);
        for (let page = firstVisiblePage; page <= lastVisiblePage; page += 1) {
            pageNumbers.append(pageButton(page, totalPages));
        }

        goToPage.replaceChildren();
        for (let page = 1; page <= totalPages; page += 1) {
            const option = document.createElement('option');
            option.value = String(page);
            option.textContent = `Page ${page}`;
            option.selected = page === currentPage;
            goToPage.append(option);
        }

        dashboard.querySelector('[data-page-first]').disabled = currentPage === 1;
        dashboard.querySelector('[data-page-prev]').disabled = currentPage === 1;
        dashboard.querySelector('[data-page-next]').disabled = currentPage === totalPages;
        dashboard.querySelector('[data-page-last]').disabled = currentPage === totalPages;
    };

    tableSearch?.addEventListener('input', () => {
        currentPage = 1;
        renderTable();
    });
    siteFilter?.addEventListener('change', () => {
        currentPage = 1;
        renderTable();
    });
    periodFilter?.addEventListener('change', () => {
        currentPage = 1;
        renderTable();
    });
    pageSizeSelect?.addEventListener('change', () => {
        pageSize = Number(pageSizeSelect.value);
        currentPage = 1;
        renderTable();
    });
    goToPage?.addEventListener('change', () => {
        currentPage = Number(goToPage.value);
        renderTable();
    });

    dashboard.querySelectorAll('[data-sort]').forEach((button) => {
        button.addEventListener('click', () => {
            const nextSort = button.dataset.sort;
            sortDirection = sortKey === nextSort ? sortDirection * -1 : 1;
            sortKey = nextSort;
            renderTable();
        });
    });

    dashboard.querySelector('[data-page-first]')?.addEventListener('click', () => { currentPage = 1; renderTable(); });
    dashboard.querySelector('[data-page-prev]')?.addEventListener('click', () => { currentPage -= 1; renderTable(); });
    dashboard.querySelector('[data-page-next]')?.addEventListener('click', () => { currentPage += 1; renderTable(); });
    dashboard.querySelector('[data-page-last]')?.addEventListener('click', () => { currentPage = Math.ceil(filteredBeacons().length / pageSize); renderTable(); });

    tableBody?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-view-device]');
        if (button) showToast(`${button.dataset.viewDevice} is sample preview data.`);
    });

    dashboard.querySelectorAll('[data-sidebar-toggle]').forEach((sidebarToggle) => {
        sidebarToggle.addEventListener('click', () => {
            if (window.matchMedia('(max-width: 760px)').matches) {
                dashboardShell.classList.toggle('mobile-menu-open');
            } else {
                dashboardShell.classList.toggle('is-collapsed');
            }
        });
    });
    dashboardShell.addEventListener('click', (event) => {
        if (dashboardShell.classList.contains('mobile-menu-open') && event.target === dashboardShell) {
            dashboardShell.classList.remove('mobile-menu-open');
        }
    });
    window.addEventListener('resize', () => dashboardShell.classList.remove('mobile-menu-open'));

    const profileToggle = dashboard.querySelector('[data-profile-toggle]');
    const profileDropdown = dashboard.querySelector('[data-profile-dropdown]');
    profileToggle?.addEventListener('click', () => {
        const willOpen = profileDropdown?.hidden ?? true;
        if (profileDropdown) profileDropdown.hidden = !willOpen;
        profileToggle.setAttribute('aria-expanded', String(willOpen));
    });
    document.addEventListener('click', (event) => {
        if (profileDropdown && !event.target.closest('[data-profile-menu]')) {
            profileDropdown.hidden = true;
            profileToggle?.setAttribute('aria-expanded', 'false');
        }
    });

    const setupDialog = document.querySelector('[data-setup-dialog]');
    dashboard.querySelector('[data-setup-button]')?.addEventListener('click', () => setupDialog?.showModal());
    setupDialog?.querySelectorAll('[data-dialog-close]').forEach((button) => button.addEventListener('click', () => setupDialog.close()));
    dashboard.querySelector('.notification-button')?.addEventListener('click', () => showToast('You are all caught up.'));

    renderTable();
}
