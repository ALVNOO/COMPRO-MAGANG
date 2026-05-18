// Shared atoms — buttons, badges, status badges, cards
const { useState } = React;

function Btn({ variant = "primary", size = "md", icon, iconRight, children, ...props }) {
  const cls = ["btn", `btn-${variant}`, size === "sm" ? "btn-sm" : ""].filter(Boolean).join(" ");
  return (
    <button className={cls} {...props}>
      {icon && <i className={icon}></i>}
      {children}
      {iconRight && <i className={iconRight}></i>}
    </button>
  );
}

function Badge({ variant = "gray", icon, children }) {
  return (
    <span className={`badge badge-${variant}`}>
      {icon && <i className={icon}></i>}
      {children}
    </span>
  );
}

// Application / attendance status with bilingual labels (Indonesian)
const STATUS_MAP = {
  pending:   { v: "warning", i: "fas fa-clock",          l: "Menunggu" },
  accepted:  { v: "success", i: "fas fa-check",          l: "Diterima" },
  rejected:  { v: "danger",  i: "fas fa-times",          l: "Ditolak" },
  active:    { v: "primary", i: "fas fa-play",           l: "Aktif" },
  finished:  { v: "gray",    i: "fas fa-flag-checkered", l: "Selesai" },
  present:   { v: "success", i: "fas fa-check-circle",   l: "Hadir" },
  late:      { v: "warning", i: "fas fa-clock",          l: "Terlambat" },
  absent:    { v: "danger",  i: "fas fa-times-circle",   l: "Tidak Hadir" },
  leave:     { v: "info",    i: "fas fa-file-alt",       l: "Izin" },
};
function StatusBadge({ status, label }) {
  const s = STATUS_MAP[status] || STATUS_MAP.pending;
  return <Badge variant={s.v} icon={s.i}>{label || s.l}</Badge>;
}

function Avatar({ initials, size = 32, gradient = true }) {
  return (
    <div style={{
      width: size, height: size, borderRadius: 9999,
      background: gradient ? "var(--gradient-primary)" : "var(--color-gray-300)",
      color: "#fff", display: "flex", alignItems: "center", justifyContent: "center",
      fontWeight: 600, fontSize: size <= 32 ? 12 : size <= 48 ? 16 : 22,
      flexShrink: 0,
    }}>{initials}</div>
  );
}

function StatCard({ tone = "primary", icon, value, label, trend }) {
  return (
    <div className={`stat stat-${tone}`}>
      <div className="ic"><i className={icon}></i></div>
      <div className="val">{value}</div>
      <div className="lbl">{label}</div>
      {trend && (
        <div className="trend up">
          <i className="fas fa-arrow-up"></i>
          <span>{trend}</span>
        </div>
      )}
    </div>
  );
}

function Field({ label, required, icon, type = "text", placeholder, defaultValue, error }) {
  const [show, setShow] = useState(false);
  const isPw = type === "password";
  const inputType = isPw ? (show ? "text" : "password") : type;
  return (
    <div className="field">
      {label && <label className={required ? "req" : ""}>{label}</label>}
      <div className="iw">
        {icon && <i className={icon}></i>}
        <input
          type={inputType}
          className={`input ${icon ? "" : "no-icon"}`}
          placeholder={placeholder}
          defaultValue={defaultValue}
          style={error ? { borderColor: "var(--color-danger)", boxShadow: "0 0 0 3px var(--color-danger-light)" } : null}
        />
        {isPw && (
          <button type="button" className="pw-toggle" onClick={() => setShow(s => !s)}>
            <i className={show ? "fas fa-eye-slash" : "fas fa-eye"}></i>
          </button>
        )}
      </div>
      {error && <span style={{ fontSize: 13, color: "var(--color-danger)" }}>{error}</span>}
    </div>
  );
}

Object.assign(window, { Btn, Badge, StatusBadge, Avatar, StatCard, Field, STATUS_MAP });
