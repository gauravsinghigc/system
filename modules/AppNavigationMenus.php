<?php

//main header navigation menus
DEFINE("NAVIGATION_MENUS",  [
    "Home" => [
        "url" => DOMAIN . "/app",
        "icon" => "home",
        "title" => "Dashboard",
        "counts" => "0"
    ],
    "Tools" => [
        "url" => DOMAIN . "/app/tools",
        "icon" => "calculator",
        "title" => "Calculators",
        "counts" => "0"
    ],
    "Enquiries" => [
        "url" => DOMAIN . "/app/enquiries",
        "icon" => "info-circle",
        "title" => "Enquiries",
        "counts" => "0"
    ],
    "Leads" => [
        "url" => DOMAIN . "/app/leads",
        "icon" => "star",
        "title" => "Leads",
        "counts" => "0"
    ],
    "customers" => [
        "url" => DOMAIN . "/app/customers",
        "icon" => "users",
        "title" => "Customers",
        "counts" => "0"
    ],
    "Estimates" => [
        "url" => DOMAIN . "/app/estimates",
        "icon" => "file",
        "title" => "Estimates",
        "counts" => "0"
    ],
    "Projects" => [
        "url" => DOMAIN . "/app/projects",
        "icon" => "product-hunt",
        "title" => "Projects",
        "counts" => "0"
    ],
    "Invoices" => [
        "url" => DOMAIN . "/app/invoices",
        "icon" => "file-pdf-o",
        "title" => "Invoices",
        "counts" => "0"
    ],
    "Transactions" => [
        "url" => DOMAIN . "/app/transactions",
        "icon" => "exchange",
        "title" => "Transactions",
        "counts" => "0"
    ],
    "Vendors" => [
        "url" => DOMAIN . "/app/vendors",
        "icon" => "industry",
        "title" => "Vendors",
        "counts" => "0"
    ],
    "Contracts" => [
        "url" => DOMAIN . "/app/contracts",
        "icon" => "columns",
        "title" => "Contracts",
        "counts" => "0"
    ],
    "Materials" => [
        "url" => DOMAIN . "/app/materials",
        "icon" => "table",
        "title" => "Materials",
        "counts" => "0"
    ],
    "Activities" => [
        "url" => DOMAIN . "/app/tasks",
        "icon" => "check-square-o",
        "title" => "Activities",
        "counts" => "0"
    ],
    "Business" => [
        "url" => DOMAIN . "/app/businesses",
        "icon" => "building-o",
        "title" => "Business",
        "counts" => "0"
    ],
    "Jobs" => [
        "url" => DOMAIN . "/app/open-jobs",
        "icon" => "code-fork",
        "title" => "Open Jobs",
        "counts" => "0"
    ],
    "Helpdesk" => [
        "url" => DOMAIN . "/app/support",
        "icon" => "ticket",
        "title" => "Help Desk",
        "counts" => "0"
    ],
    "Notifications" => [
        "url" => DOMAIN . "/app/notifications",
        "icon" => "bell",
        "title" => "Notifications",
        "counts" => "0"
    ],
    "users" => [
        "url" => DOMAIN . "/app/users",
        "icon" => "briefcase",
        "title" => "All Users",
        "counts" => "0"
    ],
    "Tasks" => [
        "url" => DOMAIN . "/app/tasks",
        "icon" => "tasks",
        "title" => "Tasks",
        "counts" => "0"
    ],
    "Attandance" => [
        "url" => DOMAIN . "/app/attandance",
        "icon" => "calendar",
        "title" => "Attandance",
        "counts" => "0"
    ],
    "Payroll" => [
        "url" => DOMAIN . "/app/payroll",
        "icon" => "google-wallet",
        "title" => "Payroll",
        "counts" => "0"
    ],
    "Assets" => [
        "url" => DOMAIN . "/app/assets",
        "icon" => "table",
        "title" => "Assets",
        "counts" => "0"
    ],
    "Expanses" => [
        "url" => DOMAIN . "/app/expanses",
        "icon" => "exchange",
        "title" => "Expanses",
        "counts" => "0"
    ],
    "Events" => [
        "url" => DOMAIN . "/app/events",
        "icon" => "arrows",
        "title" => "Events",
        "counts" => "0"
    ],
    "Marketing" => [
        "url" => DOMAIN . "/app/marketing",
        "icon" => "bookmark",
        "title" => "Promotions",
        "counts" => "0"
    ],
    "Reports" => [
        "url" => DOMAIN . "/app/reports",
        "icon" => "pie-chart",
        "title" => "Reports",
        "counts" => "0"
    ],
    "Profile" => [
        "url" => DOMAIN . "/app/profile",
        "icon" => "user",
        "title" => "Profile",
        "counts" => "0"
    ],
    "settings" => [
        "url" => DOMAIN . "/app/settings",
        "icon" => "gears",
        "title" => "Configurations",
        "counts" => "0"
    ],
    "Logout" => [
        "url" => DOMAIN . "/auth/logout",
        "icon" => "sign-out",
        "title" => "Logout",
        "counts" => "0"
    ]
]);

//tools menus
define(
    "TOOLS_MENU",
    $calculators = [
        "all_available_tools" => [
            "name" => "All Available Tools",
            "url" => "/tools",
            "desc" => "",
            "icon" => "all_available_tools.png"
        ],
        "area_and_volume_calculator" => [
            "name" => "Area and Volume Calculator",
            "url" => "/tools/area-and-volume-calculator",
            "desc" => "Calculate the area and volume of a space for construction or renovation planning.",
            "icon" => "area_and_volume_calculator.png",
        ],
        "brick_calculator" => [
            "name" => "Brick and Material Calculator",
            "url" => "/tools/brick-calculator",
            "desc" => "Estimate the number of bricks needed for a construction project based on dimensions.",
            "icon" => "brick_calculator.png",
        ],
        "carpet_calculator" => [
            "name" => "Carpet Calculator",
            "url" => "/tools/carpet-calculator",
            "desc" => "Determine the amount of carpet required for a room or area.",
            "icon" => "carpet_calculator.png",
        ],
        "construction_loan_calculator" => [
            "name" => "Construction Loan Calculator",
            "url" => "/tools/construction-loan-calculator",
            "desc" => "Estimate loan payments and terms for a construction project.",
            "icon" => "construction_loan_calculator.png",
        ],
        "construction_timeline_calculator" => [
            "name" => "Construction Timeline Estimate",
            "url" => "/tools/construction-timeline-calculator",
            "desc" => "Plan and schedule the timeline for a construction project.",
            "icon" => "construction_timeline_calculator.png",
        ],
        "crown_molding_calculator" => [
            "name" => "Crown Molding Calculator",
            "url" => "/tools/crown-molding-calculator",
            "desc" => "Estimate the amount of crown molding required for a room or space.",
            "icon" => "crown_molding_calculator.png",
        ],
        "deck_material_calculator" => [
            "name" => "Deck Material Calculator",
            "url" => "/tools/deck-material-calculator",
            "desc" => "Calculate the materials needed for building a deck, including wood and screws.",
            "icon" => "deck_material_calculator.png",
        ],
        "duct_size_calculator" => [
            "name" => "Duct Size Calculator",
            "url" => "/tools/duct-size-calculator",
            "desc" => "Determine the appropriate size of ducts for HVAC systems based on specifications.",
            "icon" => "duct_size_calculator.png",
        ],
        "electrical_load_calculator" => [
            "name" => "Electrical Load Calculator",
            "url" => "/tools/electrical-load-calculator",
            "desc" => "Calculate the electrical load for a building or space to ensure proper wiring.",
            "icon" => "electrical_load_calculator.png",
        ],
        "firewood_calculator" => [
            "name" => "Firewood Calculator",
            "url" => "/tools/firewood-calculator",
            "desc" => "Estimate the amount of firewood needed for heating based on usage and type of wood.",
            "icon" => "firewood_calculator.png",
        ],
        "flooring_calculator" => [
            "name" => "Flooring Calculator",
            "url" => "/tools/flooring-calculator",
            "desc" => "Determine the amount of flooring materials required for a room or area.",
            "icon" => "flooring_calculator.png",
        ],
        "foundation_calculator" => [
            "name" => "Foundation Calculator",
            "url" => "/tools/foundation-calculator",
            "desc" => "Calculate the materials needed for building a strong foundation for a structure.",
            "icon" => "foundation_calculator.png",
        ],
        "framing_calculator" => [
            "name" => "Framing Calculator",
            "url" => "/tools/framing-calculator",
            "desc" => "Estimate the materials required for framing walls and structures.",
            "icon" => "framing_calculator.png",
        ],
        "gravel_calculator" => [
            "name" => "Gravel Calculator",
            "url" => "/tools/gravel-calculator",
            "desc" => "Calculate the quantity of gravel needed for landscaping or construction projects.",
            "icon" => "gravel_calculator.png",
        ],
        "hvac_load_calculator" => [
            "name" => "HVAC Load Calculator",
            "url" => "/tools/hvac-load-calculator",
            "desc" => "Determine the heating and cooling load requirements for HVAC system sizing.",
            "icon" => "hvac_load_calculator.png",
        ],
        "insulation_calculator" => [
            "name" => "Insulation Calculator",
            "url" => "/tools/insulation-calculator",
            "desc" => "Estimate the amount of insulation needed for walls, roofs, and floors.",
            "icon" => "insulation_calculator.png",
        ],
        "joist_and_rafter_calculator" => [
            "name" => "Joist and Rafter Calculator",
            "url" => "/tools/joist-and-rafter-calculator",
            "desc" => "Calculate the dimensions and materials required for joists and rafters in construction.",
            "icon" => "joist_and_rafter_calculator.png",
        ],
        "land_affordability_calculator" => [
            "name" => "Land Affordability Calculator",
            "url" => "/tools/land-affordability-calculator",
            "desc" => "Estimate the affordability of purchasing land based on financial considerations.",
            "icon" => "land_affordability_calculator.png",
        ],
        "landscaping_sod_calculator" => [
            "name" => "Landscaping Sod Calculator",
            "url" => "/tools/landscaping-sod-calculator",
            "desc" => "Calculate the amount of sod needed for landscaping projects.",
            "icon" => "landscaping_sod_calculator.png",
        ],
        "loan_amortization_calculator" => [
            "name" => "Loan Amortization Calculator",
            "url" => "/tools/loan-amortization-calculator",
            "desc" => "Determine the amortization schedule for a loan, including interest and principal payments.",
            "icon" => "loan_amortization_calculator.png",
        ],
        "mulch_calculator" => [
            "name" => "Mulch Calculator",
            "url" => "/tools/mulch-calculator",
            "desc" => "Calculate the quantity of mulch needed for landscaping projects.",
            "icon" => "mulch_calculator.png",
        ],
        "mortgage_affordability_calculator" => [
            "name" => "Mortgage Affordability Calculator",
            "url" => "/tools/mortgage-affordability-calculator",
            "desc" => "Estimate the affordability of a mortgage based on income and expenses.",
            "icon" => "mortgage_affordability_calculator.png",
        ],
        "mortgage_insurance_calculator" => [
            "name" => "Mortgage Insurance Calculator",
            "url" => "/tools/mortgage-insurance-calculator",
            "desc" => "Calculate the cost of mortgage insurance based on loan details.",
            "icon" => "mortgage_insurance_calculator.png",
        ],
        "paint_calculator" => [
            "name" => "Paint Calculator",
            "url" => "/tools/paint-calculator",
            "desc" => "Estimate the amount of paint needed for a room or surface.",
            "icon" => "paint_calculator.png",
        ],
        "paint_coverage_calculator" => [
            "name" => "Paint Coverage Calculator",
            "url" => "/tools/paint-coverage-calculator",
            "desc" => "Determine the coverage of paint based on the area to be painted.",
            "icon" => "paint_coverage_calculator.png",
        ],
        "patio_paver_calculator" => [
            "name" => "Patio Paver Calculator",
            "url" => "/tools/patio-paver-calculator",
            "desc" => "Calculate the number of patio pavers needed for a patio or walkway.",
            "icon" => "patio_paver_calculator.png",
        ],
        "paver_calculator" => [
            "name" => "Paver Calculator",
            "url" => "/tools/paver-calculator",
            "desc" => "Estimate the materials required for installing pavers in landscaping projects.",
            "icon" => "paver_calculator.png",
        ],
        "plant_spacing_calculator" => [
            "name" => "Plant Spacing Calculator",
            "url" => "/tools/plant-spacing-calculator",
            "desc" => "Determine the optimal spacing for planting various types of plants.",
            "icon" => "plant_spacing_calculator.png",
        ],
        "plumbing_pipe_sizing_calculator" => [
            "name" => "Plumbing Pipe Sizing Calculator",
            "url" => "/tools/plumbing-pipe-sizing-calculator",
            "desc" => "Calculate the appropriate size of plumbing pipes for water distribution.",
            "icon" => "plumbing_pipe_sizing_calculator.png",
        ],
        "property_tax_calculator" => [
            "name" => "Property Tax Calculator",
            "url" => "/tools/property-tax-calculator",
            "desc" => "Estimate property taxes based on property value and tax rates.",
            "icon" => "property_tax_calculator.png",
        ],
        "project_management_cost_estimator" => [
            "name" => "Project Management Cost Estimator",
            "url" => "/tools/project-management-cost-estimator",
            "desc" => "Estimate the cost of project management services for construction projects.",
            "icon" => "project_management_cost_estimator.png",
        ],
        "remodeling_cost_estimator" => [
            "name" => "Remodeling Cost Estimator",
            "url" => "/tools/remodeling-cost-estimator",
            "desc" => "Estimate the cost of remodeling projects based on various factors.",
            "icon" => "remodeling_cost_estimator.png",
        ],
        "return_on_investment_calculator" => [
            "name" => "Return on Investment Calculator",
            "url" => "/tools/return-on-investment-calculator",
            "desc" => "Calculate the return on investment for home improvement or construction projects.",
            "icon" => "return_on_investment_calculator.png",
        ],
        "roof_pitch_calculator" => [
            "name" => "Roof Pitch Calculator",
            "url" => "/tools/roof-pitch-calculator",
            "desc" => "Determine the pitch or slope of a roof based on rise and run measurements.",
            "icon" => "roof_pitch_calculator.png",
        ],
        "roofing_calculator" => [
            "name" => "Roofing Calculator",
            "url" => "/tools/roofing-calculator",
            "desc" => "Estimate the materials needed for roofing projects, including shingles and underlayment.",
            "icon" => "roofing_calculator.png",
        ],
        "sewage_pipe_size_calculator" => [
            "name" => "Sewage Pipe Size Calculator",
            "url" => "/tools/sewage-pipe-size-calculator",
            "desc" => "Calculate the appropriate size of sewage pipes for waste disposal.",
            "icon" => "sewage_pipe_size_calculator.png",
        ],
        "shingle_calculator" => [
            "name" => "Shingle Calculator",
            "url" => "/tools/shingle-calculator",
            "desc" => "Estimate the number of roof shingles needed for roofing projects.",
            "icon" => "shingle_calculator.png",
        ],
        "sod_calculator" => [
            "name" => "Sod Calculator",
            "url" => "/tools/sod-calculator",
            "desc" => "Calculate the amount of sod needed for landscaping and lawn installation.",
            "icon" => "sod_calculator.png",
        ],
        "solar_panel_calculator" => [
            "name" => "Solar Panel Calculator",
            "url" => "/tools/solar-panel-calculator",
            "desc" => "Estimate the number of solar panels required for a solar power system.",
            "icon" => "solar_panel_calculator.png",
        ],
        "stud_calculator" => [
            "name" => "Stud Calculator",
            "url" => "/tools/stud-calculator",
            "desc" => "Calculate the number of studs needed for framing walls in construction.",
            "icon" => "stud_calculator.png",
        ],
        "tile_calculator" => [
            "name" => "Tile Calculator",
            "url" => "/tools/tile-calculator",
            "desc" => "Estimate the amount of tile needed for flooring, walls, or backsplashes.",
            "icon" => "tile_calculator.png",
        ],
        "water_flow_rate_calculator" => [
            "name" => "Water Flow Rate Calculator",
            "url" => "/tools/water-flow-rate-calculator",
            "desc" => "Calculate the flow rate of water through pipes for plumbing systems.",
            "icon" => "water_flow_rate_calculator.png",
        ],
        "water_heater_size_calculator" => [
            "name" => "Water Heater Size Calculator",
            "url" => "/tools/water-heater-size-calculator",
            "desc" => "Determine the appropriate size of a water heater based on usage and requirements.",
            "icon" => "water_heater_size_calculator.png",
        ],
        "window_efficiency_calculator" => [
            "name" => "Window Efficiency Calculator",
            "url" => "/tools/window-efficiency-calculator",
            "desc" => "Evaluate the energy efficiency of windows based on specifications.",
            "icon" => "window_efficiency_calculator.png",
        ],
        "home_insurance_coverage_calculator" => [
            "name" => "Home Insurance Calculator",
            "url" => "/tools/home-insurance-coverage-calculator",
            "desc" => "Estimate the coverage needed for home insurance based on property value and details.",
            "icon" => "home_insurance_coverage_calculator.png",
        ],
        "home_value_estimator" => [
            "name" => "Home Value Estimator",
            "url" => "/tools/home-value-estimator",
            "desc" => "Estimate the current value of a home based on various factors and market conditions.",
            "icon" => "home_value_estimator.png",
        ],
        "roi_calculator_for_home_improvements" => [
            "name" => "ROI for Home Improvements",
            "url" => "/tools/roi-calculator-for-home-improvements",
            "desc" => "Calculate the return on investment for home improvement projects.",
            "icon" => "roi_calculator_for_home_improvements.png",
        ],
    ]
);

//vendor entry menus
DEFINE(
    "VENDOR_MENUS",
    $vendorMenu = [
        'v_dashboard' => [
            'name' => 'Vendor Dashboard',
            'icon' => 'fa fa-home',
            'module' => 'view_dashboard.php'
        ],
        'v_contracts' => [
            'name' => 'Vendor Contracts',
            'icon' => 'fa fa-file-pdf',
            'module' => 'view_contracts.php'
        ],
        'v_contract_invoices' => [
            'name' => 'Vendor Contract Invoices',
            'icon' => 'fa fa-file-archive',
            'module' => 'view_contract_invoices.php'
        ],
        'v_contract_payments' => [
            'name' => 'Vendor Contract Payments',
            'icon' => 'fa fa-exchange',
            'module' => 'view_contract_payments.php'
        ],
        'v_purchase_orders' => [
            'name' => 'Vendor Purchase Orders',
            'icon' => 'fa fa-check',
            'module' => 'view_purchase_orders.php'
        ],
        'v_purchase_invoices' => [
            'name' => 'Vendor Purchase Invoices',
            'icon' => 'fa fa-file-excel',
            'module' => 'view_purchase_invoices.php'
        ],
        'v_purchase_payments' => [
            'name' => 'Vendor Purchase Payments',
            'icon' => 'fa fa-arrow-up',
            'module' => 'view_purchase_payments.php'
        ],
        'v_documents' => [
            'name' => 'Vendor Documents',
            'icon' => 'fa fa-file',
            'module' => 'view_documents.php'
        ],
        'v_products_services' => [
            'name' => 'Vendor Products/Services',
            'icon' => 'fa fa-list',
            'module' => 'view_products_services.php'
        ],
        'v_connected_members' => [
            'name' => 'Vendor Connected Members',
            'icon' => 'fa fa-users',
            'module' => 'view_connected_members.php'
        ],
        'v_addresses' => [
            'name' => 'Vendor Addresses',
            'icon' => 'fa fa-map-marker',
            'module' => 'view_addresses.php'
        ],
        'v_urls_website' => [
            'name' => 'Vendor Urls/Website',
            'icon' => 'fa fa-link',
            'module' => 'view_urls_website.php'
        ],
        'v_reviews' => [
            'name' => 'Vendor Reviews',
            'icon' => 'fa fa-star',
            'module' => 'view_reviews.php'
        ],
        'v_tasks_activities' => [
            'name' => 'Vendor Task & Activities',
            'icon' => 'fa fa-tasks',
            'module' => 'view_tasks_activities.php'
        ],
        'v_reminders_alerts' => [
            'name' => 'Vendor Reminders & Alerts',
            'icon' => 'fa fa-bell',
            'module' => 'view_reminders_alerts.php'
        ],
        'v_accounts_ledger' => [
            'name' => 'Vendor Accounts & Ledger',
            'icon' => 'fa fa-calculator',
            'module' => 'view_accounts_ledger.php'
        ],
        'v_profile' => [
            'name' => 'Vendor Profile',
            'icon' => 'fa fa-user',
            'module' => 'view_profile.php'
        ],
        'v_support' => [
            'name' => 'Vendor Support & Helpdesk',
            'icon' => 'fa fa-info-circle',
            'module' => 'view_helpdesk.php'
        ],
        'v_logs' => [
            'name' => 'Vendor Logs',
            'icon' => 'fa fa-tachometer',
            'module' => 'view_logs.php'
        ]
    ]
);

//types of enquiries
DEFINE("ENQUIRY_MENUS", [
    "enquiry_1" => [
        'name' => 'Website Enquiries',
        'dir' => 'website_enquiries.php',
        'icon' => "globe"
    ],
    "enquiry_2" => [
        'name' => 'Contact Us Enquiries',
        'dir' => 'contact_us_enquiries.php',
        'icon' => "phone"
    ],
    "enquiry_3" => [
        'name' => 'Support Enquiries',
        'dir' => 'support_enquiries.php',
        'icon' => "comments"
    ],
    "enquiry_4" => [
        'name' => 'Business Enquiries',
        'dir' => 'business_enquiries.php',
        'icon' => "building"
    ],
    "enquiry_5" => [
        'name' => 'Customers Enquiries',
        'dir' => 'customers_enquiries.php',
        'icon' => "users"
    ],
    "enquiry_6" => [
        'name' => 'Joining/Vacancy Enquiries',
        'dir' => 'joining_vacancy_enquiries.php',
        'icon' => "building-o"
    ],
    "enquiry_7" => [
        'name' => 'Vendor Enquiries',
        'dir' => 'vendor_enquiries.php',
        'icon' => "user-plus"
    ],
    "enquiry_8" => [
        'name' => 'Marketing/Advertising Enquiries',
        'dir' => 'marketing_advertising_enquiries.php',
        'icon' => "bullhorn"
    ],
    "enquiry_9" => [
        'name' => 'General Inquiries',
        'dir' => 'general_inquiries.php',
        'icon' => "info-circle"
    ],
    "enquiry_10" => [
        'name' => 'Feedback/Complaints',
        'dir' => 'feedback_complaints.php',
        'icon' => "comments-o"
    ],
    "enquiry_11" => [
        'name' => 'Technical Support Enquiries',
        'dir' => 'technical_support_enquiries.php',
        'icon' => "question-circle"
    ],
    "enquiry_12" => [
        'name' => 'Sales Enquiries',
        'dir' => 'sales_enquiries.php',
        'icon' => "money"
    ],
    "enquiry_13" => [
        'name' => 'Reviews Submission',
        'dir' => 'reviews_submission.php',
        'icon' => "star-half-o"
    ]
]);


//customer menus
define(
    "CUSTOMER_MENUS",
    [
        'link1' => [
            'dir' => DOMAIN . '/account',
            'icon' => 'fa-tachometer',
            'name' => 'My Dashboard'
        ],
        'link2' => [
            'dir' => DOMAIN . '/account/published-work',
            'icon' => 'fa-list',
            'name' => 'Published Works'
        ],
        'link3' => [
            'dir' => DOMAIN . '/account/orders',
            'icon' => 'fa-table',
            'name' => 'My Orders'
        ],
        'link4' => [
            'dir' => DOMAIN . '/account/activities',
            'icon' => 'fa-tasks',
            'name' => 'All Activities'
        ],
        'link5' => [
            'dir' => DOMAIN . '/account/invoices',
            'icon' => 'fa-file-pdf-o',
            'name' => 'Invoices'
        ],
        'link6' => [
            'dir' => DOMAIN . '/account/transactions',
            'icon' => 'fa-exchange',
            'name' => 'Transactions'
        ],
        'link7' => [
            'dir' => DOMAIN . '/account/support',
            'icon' => 'fa-info-circle',
            'name' => 'Support'
        ],
        'link8' => [
            'dir' => DOMAIN . '/account/notifications',
            'icon' => 'fa-bell',
            'name' => 'Notifications'
        ],
        'link9' => [
            'dir' => DOMAIN . '/account/settings',
            'icon' => 'fa-user',
            'name' => 'Profile'
        ],
        'link10' => [
            'dir' => DOMAIN . '/auth/logout',
            'icon' => 'fa-sign-out',
            'name' => 'Logout'
        ]
    ]
);

//about page menus
define(
    "ABOUT_RSOR_MENUS",
    [
        'link1' => [
            'dir' => DOMAIN . '/about-rsor-india',
            'icon' => 'fa-arrow-right',
            'name' => 'About ' . APP_NAME
        ],
        'link2' => [
            'dir' => DOMAIN . '/about-rsor-india/history',
            'icon' => 'fa-arrow-right',
            'name' => APP_NAME . ' History'
        ],
        'link3' => [
            'dir' => DOMAIN . '/about-rsor-india/mission-and-vision',
            'icon' => 'fa-arrow-right',
            'name' => APP_NAME . ' Mission & Vision'
        ],
        'link4' => [
            'dir' => DOMAIN . '/about-rsor-india/team',
            'icon' => 'fa-arrow-right',
            'name' => APP_NAME . ' Team'
        ],
        'link5' => [
            'dir' => DOMAIN . '/about-rsor-india/customer-reviews',
            'icon' => 'fa-arrow-right',
            'name' => APP_NAME . ' Testimonials / Customer Reviews'
        ],
        'link6' => [
            'dir' => DOMAIN . '/about-rsor-india/award-and-archievements',
            'icon' => 'fa-arrow-right',
            'name' => APP_NAME . ' Award & Achievements'
        ],
        'link7' => [
            'dir' => DOMAIN . '/about-rsor-india/press-and-media',
            'icon' => 'fa-arrow-right',
            'name' => APP_NAME . ' Press & Media'
        ],
        'link8' => [
            'dir' => DOMAIN . '/about-rsor-india/work-environment',
            'icon' => 'fa-arrow-right',
            'name' => APP_NAME . ' Work Environment'
        ],
        'link9' => [
            'dir' => DOMAIN . '/about-rsor-india/marketing-material-partner-vendor',
            'icon' => 'fa-arrow-right',
            'name' => APP_NAME . ' Partners & Vendors'
        ]
    ]
);
