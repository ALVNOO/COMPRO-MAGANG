// Main app shell — switches between login and dashboard screens
function App() {
  const [screen, setScreen] = React.useState("login"); // login | dashboard | applications
  const [collapsed, setCollapsed] = React.useState(false);

  if (screen === "login") {
    return (
      <>
        <div className="dashboard-bg">
          <div className="orb orb-1"></div>
          <div className="orb orb-2"></div>
          <div className="orb orb-3"></div>
          <div className="grid-bg"></div>
        </div>
        <AuthScreen onLogin={() => setScreen("dashboard")} />
      </>
    );
  }

  const titles = {
    dashboard:    { title: "Dashboard",       crumbs: ["Telkom Magang", "Dashboard"] },
    applications: { title: "Pengajuan",       crumbs: ["Telkom Magang", "Pengajuan"] },
    participants: { title: "Peserta",         crumbs: ["Telkom Magang", "Peserta"] },
    divisions:    { title: "Divisi",          crumbs: ["Telkom Magang", "Divisi"] },
    mentors:      { title: "Pembimbing",      crumbs: ["Telkom Magang", "Pembimbing"] },
    attendance:   { title: "Presensi",        crumbs: ["Telkom Magang", "Operasional", "Presensi"] },
    logbook:      { title: "Logbook",         crumbs: ["Telkom Magang", "Operasional", "Logbook"] },
    assignments:  { title: "Tugas",           crumbs: ["Telkom Magang", "Operasional", "Tugas"] },
    reports:      { title: "Laporan",         crumbs: ["Telkom Magang", "Operasional", "Laporan"] },
    settings:     { title: "Pengaturan",      crumbs: ["Telkom Magang", "Pengaturan"] },
  };
  const meta = titles[screen] || titles.dashboard;

  return (
    <>
      <div className="dashboard-bg">
        <div className="orb orb-1"></div>
        <div className="orb orb-2"></div>
        <div className="orb orb-3"></div>
        <div className="orb orb-4"></div>
        <div className="grid-bg"></div>
      </div>
      <div className="app">
        <Sidebar active={screen} onNavigate={(id) => {
          if (id === "login") setScreen("login");
          else setScreen(id);
        }} collapsed={collapsed} />

        <main className={`main ${collapsed ? "collapsed" : ""}`}>
          <Topbar title={meta.title} crumbs={meta.crumbs} onToggleSidebar={() => setCollapsed(c => !c)} />
          <div className="content">
            {screen === "dashboard"    && <DashboardScreen />}
            {screen === "applications" && <ApplicationsScreen />}
            {!["dashboard", "applications"].includes(screen) && (
              <div className="glass" style={{ padding: 56, textAlign: "center", color: "var(--fg-3)" }}>
                <i className="fas fa-tools" style={{ fontSize: 40, color: "var(--color-primary)", marginBottom: 14 }}></i>
                <div style={{ fontWeight: 700, fontSize: 18, color: "var(--fg-1)", marginBottom: 6 }}>Halaman {meta.title}</div>
                <div style={{ fontSize: 14, maxWidth: 420, margin: "0 auto" }}>
                  UI kit demo. Konten lengkap untuk halaman ini ada di source Laravel di <code>reference/views/</code>.
                </div>
                <div style={{ marginTop: 18, display: "flex", justifyContent: "center", gap: 10 }}>
                  <Btn variant="primary" onClick={() => setScreen("dashboard")} icon="fas fa-arrow-left">Kembali ke Dashboard</Btn>
                </div>
              </div>
            )}
          </div>
        </main>
      </div>
    </>
  );
}

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<App />);
