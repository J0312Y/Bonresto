import { useState } from "react";

// Generates a deterministic color from business name
function nameToColor(name: string): string {
  const colors = [
    "#37a000", "#2563eb", "#7c3aed", "#db2777",
    "#ea580c", "#0891b2", "#059669", "#d97706",
  ];
  let hash = 0;
  for (let i = 0; i < name.length; i++) {
    hash = name.charCodeAt(i) + ((hash << 5) - hash);
  }
  return colors[Math.abs(hash) % colors.length];
}

function initials(name: string): string {
  return name
    .split(" ")
    .filter(Boolean)
    .slice(0, 2)
    .map((w) => w[0].toUpperCase())
    .join("");
}

interface Props {
  name: string;
  logoUrl?: string | null;
  size?: number; // px, default 40
  className?: string;
}

export function ClientAvatar({ name, logoUrl, size = 40, className = "" }: Props) {
  const [imgError, setImgError] = useState(false);

  const showImg = logoUrl && !imgError;
  const bg = nameToColor(name);
  const text = initials(name);

  return (
    <span
      className={`inline-flex shrink-0 items-center justify-center overflow-hidden rounded-full font-bold text-white select-none ${className}`}
      style={{
        width: size,
        height: size,
        fontSize: size * 0.38,
        background: showImg ? "transparent" : bg,
      }}
    >
      {showImg ? (
        <img
          src={logoUrl!}
          alt={name}
          className="h-full w-full object-cover"
          onError={() => setImgError(true)}
        />
      ) : (
        text
      )}
    </span>
  );
}
