<?php
DEFINE("ART_ICON", [
    // Status Indicators
    "info" => "ℹ️",              // Information or help
    "check" => "✅",             // Confirmation or completed task
    "cross" => "❌",             // Cancel or failure
    "warning" => "⚠️",          // Alert or caution
    "success" => "✔️",          // Successful action
    "error" => "❗",             // Error or issue
    "question" => "❓",          // Query or help needed
    "exclamation" => "❗",       // Urgent attention
    "pending" => "⏳",           // Task in progress or waiting
    "blocked" => "🚫",          // Restricted or blocked action
    "verified" => "🛡️",         // Verified or secure
    "new" => "🆕",              // New item or feature
    "offline" => "🌐",           // Offline mode or no connection
    "sync" => "🔄",             // Sync or update

    // Actions
    "edit" => "✏️",             // Edit or modify
    "delete" => "🗑️",           // Delete or remove
    "save" => "💾",             // Save or store
    "search" => "🔍",           // Search or find
    "filter" => "📑",           // Filter or sort
    "add" => "➕",              // Add new item
    "upload" => "⬆️",           // Upload file or data
    "download" => "⬇️",         // Download file or data
    "share" => "↗️",            // Share content
    "print" => "🖨️",           // Print document
    "refresh" => "🔄",          // Refresh or reload
    "undo" => "↩️",             // Undo action
    "redo" => "↪️",             // Redo action
    "copy" => "📋",             // Copy or duplicate
    "paste" => "📋",            // Paste content
    "archive" => "🗄️",         // Archive or store
    "approve" => "✅",           // Approve or accept
    "reject" => "🚫",           // Reject or deny

    // User and Profile
    "user" => "👤",             // User or profile
    "team" => "👥",             // Group or team
    "admin" => "🛠️",           // Admin or settings
    "logout" => "🚪",           // Log out
    "login" => "🔑",            // Log in
    "lock" => "🔒",             // Secure or locked
    "unlock" => "🔓",           // Unlocked or accessible
    "profile" => "🪪",          // User profile or ID
    "guest" => "🧑‍💼",         // Guest or anonymous user

    // Navigation
    "home" => "🏠",             // Home page or dashboard
    "back" => "⬅️",            // Go back
    "forward" => "➡️",         // Go forward
    "menu" => "☰",             // Menu or hamburger
    "settings" => "⚙️",        // Settings or configuration
    "dashboard" => "📊",        // Dashboard or analytics
    "calendar" => "📅",         // Calendar or scheduling
    "clock" => "⏰",            // Time or deadline
    "map" => "🗺️",             // Location or map
    "globe" => "🌍",            // Global or language
    "dark_mode" => "🌙",        // Dark mode toggle
    "light_mode" => "☀️",       // Light mode toggle

    // Communication
    "email" => "✉️",            // Email or message
    "chat" => "💬",             // Chat or messaging
    "call" => "📞",             // Phone call
    "notification" => "🔔",     // Notification or alert
    "comment" => "💭",          // Comment or feedback
    "attachment" => "📎",       // File attachment
    "mention" => "@️",           // Mention or tag user
    " voicemail" => "📼",       // Voicemail or recording

    // Sales and CRM Specific
    "deal" => "🤝",             // Deal or agreement
    "lead" => "🎯",             // Lead or prospect
    "pipeline" => "📈",         // Sales pipeline
    "invoice" => "💳",          // Invoice or billing
    "payment" => "💸",          // Payment or transaction
    "discount" => "🏷️",        // Discount or offer
    "cart" => "🛒",             // Shopping cart
    "money" => "💰",            // Money or revenue
    "refund" => "↩️",           // Refund or return
    "subscription" => "🔁",     // Subscription or recurring
    "loyalty" => "🎁",          // Loyalty or rewards program

    // HRM Specific
    "employee" => "💼",         // Employee or staff
    "attendance" => "🕒",       // Attendance or check-in
    "leave" => "🏖️",           // Leave or vacation
    "payroll" => "📋",          // Payroll or salary
    "training" => "🎓",         // Training or learning
    "performance" => "📉",      // Performance or review
    "recruitment" => "🔎",      // Hiring or recruitment
    "onboarding" => "📚",       // Onboarding or orientation

    // Feedback and Engagement
    "star" => "⭐",              // Rating or favorite
    "heart" => "❤️",            // Like or love
    "thumbs_up" => "👍",        // Approve or like
    "thumbs_down" => "👎",      // Disapprove or dislike
    "fire" => "🔥",             // Trending or hot
    "bookmark" => "🔖",         // Bookmark or save
    "flag" => "🚩",             // Flag or report
    "clap" => "👏",             // Appreciation or clap
    "smile" => "😊",            // Positive feedback

    // Files and Media
    "file" => "📄",             // Generic file
    "folder" => "📁",           // Folder or directory
    "image" => "🖼️",           // Image or photo
    "video" => "🎥",            // Video or movie
    "audio" => "🎵",            // Audio or music
    "pdf" => "📕",              // PDF document
    "zip" => "🗜️",             // Compressed file
    "spreadsheet" => "📊",      // Spreadsheet or table
    "presentation" => "📽️",    // Presentation or slides

    // Security and Compliance
    "encryption" => "🔐",       // Encrypted or secure data
    "compliance" => "📜",       // Compliance or legal
    "privacy" => "🕵️",         // Privacy or anonymity
    "audit" => "🔍",            // Audit or review

    // Social Media and Connectivity
    "twitter" => "🐦",          // Twitter/X integration
    "linkedin" => "💼",         // LinkedIn integration
    "facebook" => "📘",         // Facebook integration
    "instagram" => "📷",        // Instagram integration
    "external_link" => "🔗",    // External link or redirect
    "qr_code" => "📷",          // QR code scanner or generator

    // Collaboration and Workflow
    "workflow" => "🔄",         // Workflow or process
    "task" => "📋",             // Task or to-do
    "project" => "📅",          // Project or milestone
    "collaboration" => "🤝",    // Collaboration or teamwork
    "meeting" => "📅",          // Meeting or appointment
    "kanban" => "📊",           // Kanban board or agile

    // Mobile-Specific Features
    "camera" => "📸",           // Camera or photo capture
    "location" => "📍",         // Location or GPS
    "barcode" => "📶",          // Barcode scanner
    "voice" => "🎙️",           // Voice input or assistant

    // Accessibility and Inclusivity
    "accessibility" => "♿",     // Accessibility features
    "language" => "🗣️",        // Language or translation
    "text_size" => "🔠",        // Text size or font adjustment

    // Miscellaneous
    "tag" => "🏷️",             // Tag or category
    "link" => "🔗",             // Hyperlink or URL
    "code" => "💻",             // Code or development
    "analytics" => "📊",        // Analytics or reports
    "rocket" => "🚀",           // Launch or start
    "trophy" => "🏆",           // Achievement or reward
    "lightbulb" => "💡",        // Idea or innovation
    "ai" => "🧠",               // AI or machine learning
    "bug" => "🐞",              // Bug or issue reporting
    "support" => "🆘",          // Support or helpdesk
    "feedback" => "📝",         // Feedback or survey
]);
