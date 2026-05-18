// Sidebar — dark gradient, role-aware nav, collapsible
function Sidebar({ active, onNavigate, collapsed }) {
  const items = [
    { id: "dashboard", icon: "fas fa-home",            label: "Dashboard" },
    { id: "applications", icon: "fas fa-file-alt",     label: "Pengajuan" },
    { id: "participants", icon: "fas fa-users",        label: "Peserta" },
    { id: "divisions", icon: "fas fa-sitemap",         label: "Divisi" },
    { id: "mentors", icon: "fas fa-user-tie",          label: "Pembimbing" },
  ];
  const ops = [
    { id: "attendance", icon: "fas fa-calendar-check", label: "Presensi" },
    { id: "logbook", icon: "fas fa-book",              label: "Logbook" },
    { id: "assignments", icon: "fas fa-tasks",         label: "Tugas" },
    { id: "reports", icon: "fas fa-chart-line",        label: "Laporan" },
  ];

  return (
    <aside className={`sidebar ${collapsed ? "collapsed" : ""}`}>
      <div className="sidebar-header">
        <div className="sidebar-logo">
          <img src="../../assets/logos/telkom-mark.png" alt="Telkom" />
        </div>
        <div className="sidebar-brand">
          Telkom Magang
          <small>Witel Sulbagsel</small>
        </div>
      </div>

      <div className="nav-section">
        <div className="nav-section-title">Utama</div>
        {items.map(it => (
          <div key={it.id} className={`nav-item ${active === it.id ? "active" : ""}`} onClick={() => onNavigate(it.id)}>
            <span className="nav-icon"><i className={it.icon}></i></span>
            <span className="nav-text">{it.label}</span>
          </div>
        ))}
      </div>

      <div className="nav-section">
        <div className="nav-section-title">Operasional</div>
        {ops.map(it => (
          <div key={it.id} className={`nav-item ${active === it.id ? "active" : ""}`} onClick={() => onNavigate(it.id)}>
            <span className="nav-icon"><i className={it.icon}></i></span>
            <span className="nav-text">{it.label}</span>
          </div>
        ))}
      </div>

      <div className="sidebar-foot">
        <div className="nav-item" onClick={() => onNavigate("settings")}>
          <span className="nav-icon"><i className="fas fa-cog"></i></span>
          <span className="nav-text">Pengaturan</span>
        </div>
        <div className="nav-item" onClick={() => onNavigate("login")}>
          <span className="nav-icon"><i className="fas fa-sign-out-alt"></i></span>
          <span className="nav-text">Keluar</span>
        </div>
      </div>
    </aside>
  );
}

function Topbar({ title, crumbs = [], onToggleSidebar }) {
  return (
    <div className="topbar">
      <div className="topbar-left" style={{ display: "flex", alignItems: "center", gap: 16 }}>
        <button className="icon-btn" onClick={onToggleSidebar}><i className="fas fa-bars"></i></button>
        <div>
          {crumbs.length > 0 && (
            <div className="crumbs">
              {crumbs.map((c, i) => (
                <span key={i}>
                  <span>{c}</span>
                  {i < crumbs.length - 1 && <span className="sep">/</span>}
                </span>
              ))}
            </div>
          )}
          <h1>{title}</h1>
        </div>
      </div>
      <div className="topbar-right">
        <button className="icon-btn"><i className="fas fa-search"></i></button>
        <button className="icon-btn">
          <i className="fas fa-bell"></i>
          <span className="dot"></span>
        </button>
        <div className="user-chip">
          <Avatar initials="AF" size={32} />
          <div className="meta">
            <div className="name">Adi Firmansyah</div>
            <div className="role">Admin · Witel Sulbagsel</div>
          </div>
          <i className="fas fa-chevron-down" style={{ color: "var(--fg-3)", fontSize: 11 }}></i>
        </div>
      </div>
    </div>
  );
}

Object.assign(window, { Sidebar, Topbar });
