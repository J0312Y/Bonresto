import { useState } from "react";

interface Option {
  value: string;
  label: string;
}

interface SelectProps {
  options: Option[];
  placeholder?: string;
  onChange: (value: string) => void;
  className?: string;
  defaultValue?: string;
  value?: string;
  label?: string;
  disabled?: boolean;
}

const Select: React.FC<SelectProps> = ({
  options,
  placeholder = "Sélectionner…",
  onChange,
  className = "",
  defaultValue = "",
  value,
  label,
  disabled = false,
}) => {
  const [selectedValue, setSelectedValue] = useState<string>(defaultValue);

  const current = value !== undefined ? value : selectedValue;

  const handleChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const v = e.target.value;
    setSelectedValue(v);
    onChange(v);
  };

  return (
    <div className={`flex flex-col gap-1.5 ${className}`}>
      {label && (
        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">
          {label}
        </label>
      )}
      <div className="relative">
        <select
          value={current}
          onChange={handleChange}
          disabled={disabled}
          className={`
            w-full appearance-none rounded-xl border px-4 py-2.5 pr-10 text-sm
            shadow-sm transition-all duration-150 outline-none cursor-pointer
            ${current
              ? "text-gray-800 dark:text-white"
              : "text-gray-400 dark:text-gray-500"
            }
            ${disabled
              ? "border-gray-200 bg-gray-50 cursor-not-allowed opacity-60 dark:border-gray-700 dark:bg-gray-800"
              : "border-gray-300 bg-white hover:border-brand-400 focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-600 dark:focus:border-brand-500"
            }
            dark:text-white/90
          `}
        >
          <option value="" disabled className="text-gray-400 dark:bg-gray-900">
            {placeholder}
          </option>
          {options.map((opt) => (
            <option
              key={opt.value}
              value={opt.value}
              className="text-gray-800 dark:bg-gray-900 dark:text-white"
            >
              {opt.label}
            </option>
          ))}
        </select>

        {/* Custom chevron */}
        <span className="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path
              d="M4 6l4 4 4-4"
              stroke="currentColor"
              strokeWidth="1.5"
              strokeLinecap="round"
              strokeLinejoin="round"
            />
          </svg>
        </span>
      </div>
    </div>
  );
};

export default Select;
