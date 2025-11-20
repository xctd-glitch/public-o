<?php
declare(strict_types=1);

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: 0');

?><!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="theme-color" content="#f6f7f9">
    <meta name="color-scheme" content="dark light">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="/assets/icons/icon.svg">
    <link rel="apple-touch-icon" href="/assets/icons/icon-maskable.svg">
    <title><?= htmlspecialchars($pageTitle ?? 'SRP Traffic Control', ENT_QUOTES, 'UTF-8'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                container: {
                    center: true,
                    padding: "1.25rem",
                    screens: { "2xl": "1400px" }
                },
                extend: {
                    colors: {
                        border: "hsl(240 5.9% 90%)",
                        input: "hsl(240 5.9% 90%)",
                        ring: "hsl(240 5.9% 10%)",
                        background: "hsl(210 20% 97%)",
                        foreground: "hsl(240 10% 3.9%)",
                        primary: {
                            DEFAULT: "hsl(240 5.9% 10%)",
                            foreground: "hsl(0 0% 98%)"
                        },
                        secondary: {
                            DEFAULT: "hsl(240 4.8% 95.9%)",
                            foreground: "hsl(240 5.9% 10%)"
                        },
                        destructive: {
                            DEFAULT: "hsl(0 84.2% 60.2%)",
                            foreground: "hsl(0 0% 98%)"
                        },
                        muted: {
                            DEFAULT: "hsl(240 4.8% 95.9%)",
                            foreground: "hsl(240 3.8% 46.1%)"
                        },
                        popover: {
                            DEFAULT: "hsl(0 0% 100%)",
                            foreground: "hsl(240 10% 3.9%)"
                        },
                        card: {
                            DEFAULT: "hsl(0 0% 100%)",
                            foreground: "hsl(240 10% 3.9%)"
                        }
                    },
                    borderRadius: {
                        lg: "0.75rem",
                        md: "0.5rem",
                        sm: "0.375rem"
                    },
                    fontFamily: {
                        sans: [
                            "system-ui",
                            "-apple-system",
                            "BlinkMacSystemFont",
                            '"Segoe UI"',
                            "Roboto",
                            "Oxygen",
                            "Ubuntu",
                            "Cantarell",
                            '"Fira Sans"',
                            '"Droid Sans"',
                            '"Helvetica Neue"',
                            "sans-serif"
                        ]
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" type="text/css" href="/assets/style.css?v=<?= time(); ?>" id="preload-stylesheet"/>
    <script src="/pwa/register-sw.js?v=<?= time(); ?>" defer></script>
</head>
<body class="min-h-screen bg-background text-foreground font-sans antialiased flex flex-col text-sm">

