export const HOME_NAV_TABS = [
  {
    id: 1,
    caption: 'Select Unit',
    pageUrl: '/home/select-unit',
    iconSrc: require('assets/images/icons/home/cube.svg'),
  },
  {
    id: 2,
    caption: 'Close Register',
    pageUrl: '/home/close-register',
    iconSrc: require('assets/images/icons/home/window-close.svg'),
    permission: {
      'slugName': 'close-register',
      'permissionType': 'CREATE'
    }
  },
  {
    id: 3,
    caption: 'Catering Sales',
    pageUrl: '/home/catering-sales',
    iconSrc: require('assets/images/icons/home/room_service.svg'),
    permission: {
      'slugName': 'catering-sales',
      'permissionType': 'CREATE'
    }
  },
  {
    id: 4,
    caption: 'Purchase Orders',
    pageUrl: '/home/purchase-orders',
    iconSrc: require('assets/images/icons/home/order.svg'),
    permission: {
      'slugName': 'purchase-orders',
      'permissionType': 'CREATE'
    }
  },
  {
    id: 5,
    caption: 'Inventory',
    pageUrl: '/home/inventory',
    iconSrc: require('assets/images/icons/home/inventory.svg'),
    permission: {
      'slugName': 'inventory',
      'permissionType': 'VIEW'
    }
  },
  {
    id: 6,
    caption: 'Expenses',
    pageUrl: '/home/expenses',
    iconSrc: require('assets/images/icons/home/account_balance_wallet.svg'),
    permission: {
      'slugName': 'expenses',
      'permissionType': 'CREATE'
    }
  },
  {
    id: 7,
    caption: 'On-Call Labor',
    pageUrl: '/home/on-call-labor',
    iconSrc: require('assets/images/icons/home/on-call.svg'),
    permission: {
      'slugName': 'on-call-labor',
      'permissionType': 'CREATE'
    }
  },
  {
    id: 8,
    caption: 'ReAccruals',
    pageUrl: '/home/reaccruals',
    iconSrc: require('assets/images/icons/home/chart-line.svg'),
    permission: {
      'slugName': 'reaccruals',
      'permissionType': 'VIEW'
    }
  },
  {
    id: 9,
    caption: 'Payroll',
    pageUrl: '/home/payroll',
    iconSrc: require('assets/images/icons/home/payroll.svg'),
    permission: {
      'slugName': 'payroll',
      'permissionType': 'VIEW'
    }
  },
]

export const REVIEW_NAV_TABS = [
  {
    id: 1,
    caption: 'Register Closeout',
    pageUrl: '/review/register-closeout',
    iconSrc: require('assets/images/icons/review/period.svg'),
    permission: {
      'slugName': 'close-register',
      'permissionType': 'VIEW'
    }
  },
  {
    id: 2,
    caption: 'Catering Sales',
    pageUrl: '/review/catering-sales',
    iconSrc: require('assets/images/icons/review/period.svg'),
    permission: {
      'slugName': 'catering-sales',
      'permissionType': 'VIEW'
    }
  },
  {
    id: 3,
    caption: 'Weekly Purchases',
    pageUrl: '/review/weekly-purchases',
    iconSrc: require('assets/images/icons/review/period.svg'),
    permission: {
      'slugName': 'purchase-orders',
      'permissionType': 'VIEW'
    }
  },
  {
    id: 4,
    caption: 'Weekly Expenses',
    pageUrl: '/review/weekly-expenses',
    iconSrc: require('assets/images/icons/review/period.svg'),
    permission: {
      'slugName': 'expenses',
      'permissionType': 'VIEW'
    }
  },
]

export const REPORTS_NAV_TABS = [
  {
    id: 1,
    caption: 'Open Report',
    pageUrl: '/reports/open-report',
    iconSrc: require('assets/images/icons/header/graph-line.svg'),
    permission: {
      'slugName': 'reports',
      'permissionType': 'VIEW'
    }
  },
]

export const ADMIN_NAV_TABS = [
  {
    id: 1,
    caption: 'Fixed Expenses',
    pageUrl: '/admin/fixed-expenses',
    iconSrc: require('assets/images/icons/admin/account_balance_wallet.svg'),
    permission: {
      'slugName': 'fixed-expense',
      'permissionType': 'VIEW'
    }
  },
  {
    id: 2,
    caption: 'Close week',
    pageUrl: '/admin/close-week',
    iconSrc: require('assets/images/icons/admin/date.svg'),
    permission: {
      'slugName': 'close-week',
      'permissionType': 'CREATE'
    }
  },
]

//

export const HEADER_TABS = [
  {
    id: 1,
    name: 'Home',
    src: require('assets/images/icons/header/home.svg'),
    to: '/home',
    permissionTabs: HOME_NAV_TABS,
  },
  {
    id: 2,
    name: 'Review',
    src: require('assets/images/icons/header/portfolio.svg'),
    to: '/review',
    permissionTabs: REVIEW_NAV_TABS,
  },
  {
    id: 3,
    name: 'Reports',
    src: require('assets/images/icons/header/graph-line.svg'),
    to: '/reports',
    permissionTabs: REPORTS_NAV_TABS,
  },
  {
    id: 4,
    name: 'Admin',
    src: require('assets/images/icons/header/person-circle.svg'),
    to: '/admin',
    permissionTabs: ADMIN_NAV_TABS,
  },
]

//

export const HQ_MAINTENANCE_TABS = [
  {
    id: 1,
    caption: 'Export Data',
    pageUrl: '/hq-maintenance/export-data',
    iconSrc: require('assets/images/icons/hqIcons/export-purchases.svg'),
  },
]

export const HQ_UNITS_TABS = [
  {
    id: 1,
    caption: 'Units',
    pageUrl: '/hq-unit-setup/unit-info',
    iconSrc: require('assets/images/icons/hqIcons/export-purchases.svg'),
  },
  {
    id: 2,
    caption: 'Unit Type',
    pageUrl: '/hq-unit-setup/unit-type',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 3,
    caption: 'Registers',
    pageUrl: '/hq-unit-setup/registers',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 4,
    caption: 'Unit Vendor',
    pageUrl: '/hq-unit-setup/unit-vendor',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 5,
    caption: 'Unit GL',
    pageUrl: '/hq-unit-setup/unit-gl',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 6,
    caption: 'Unit Period Status',
    pageUrl: '/hq-unit-setup/unit-period-status',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
]

export const HQ_REPORT_TABS = [
  {
    id: 1,
    caption: 'Multi Unit Labor Report',
    pageUrl: '/hq-reports/labor-schedule-report',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 2,
    caption: 'Weekly Operating Reports',
    pageUrl: '/hq-reports/weekly-operating-reports',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 3,
    caption: 'Monthly Operating Reports',
    pageUrl: '/hq-reports/monthly-operating-reports',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 4,
    caption: 'Closed Units',
    pageUrl: '/hq-reports/closed-units',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
]

export const HQ_ACCOUNTING = [
  {
    id: 1,
    caption: 'State',
    pageUrl: '/hq-accounting/state',
    iconSrc: require('assets/images/icons/hqIcons/export-purchases.svg'),
  },
  {
    id: 2,
    caption: 'County',
    pageUrl: '/hq-accounting/county',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 3,
    caption: 'City',
    pageUrl: '/hq-accounting/city',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 4,
    caption: 'District',
    pageUrl: '/hq-accounting/district',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 5,
    caption: 'Vendor',
    pageUrl: '/hq-accounting/vendor',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 6,
    caption: 'Roles',
    pageUrl: '/hq-accounting/roles',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 7,
    caption: 'Users',
    pageUrl: '/hq-accounting/users',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 8,
    caption: 'Periods',
    pageUrl: '/hq-accounting/periods',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 9,
    caption: 'Expense Types',
    pageUrl: '/hq-accounting/expense-types',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 10,
    caption: 'Inventory Categories',
    pageUrl: '/hq-accounting/inventory-categories',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 11,
    caption: 'Terms',
    pageUrl: '/hq-accounting/terms',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
  {
    id: 12,
    caption: 'Calculation Codes',
    pageUrl: '/hq-accounting/calculation-codes',
    iconSrc: require('assets/images/icons/hqIcons/default.svg'),
  },
]

//

export const HQ_HEADER_TABS = [
  {
    id: 1,
    name: 'Maintenance',
    src: require('assets/images/icons/hqHeader/maintenance.svg'),
    to: '/hq-maintenance',
    permissionTabs: HQ_MAINTENANCE_TABS
  },
  {
    id: 2,
    name: 'Unit Setup',
    src: require('assets/images/icons/hqHeader/units.svg'),
    to: '/hq-unit-setup',
    permissionTabs: HQ_UNITS_TABS
  },
  {
    id: 3,
    name: 'Reports',
    src: require('assets/images/icons/hqHeader/reports.svg'),
    to: '/hq-reports',
    permissionTabs: HQ_REPORT_TABS
  },
  {
    id: 4,
    name: 'Accounting',
    src: require('assets/images/icons/hqHeader/accounting.svg'),
    to: '/hq-accounting',
    permissionTabs: HQ_ACCOUNTING
  },
]
