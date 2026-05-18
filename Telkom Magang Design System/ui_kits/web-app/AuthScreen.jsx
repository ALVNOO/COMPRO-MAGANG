// AuthScreen — split-panel login (red left, form right)
function AuthScreen({ onLogin }) {
  return (
    <div className="auth-page">
      <div className="auth-wrap">
        <div className="auth-left">
          <div className="auth-illust">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
              <polyline points="10 17 15 12 10 7" />
              <line x1="15" y1="12" x2="3" y2="12" />
            </svg>
          </div>
          <h2>Selamat Datang Kembali</h2>
          <p className="sub">Masuk untuk melanjutkan perjalanan magang Anda di PT Telkom Indonesia.</p>
          <ul className="auth-features">
            <li>
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" /><polyline points="22 4 12 14.01 9 11.01" />
              </svg>
              Tracking pengajuan secara real-time
            </li>
            <li>
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" /><polyline points="22 4 12 14.01 9 11.01" />
              </svg>
              Komunikasi langsung dengan mentor
            </li>
            <li>
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" /><polyline points="22 4 12 14.01 9 11.01" />
              </svg>
              Kelola dokumen, presensi, dan tugas
            </li>
          </ul>
        </div>

        <div className="auth-right">
          <a href="#" className="logo">
            <img src="../../assets/logos/telkom-indonesia-logo.png" alt="Telkom Indonesia" />
          </a>
          <h1>Masuk</h1>
          <p className="lead-sub">Masukkan kredensial Anda untuk mengakses akun.</p>

          <form className="auth-form" onSubmit={(e) => { e.preventDefault(); onLogin(); }}>
            <Field label="Username atau Email" required icon="fas fa-user" placeholder="Masukkan username atau email" defaultValue="adi.firmansyah" />
            <Field label="Password" required icon="fas fa-lock" type="password" placeholder="Masukkan password" defaultValue="••••••••" />

            <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", fontSize: 13 }}>
              <label style={{ display: "flex", alignItems: "center", gap: 8, color: "var(--fg-2)", cursor: "pointer" }}>
                <input type="checkbox" defaultChecked /> Ingat saya
              </label>
              <a href="#" style={{ color: "var(--color-primary)", fontWeight: 600 }}>Lupa password?</a>
            </div>

            <Btn variant="primary" iconRight="fas fa-arrow-right">Masuk</Btn>
          </form>

          <div className="auth-footer">
            Belum punya akun? <a href="#">Daftar sekarang</a>
          </div>
        </div>
      </div>
    </div>
  );
}

Object.assign(window, { AuthScreen });
