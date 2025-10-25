import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // Root level files
        "./*.html",
        "./*.php",

        // Laravel specific paths
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",

        // Resources directory - comprehensive scan
        "./resources/**/*.blade.php",
        "./resources/**/*.html",
        "./resources/**/*.js",
        "./resources/**/*.ts",
        "./resources/**/*.jsx",
        "./resources/**/*.tsx",
        "./resources/**/*.vue",
        "./resources/**/*.php",

        // Public directory for any HTML/JS files
        "./public/*.html",
        "./public/**/*.js",

        // Admin specific paths
        "./resources/views/admin/**/*.blade.php",
        "./resources/views/**/*.blade.php",

        // Any other potential locations
        "./app/**/*.php",
        "./routes/**/*.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'retail-green': '#22c55e',
                'retail-blue': '#2196f3',
                'dark-bg': '#1f2937', // Changed from #0a0a0a to lighter gray
                'dark-surface': '#1a1a1a',
                'dark-border': '#333333',
                // Admin page colors
                'neon-blue': '#00bcd4',
                'neon-cyan': '#00e676',
                'cyan': {
                    50: '#ecfeff',
                    100: '#cffafe',
                    200: '#a5f3fc',
                    300: '#67e8f9',
                    400: '#22d3ee',
                },
                'gray': {
                    50: '#f9fafb',
                    100: '#f3f4f6',
                    200: '#e5e7eb',
                    300: '#d1d5db',
                    400: '#9ca3af',
                    500: '#6b7280',
                }
            },
            animation: {
                'glow-pulse': 'glow-pulse 3s ease-in-out infinite alternate',
                'float': 'float 4s ease-in-out infinite',
                'pulse': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'fade': 'fade 6s ease-in-out infinite',
                'slow-pulse': 'slow-pulse 8s ease-in-out infinite',
                'subtle-glow': 'subtle-glow 8s ease-in-out infinite alternate',
            },
            keyframes: {
                'glow-pulse': {
                    '0%': { boxShadow: '0 0 10px #4fc3f7, 0 0 20px #4fc3f7' },
                    '100%': { boxShadow: '0 0 5px #4fc3f7, 0 0 10px #4fc3f7' }
                },
                'fade': {
                    '0%, 100%': { opacity: '0.03' },
                    '50%': { opacity: '0.06' }
                },
                'slow-pulse': {
                    '0%, 100%': { opacity: '0.04', transform: 'scale(1)' },
                    '50%': { opacity: '0.08', transform: 'scale(1.01)' }
                },
                'subtle-glow': {
                    '0%': { boxShadow: '0 0 6px rgba(79, 195, 247, 0.08)' },
                    '100%': { boxShadow: '0 0 12px rgba(79, 195, 247, 0.12)' }
                },
                'float': {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-10px)' }
                }
            }
        },
    },
    plugins: [],
};
