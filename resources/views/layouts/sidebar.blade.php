<nav class="bg-dark text-white p-3 sidebar" style="width: 250px; height: 100vh; overflow-y: auto;">
    <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <span class="fs-4">TenderApp</span>
    </a>
    <hr>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('tender.create') }}" class="nav-link text-white {{ request()->routeIs('tender.create') ? 'active' : '' }}">
                <i class="bi bi-pencil-square me-2"></i> Create Tender
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('tender.list_contractor') }}" class="nav-link text-white {{ request()->routeIs('tender.list_contractor') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text me-2"></i> Tender List (Contractor)
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('tender.list_supplier') }}" class="nav-link text-white {{ request()->routeIs('tender.list_supplier') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-right me-2"></i> Tender List (Supplier)
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-white">
                <i class="bi bi-gear me-2"></i> Settings
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('logout') }}" class="nav-link text-white">
                <i class="bi bi-door-open me-2"></i> Logout
            </a>
        </li>
    </ul>
</nav>
