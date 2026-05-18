// DashboardScreen — admin dashboard: hero greeting + stat grid + applications table + activity
const SAMPLE_APPLICATIONS = [
  { id: 1, initials: "AF", name: "Ahmad Fauzi Rahman",   uni: "Politeknik Negeri Ujung Pandang",   division: "Network Operations",  date: "18 Mei 2026", status: "pending"  },
  { id: 2, initials: "SN", name: "Siti Nurhaliza",       uni: "Universitas Hasanuddin",            division: "Digital Service",     date: "17 Mei 2026", status: "accepted" },
  { id: 3, initials: "BS", name: "Budi Santoso",         uni: "Universitas Negeri Makassar",       division: "Customer Care",       date: "15 Mei 2026", status: "finished" },
  { id: 4, initials: "DK", name: "Dewi Kartika",         uni: "Universitas Muslim Indonesia",      division: "IT Infrastructure",   date: "14 Mei 2026", status: "active"   },
  { id: 5, initials: "RP", name: "Rangga Pratama",       uni: "Politeknik Negeri Ujung Pandang",   division: "Marketing Comm.",     date: "12 Mei 2026", status: "rejected" },
];

const ACTIVITY = [
  { t: "5 menit lalu",   icon: "fas fa-check-circle",   tone: "success", text: "Anda menyetujui pengajuan dari Siti Nurhaliza" },
  { t: "32 menit lalu",  icon: "fas fa-file-upload",    tone: "info",    text: "Dewi Kartika mengunggah logbook minggu ke-3" },
  { t: "1 jam lalu",     icon: "fas fa-user-plus",      tone: "primary", text: "Pengajuan baru dari Ahmad Fauzi Rahman" },
  { t: "3 jam lalu",     icon: "fas fa-clipboard-check",tone: "success", text: "Rangga Pratama menyelesaikan tugas final" },
  { t: "Kemarin",        icon: "fas fa-times-circle",   tone: "danger",  text: "Anda menolak pengajuan dari kandidat dengan dokumen tidak lengkap" },
];

function HeroGreeting() {
  return (
    <div className="glass" style={{ marginBottom: 22, padding: 28, display: "flex", justifyContent: "space-between", alignItems: "center", gap: 24 }}>
      <div>
        <div className="eyebrow" style={{ marginBottom: 8 }}>Selasa, 12 Mei 2026</div>
        <h2 style={{ margin: 0, fontSize: 26, fontWeight: 700, letterSpacing: "-.015em" }}>Selamat pagi, Adi 👋</h2>
        <p style={{ margin: "6px 0 0", color: "var(--fg-2)", fontSize: 15, lineHeight: 1.55, maxWidth: 540 }}>
          Anda memiliki <strong style={{ color: "var(--color-primary)" }}>17 pengajuan</strong> menunggu peninjauan dan <strong style={{ color: "var(--color-primary)" }}>4 logbook</strong> yang belum dikomentari oleh mentor.
        </p>
      </div>
      <div style={{ display: "flex", gap: 10, flexShrink: 0 }}>
        <Btn variant="secondary" icon="fas fa-download">Ekspor</Btn>
        <Btn variant="primary" icon="fas fa-plus">Tambah Peserta</Btn>
      </div>
    </div>
  );
}

function StatGrid() {
  return (
    <div style={{ display: "grid", gridTemplateColumns: "repeat(4, 1fr)", gap: 16, marginBottom: 22 }}>
      <StatCard tone="primary" icon="fas fa-users"        value="142" label="Total Peserta"        trend="+12 minggu ini" />
      <StatCard tone="success" icon="fas fa-check-circle" value="38"  label="Pengajuan Diterima"   trend="+5 hari ini" />
      <StatCard tone="warning" icon="fas fa-clock"        value="17"  label="Menunggu Tinjauan" />
      <StatCard tone="info"    icon="fas fa-graduation-cap" value="24"  label="Aktif Magang" />
    </div>
  );
}

function ApplicationsTable() {
  return (
    <div className="glass">
      <div className="glass-h">
        <div className="glass-icon"><i className="fas fa-file-alt"></i></div>
        <div style={{ flex: 1 }}>
          <h3>Pengajuan Terbaru</h3>
          <div className="sub">5 dari 17 menunggu tinjauan</div>
        </div>
        <div style={{ display: "flex", gap: 8 }}>
          <Btn variant="ghost" size="sm" icon="fas fa-filter">Filter</Btn>
          <Btn variant="ghost" size="sm">Lihat semua →</Btn>
        </div>
      </div>
      <div className="glass-b" style={{ padding: 0 }}>
        <table className="tbl">
          <thead>
            <tr>
              <th>Pemohon</th>
              <th>Divisi Tujuan</th>
              <th>Tanggal Pengajuan</th>
              <th>Status</th>
              <th style={{ textAlign: "right" }}>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {SAMPLE_APPLICATIONS.map(a => (
              <tr key={a.id}>
                <td>
                  <div className="person">
                    <Avatar initials={a.initials} size={36} />
                    <div>
                      <div className="nm">{a.name}</div>
                      <div className="sub">{a.uni}</div>
                    </div>
                  </div>
                </td>
                <td style={{ color: "var(--fg-2)" }}>{a.division}</td>
                <td style={{ color: "var(--fg-2)" }}>{a.date}</td>
                <td><StatusBadge status={a.status} /></td>
                <td style={{ textAlign: "right" }}>
                  <button className="icon-btn" style={{ width: 32, height: 32 }}><i className="fas fa-ellipsis-h" style={{ fontSize: 13 }}></i></button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}

function ActivityFeed() {
  const toneStyle = { success: "var(--color-success)", info: "var(--color-info)", primary: "var(--color-primary)", danger: "var(--color-danger)" };
  const toneBg = { success: "var(--color-success-light)", info: "var(--color-info-light)", primary: "var(--color-primary-100)", danger: "var(--color-danger-light)" };
  return (
    <div className="glass" style={{ height: "100%" }}>
      <div className="glass-h">
        <div className="glass-icon" style={{ background: "linear-gradient(135deg, #6366F1, #4F46E5)" }}><i className="fas fa-history"></i></div>
        <div>
          <h3>Aktivitas Terkini</h3>
          <div className="sub">Riwayat tindakan Anda</div>
        </div>
      </div>
      <div className="glass-b" style={{ display: "flex", flexDirection: "column", gap: 14 }}>
        {ACTIVITY.map((a, i) => (
          <div key={i} style={{ display: "flex", gap: 12, alignItems: "flex-start" }}>
            <div style={{ width: 36, height: 36, borderRadius: 10, background: toneBg[a.tone], color: toneStyle[a.tone], display: "flex", alignItems: "center", justifyContent: "center", flexShrink: 0 }}>
              <i className={a.icon}></i>
            </div>
            <div style={{ flex: 1, lineHeight: 1.4 }}>
              <div style={{ fontSize: 13.5, color: "var(--fg-1)" }}>{a.text}</div>
              <div style={{ fontSize: 12, color: "var(--fg-3)", marginTop: 3 }}>{a.t}</div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

function DashboardScreen() {
  return (
    <div>
      <HeroGreeting />
      <StatGrid />
      <div style={{ display: "grid", gridTemplateColumns: "minmax(0, 2fr) minmax(0, 1fr)", gap: 18 }}>
        <ApplicationsTable />
        <ActivityFeed />
      </div>
    </div>
  );
}

Object.assign(window, { DashboardScreen });
