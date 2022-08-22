<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'array' => 'The :attribute must have between :min and :max items.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute must be between :min and :max.',
        'string' => 'The :attribute must be between :min and :max characters.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'The :attribute must have more than :value items.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'numeric' => 'The :attribute must be greater than :value.',
        'string' => 'The :attribute must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute must have :value items or more.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'array' => 'The :attribute must have less than :value items.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'numeric' => 'The :attribute must be less than :value.',
        'string' => 'The :attribute must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute must not have more than :value items.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'array' => 'The :attribute must not have more than :max items.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'numeric' => 'The :attribute must not be greater than :max.',
        'string' => 'The :attribute must not be greater than :max characters.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'array' => 'The :attribute must have at least :min items.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'numeric' => 'The :attribute must be at least :min.',
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'array' => 'The :attribute must contain :size items.',
        'file' => 'The :attribute must be :size kilobytes.',
        'numeric' => 'The :attribute must be :size.',
        'string' => 'The :attribute must be :size characters.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'cateringOrderInput.items.create.*.menuItem' => [
            'required' => 'The menu item field is required.',
            'max' => 'The menu item must not be greater than :max characters.'
        ],
        'cateringOrderInput.items.create.*.price' => [
            'regex' => 'The price format is invalid.',
        ],
        'cateringOrderInput.items.create.*.ext' => [
            'regex' => 'The ext format is invalid.',
        ],

        'cateringOrderInput.items.update.*.menuItem' => [
            'filled' => 'The menu item field must have a value.',
            'max' => 'The menu item must not be greater than :max characters.'
        ],
        'cateringOrderInput.items.update.*.price' => [
            'regex' => 'The price format is invalid.',
        ],
        'cateringOrderInput.items.update.*.ext' => [
            'regex' => 'The ext format is invalid.',
        ],

        'PurchaseInput.items.create.*.amount' => [
            'regex' => 'The amount format is invalid.',
        ],
        'PurchaseInput.items.create.*.glAccount.connect' => [
            'required' => 'The gl account field is required.',
            'exists' => 'The selected gl account is invalid.',
        ],
        'PurchaseInput.items.create.*.inventoryCategory.connect' => [
            'required' => 'The inventory category field is required.',
            'exists' => 'The selected inventory category is invalid.',
        ],
        'PurchaseInput.items.update.*.amount' => [
            'regex' => 'The amount format is invalid.',
        ],
        'PurchaseInput.items.update.*.glAccount.connect' => [
            'required' => 'The gl account field is required.',
            'exists' => 'The selected gl account is invalid.',
        ],
        'PurchaseInput.items.update.*.inventoryCategory.connect' => [
            'required' => 'The inventory category field is required.',
            'exists' => 'The selected inventory category is invalid.',
        ],

        'registerCloseoutInput.items.create.*.glAccountId' => [
            'required' => 'The gl account field is required.',
        ],
        'registerCloseoutInput.items.create.*.amount' => [
            'regex' => 'The amount format is invalid.',
        ],
        'registerCloseoutInput.items.update.*.glAccountId' => [
            'filled' => 'The gl account field must have a value.',
        ],
        'registerCloseoutInput.items.update.*.amount' => [
            'regex' => 'The amount format is invalid.',
        ],

        'termInput.vendors.sync.*' => [
            'exists' => 'The selected vendor is invalid.',
        ],
        'termInput.vendors.syncWithoutDetaching.*' => [
            'exists' => 'The selected vendor is invalid.',
        ],
        'termInput.vendors.disconnect.*' => [
            'exists' => 'The selected vendor is invalid.',
        ],

        'unitInput.users.sync.*' => [
            'exists' => 'The selected user is invalid.',
        ],
        'unitInput.users.syncWithoutDetaching.*' => [
            'exists' => 'The selected user is invalid.',
        ],
        'unitInput.users.disconnect.*' => [
            'exists' => 'The selected user is invalid.',
        ],

        'unitInput.vendors.sync.*' => [
            'exists' => 'The selected vendor is invalid.',
        ],
        'unitInput.vendors.syncWithoutDetaching.*' => [
            'exists' => 'The selected vendor is invalid.',
        ],
        'unitInput.vendors.disconnect.*' => [
            'exists' => 'The selected vendor is invalid.',
        ],

        'unitInput.glAccounts.sync.*' => [
            'exists' => 'The selected gl account is invalid.',
        ],
        'unitInput.glAccounts.syncWithoutDetaching.*' => [
            'exists' => 'The selected gl account is invalid.',
        ],
        'unitInput.glAccounts.disconnect.*' => [
            'exists' => 'The selected gl account is invalid.',
        ],

        'vendorInput.terms.sync.*' => [
            'exists' => 'The selected term is invalid.',
        ],
        'vendorInput.terms.syncWithoutDetaching.*' => [
            'exists' => 'The selected term is invalid.',
        ],
        'vendorInput.terms.disconnect.*' => [
            'exists' => 'The selected term is invalid.',
        ],

        'input.units.*' => [
            'exists' => 'The selected unit is invalid.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'cateringOrderInput.description' => '"Details / Description"',
        'cateringOrderInput.phoneNumber' => '"Details / Phone Number"',
        'cateringOrderInput.orderBy' => '"Details / Order By"',
        'cateringOrderInput.orderFor' => '"Details / Order For"',
        'cateringOrderInput.tax' => '"Items / Tax"',
        'cateringOrderInput.shipToName' => '"Ship To/Bill To / Ship To Name"',
        'cateringOrderInput.shipToAddress' => '"Ship To/Bill To / Ship To Address"',
        'cateringOrderInput.billToName' => '"Ship To/Bill To / Bill To Name"',
        'cateringOrderInput.billToAddress' => '"Ship To/Bill To / Bill To Address"',
        'cateringOrderInput.chargeNumber' => '"Details / Charge Number"',

        'cityInput.name' => '"City Name"',
        'cityInput.tax' => '"City Sales Tax"',
        'cityInput.state.connect' => '"State"',

        'countyInput.name' => '"County Name"',
        'countyInput.tax' => '"County Sales Tax"',
        'countyInput.state.connect' => '"State"',

        'districtInput.name' => '"District Name"',
        'districtInput.code' => '"District Code"',

        'expenseInput.comments' => '"Comments"',
        'expenseInput.expenseDate' => '"Expense date"',
        'expenseInput.glAccount.connect' => '"GL Account"',
        'expenseInput.expenseType.connect' => '"Expense Type"',
        'expenseInput.amount' => '"Amount"',
        'expenseInput.vendor.connect' => '"Vendor"',

        'expenseTypeInput.type' => '"Expense Type Name"',
        'expenseTypeInput.description' => '"Expense Type Description"',

        'fixedExpenseInput.comments' => '"Comments"',
        'fixedExpenseInput.glAccount.connect' => '"GL Account"',
        'fixedExpenseInput.amount' => '"Amount"',
        'fixedExpenseInput.monthly' => '"Monthly"',

        'GlAccountInput.name' => '"GL Account Name"',
        'GlAccountInput.glTypeCode.connect' => '"GL Type Code"',
        'GlAccountInput.parent.connect' => '"Parent Gl Account"',

        'GlTypeCodeInput.code' => '"GL Type Code"',
        'GlTypeCodeInput.description' => '"GL Type Description"',

        'inventoriesInput.id' => '"Inventory"',
        'inventoriesInput.amount' => '"Amount"',

        'inventoryCategoryInput.name' => '"Inventory Category Name"',
        'inventoryCategoryInput.vending' => '"Vending"',
        'inventoryCategoryInput.glAccount.connect' => '"GL Account"',

        'periodInput.periodEnd' => '"Period end"',
        'periodInput.year' => '"Year Number"',
        'periodInput.month' => '"Month Number"',
        'periodInput.week' => '"Week Number"',

        'PurchaseInput.number' => '"Purchase Number"',
        'PurchaseInput.date' => '"Purchase Date"',
        'PurchaseInput.vendor.connect' => '"Purchase Vendor"',

        'registerInput.code' => '"Reg Code"',
        'registerInput.name' => '"Reg Name"',
        'registerInput.bank' => '"Reg Bank"',
        'registerInput.nonResetable' => '"Non Resetable"',
        'registerInput.commission' => '"Commission"',
        'registerInput.registerType.connect' => '"Register Type"',
        'registerInput.unit.connect' => '"Unit"',

        'registerCloseoutInput.nonResetable' => '"Sales Info / Non-Resetable"',
        'registerCloseoutInput.netTotal' => '"Sales Info / Net Total"',
        'registerCloseoutInput.lastNonResetable' => '"Sales Info / Last Non-Resetable"',
        'registerCloseoutInput.netOV' => '"Sales Info / Net OV"',
        'registerCloseoutInput.totalToDistribute' => '"Sales Info / Total To Distribute"',
        'registerCloseoutInput.netCharge' => '"Sales Info / Net Charge"',
        'registerCloseoutInput.taxFromTheTape' => '"Sales Info / Tax From The Tape"',
        'registerCloseoutInput.netVoucher' => '"Sales Info / Net Voucher"',
        'registerCloseoutInput.overringVoidTax' => '"Sales Info / Overring Void Tax"',
        'registerCloseoutInput.netCash' => '"Sales Info / Net Cash"',
        'registerCloseoutInput.chargeTax' => '"Sales Info / Charge Tax"',
        'registerCloseoutInput.voucherTax' => '"Sales Info / Voucher Tax"',
        'registerCloseoutInput.cashTax' => '"Sales Info / Cash Tax"',
        'registerCloseoutInput.totalPettyCash' => '"Petty Cash / Total Tetty Cash"',
        'registerCloseoutInput.actualCashDeposit' => '"Finish Closeout / Actual Cash Deposit"',
        'registerCloseoutInput.calculatedCashDeposit' => '"Finish Closeout / Calculated Cash Deposit"',
        'registerCloseoutInput.overShort' => '"Finish Closeout / Over Short"',
        'registerCloseoutInput.customerCountBreakfast' => '"Finish Closeout / Customer Count-Breakfast"',
        'registerCloseoutInput.netSalesBreakfast' => '"Finish Closeout / Net Sales-Breakfast"',
        'registerCloseoutInput.customerCountLunch' => '"Finish Closeout / Customer Count-Lunch"',
        'registerCloseoutInput.netSalesLunch' => '"Finish Closeout / Net Sales-Lunch"',
        'registerCloseoutInput.customerCountDinner' => '"Finish Closeout / Customer Count-Dinner"',
        'registerCloseoutInput.netSalesDinner' => '"Finish Closeout / Net Sales-Dinner"',
        'registerCloseoutInput.customerCountTotals' => '"Finish Closeout / Customer Count-Totals"',
        'registerCloseoutInput.netSalesTotals' => '"Finish Closeout / Net Sales-Totals"',
        'registerCloseoutInput.closeDate' => '"Close Date"',
        'registerCloseoutInput.register.connect' => '"Register"',

        'registerTypeInput.name' => '"Register Type Name"',
        'registerTypeInput.description' => '"Register Type Description"',
        'registerTypeInput.taxType' => '"Tax Type"',
        'registerTypeInput.isVending' => '"Is Vending"',

        'stateInput.code' => '"State Code"',
        'stateInput.salesTaxCafeteria' => '"Sales Tax - Cafeteria"',
        'stateInput.salesTaxVending' => '"Sales Tax - Vending"',
        'stateInput.salesTaxRestaurant' => '"Sales Tax - Restaurant"',
        'stateInput.salesTaxStore' => '"Sales Tax - Store"',
        'stateInput.grossReceiptsTax' => '"Gross Receipts Tax"',

        'termInput.name' => '"Term Name"',
        'termInput.discPercent' => '"Disc Percent"',
        'termInput.discDays' => '"Disc Days"',
        'termInput.dueDays' => '"Due Days"',

        'unitInput.code' => '"Details / Unit Number"',
        'unitInput.name' => '"Details / Unit Name"',
        'unitInput.address' => '"Details / Unit Address"',
        'unitInput.zip' => '"Details / Zip Code"',
        'unitInput.payrollPassword' => '"Details / Payroll Password"',
        'unitInput.emailAccount' => '"Details / Email Account"',
        'unitInput.managementPercent' => '"Fees / Management Percent"',
        'unitInput.managementAmount' => '"Fees / Management Amount"',
        'unitInput.managementFeeType' => '"Fees / Management Fee Type"',
        'unitInput.administrativePercent' => '"Fees / Administrative Percent"',
        'unitInput.administrativeAmount' => '"Fees / Administrative Amount"',
        'unitInput.administrativeFeeType' => '"Fees / Administrative Fee Type"',
        'unitInput.supportPercent' => '"Fees / Support Percent"',
        'unitInput.supportAmount' => '"Fees / Support Amount"',
        'unitInput.supportFeeType' => '"Fees / Support Fee Type"',
        'unitInput.payrollTaxPercent' => '"Financials / Payroll Tax Percent"',
        'unitInput.benefitsPercent' => '"Fees / Benefits Percent"',
        'unitInput.benefitsAmount' => '"Financials / Benefits amount"',
        'unitInput.vacationAmount' => '"Financials / Vacation Amount"',
        'unitInput.businessInsuranceAmount' => '"Financials / Business Insurance Amount"',
        'unitInput.vendingIncome' => '"Financials / Vending Income"',
        'unitInput.commissionAmount' => '"Financials / Commission Amount"',
        'unitInput.commissionPercent' => '"Fees / Commission Percent"',
        'unitInput.managerFirstName' => '"Details / Manager First Name"',
        'unitInput.managerLastName' => '"Details / Manager Last Name"',
        'unitInput.sysco' => '"Details / Sysco"',
        'unitInput.regTax' => '"Fees / Reg Tax"',
        'unitInput.unitType.connect' => '"Unit Type"',
        'unitInput.district.connect' => '"District"',
        'unitInput.county.connect' => '"County"',
        'unitInput.city.connect' => '"City"',

        'unitTypeInput.name' => '"Unit Type Name"',

        'userInput.firstName' => '"First Name"',
        'userInput.lastName' => '"Last Name"',
        'userInput.email' => '"Email"',

        'vendorInput.code' => '"Vendor Number"',
        'vendorInput.name' => '"Vendor Name"',

        'input.period' => '"Period"',
        'input.district' => '"District"',
        'input.unit' => '"Unit"',

        'credentials.email' => '"Email"',
        'forgotPasswordInput.email' => '"Email"',
        'forgotPasswordInput.resetPasswordUrl' => '"Reset Password Url"',
        'resetPasswordInput.email' => '"Email"',
        'resetPasswordInput.passwordConfirmation' => '"Password Confirmation"',
    ],

];
