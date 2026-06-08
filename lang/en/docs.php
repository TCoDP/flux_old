<?php

return [
    'eyebrow' => 'Documentation',
    'title' => 'Help & setup center',
    'subtitle' => 'Step-by-step guides to set up a secure connection on all popular platforms.',
    'search_placeholder' => 'Search platform…',
    'all_platforms' => 'All platforms',
    'setup_time' => 'Setup ~3 minutes',
    'steps_title' => 'Step-by-step guide',
    'screenshot' => 'Step illustration',
    'download' => 'Download app',
    'platform_faq' => 'Common questions',
    'config_title' => 'Connection details',
    'config_hint' => 'Up-to-date details are available in your dashboard under "Connections".',
    'config_server' => 'Server address',
    'config_token' => 'Connection key',
    'need_help' => 'Could not set it up?',
    'need_help_text' => 'Our support works around the clock and will help you set up on any device.',
    'contact_support' => 'Contact support',

    'platforms' => [
        'windows' => [
            'name' => 'Windows',
            'intro' => 'Set up the Flux secure connection on a Windows 10 or 11 computer in a few steps.',
            'steps' => [
                ['title' => 'Download the app', 'text' => 'Download the official Flux app for Windows from this page and run the installer.'],
                ['title' => 'Install', 'text' => 'Follow the setup wizard and wait for it to finish.'],
                ['title' => 'Sign in', 'text' => 'Open the app and sign in with your Flux dashboard email and password.'],
                ['title' => 'Connect', 'text' => 'Pick a region and press connect. Your secure connection is active.'],
            ],
            'faq' => [
                ['q' => 'The app will not start', 'a' => 'Make sure Windows is up to date and run the app as administrator.'],
                ['q' => 'How to enable auto-start', 'a' => 'In the app settings, enable "Launch on system startup".'],
            ],
        ],
        'macos' => [
            'name' => 'macOS',
            'intro' => 'Install Flux on a Mac with Apple Silicon or Intel and stay secure online.',
            'steps' => [
                ['title' => 'Download the app', 'text' => 'Download the Flux app for macOS and open the .dmg file.'],
                ['title' => 'Move to Applications', 'text' => 'Drag the Flux icon into Applications and launch it.'],
                ['title' => 'Sign in', 'text' => 'Sign in with your Flux dashboard credentials.'],
                ['title' => 'Allow & connect', 'text' => 'Confirm adding the configuration in system settings and press "Connect".'],
            ],
            'faq' => [
                ['q' => 'The system blocks the app', 'a' => 'Open System Settings → Privacy & Security and allow the Flux app to run.'],
            ],
        ],
        'linux' => [
            'name' => 'Linux',
            'intro' => 'Flux supports popular Linux distributions. Set up via the app or manually.',
            'steps' => [
                ['title' => 'Install the package', 'text' => 'Download the package for your distro (.deb or .rpm) and install it via your package manager.'],
                ['title' => 'Launch Flux', 'text' => 'Open the app from the menu or via the terminal.'],
                ['title' => 'Sign in', 'text' => 'Sign in with your dashboard credentials or import a connection profile.'],
                ['title' => 'Activate', 'text' => 'Pick a region and enable the secure connection.'],
            ],
            'faq' => [
                ['q' => 'No graphical shell', 'a' => 'Use the console client and import the connection details from the "Connections" section.'],
            ],
        ],
        'android' => [
            'name' => 'Android',
            'intro' => 'Protect your Android phone or tablet with the Flux app.',
            'steps' => [
                ['title' => 'Install the app', 'text' => 'Download the Flux app from RuStore or Google Play and open it.'],
                ['title' => 'Sign in', 'text' => 'Enter your Flux dashboard email and password.'],
                ['title' => 'Allow connection', 'text' => 'Confirm the system prompt to create a secure connection.'],
                ['title' => 'Connect', 'text' => 'Pick a region and press connect.'],
            ],
            'faq' => [
                ['q' => 'Connection drops in background', 'a' => 'Disable battery optimization for the Flux app in system settings.'],
            ],
        ],
        'ios' => [
            'name' => 'iPhone / iPad',
            'intro' => 'Set up Flux on Apple devices running iOS and iPadOS.',
            'steps' => [
                ['title' => 'Install the app', 'text' => 'Download the Flux app from the App Store and open it.'],
                ['title' => 'Sign in', 'text' => 'Sign in with your dashboard credentials.'],
                ['title' => 'Add configuration', 'text' => 'Allow the app to add a secure connection configuration.'],
                ['title' => 'Connect', 'text' => 'Pick a region and activate the connection with one tap.'],
            ],
            'faq' => [
                ['q' => 'Password prompt when adding', 'a' => 'This is an iOS system prompt to confirm the setup. Enter your device passcode.'],
            ],
        ],
        'android-tv' => [
            'name' => 'Android TV',
            'intro' => 'Install Flux on an Android TV box or television.',
            'steps' => [
                ['title' => 'Open the app store', 'text' => 'On your Android TV, open the app store and search for Flux.'],
                ['title' => 'Install & open', 'text' => 'Install the app and launch it from the home screen.'],
                ['title' => 'Sign in', 'text' => 'Enter your dashboard credentials using the remote.'],
                ['title' => 'Connect', 'text' => 'Pick a region and activate the secure connection.'],
            ],
            'faq' => [
                ['q' => 'App not in the store', 'a' => 'Install from the official file or use the connection details from your dashboard.'],
            ],
        ],
        'smart-tv' => [
            'name' => 'Smart TV',
            'intro' => 'Get secure access to online services on your Smart TV.',
            'steps' => [
                ['title' => 'Check compatibility', 'text' => 'Make sure your TV supports installing apps or network-level connection setup.'],
                ['title' => 'Set up the connection', 'text' => 'Install the Flux app or configure it on your router to protect all TV traffic.'],
                ['title' => 'Enter details', 'text' => 'Use the server address and connection key from the "Connections" section.'],
                ['title' => 'Verify access', 'text' => 'Open the online service you need and confirm the connection is stable.'],
            ],
            'faq' => [
                ['q' => 'My TV does not support apps', 'a' => 'Set up the secure connection on your router — it protects all connected devices, including the TV.'],
            ],
        ],
        'routers' => [
            'name' => 'Routers',
            'intro' => 'Set up Flux on your router to protect every device on your home network at once.',
            'steps' => [
                ['title' => 'Open the router panel', 'text' => 'Log into your router\'s web interface via a browser.'],
                ['title' => 'Add a profile', 'text' => 'In the network connections section, create a new secure connection profile.'],
                ['title' => 'Enter details', 'text' => 'Provide the server address and connection key from your Flux dashboard.'],
                ['title' => 'Save & verify', 'text' => 'Save the settings and confirm your devices run through the secure connection.'],
            ],
            'faq' => [
                ['q' => 'Which routers are supported', 'a' => 'Routers that support custom network profiles will work. Support can help with your specific model.'],
            ],
        ],
    ],
];
