// ApplicationsScreen — fuller table view with filter chips
function ApplicationsScreen() {
  const data = [
    ...SAMPLE_APPLICATIONS,
    { id: 6, initials: "MH", name: "Mira Handayani",     uni: "Universitas Hasanuddin",            division: "Finance Operations",  date: "10 Mei 2026", status: "active"   },
    { id: 7, initials: "AS", name: "Aditya Surya",       uni: "Politeknik Negeri Ujung Pandang",   division: "Network Operations",  date: "08 Mei 2026", status: "accepted" },
    { id: 8, initials: "LP", name: "Laras Putri",        uni: "Universitas Negeri Makassar",       division: "Digital Service",     date: "06 Mei 2026", status: "finished" },
  ];
  const [filter, setFilter] = React.useState("all");
  const filtered = filter === "all" ? data : data.filter(a => a.status === filter);

  const Chip = ({ id, label, count }) => (
    <button
      onClick={() => setFilter(id)}
      style={{
        padding: "8px 14px", border: "1px solid", borderRadius: 10, fontSize: 13, fontWeight: 600, cursor: "pointer",
        background: filter === id ? "var(--color-primary)" : "#fff",
        borderColor: filter === id ? "var(--color-primary)" : "var(--border-default)",
        color: filter === id ? "#fff" : "var(--fg-2)",
        display: "inline-flex", alignItems: "center", gap: 8, fontFamily: "inherit",
      }}>
      {label}
      <span style={{
        fontSize: 11, padding: "1px 7px", borderRadius: 9999,
        background: filter === id ? "rgba(255,255,255,.2)" : "var(--color-gray-100)",
        color: filter === id ? "#fff" : "var(--fg-3)",
      }}>{count}</span>
    </button>
  );

  return (
    <div className="glass">
      <div className="glass-h">
        <div className="glass-icon"><i className="fas fa-file-alt"></i></div>
        <div style={{ flex: 1 }}>
          <h3>Semua Pengajuan</h3>
          <div className="sub">Kelola, tinjau, dan setujui pengajuan magang</div>
        </div>
        <Btn variant="primary" size="sm" icon="fas fa-download">Ekspor Excel</Btn>
      </div>

      <div style={{ padding: "16px 22px", display: "flex", gap: 8, flexWrap: "wrap", borderBottom: "1px solid rgba(0,0,0,.05)" }}>
        <Chip id="all"      label="Semua"    count={data.length} />
        <Chip id="pending"  label="Menunggu" count={data.filter(d => d.status === "pending").length} />
        <Chip id="accepted" label="Diterima" count={data.filter(d => d.status === "accepted").length} />
        <Chip id="active"   label="Aktif"    count={data.filter(d => d.status === "active").length} />
        <Chip id="finished" label="Selesai"  count={data.filter(d => d.status === "finished").length} />
        <Chip id="rejected" label="Ditolak"  count={data.filter(d => d.status === "rejected").length} />
      </div>

      <div className="glass-b" style={{ padding: 0 }}>
        <table className="tbl">
          <thead>
            <tr>
              <th style={{ width: 32 }}><input type="checkbox" /></th>
              <th>Pemohon</th>
              <th>Divisi Tujuan</th>
              <th>Tanggal Pengajuan</th>
              <th>Status</th>
              <th style={{ textAlign: "right" }}>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {filtered.map(a => (
              <tr key={a.id}>
                <td><input type="checkbox" /></td>
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
                  <div style={{ display: "inline-flex", gap: 6 }}>
                    {a.status === "pending" && (
                      <>
                        <Btn variant="ghost" size="sm" icon="fas fa-check">Setujui</Btn>
                        <Btn variant="ghost" size="sm" icon="fas fa-times" style={{ color: "var(--color-danger)" }}>Tolak</Btn>
                      </>
                    )}
                    <button className="icon-btn" style={{ width: 32, height: 32 }}><i className="fas fa-ellipsis-h" style={{ fontSize: 13 }}></i></button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        {filtered.length === 0 && (
          <div style={{ padding: 56, textAlign: "center", color: "var(--fg-3)" }}>
            <i className="fas fa-inbox" style={{ fontSize: 36, marginBottom: 12 }}></i>
            <div style={{ fontWeight: 600, color: "var(--fg-1)", marginBottom: 4 }}>Tidak ada pengajuan</div>
            <div style={{ fontSize: 14 }}>Belum ada pengajuan dengan status ini.</div>
          </div>
        )}
      </div>

      <div style={{ padding: "14px 22px", display: "flex", justifyContent: "space-between", alignItems: "center", borderTop: "1px solid rgba(0,0,0,.05)", fontSize: 13, color: "var(--fg-3)" }}>
        <span>Menampilkan {filtered.length} dari {data.length} pengajuan</span>
        <div style={{ display: "flex", gap: 6 }}>
          <button className="icon-btn" style={{ width: 32, height: 32 }}><i className="fas fa-chevron-left" style={{ fontSize: 12 }}></i></button>
          <button className="icon-btn" style={{ width: 32, height: 32, background: "var(--color-primary)", color: "#fff", borderColor: "var(--color-primary)" }}>1</button>
          <button className="icon-btn" style={{ width: 32, height: 32 }}>2</button>
          <button className="icon-btn" style={{ width: 32, height: 32 }}><i className="fas fa-chevron-right" style={{ fontSize: 12 }}></i></button>
        </div>
      </div>
    </div>
  );
}

Object.assign(window, { ApplicationsScreen });
