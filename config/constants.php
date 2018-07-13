<?php

return [
    'credentials' => [
        'email' => 'email',
        'password' => 'password',
        'transactionsRetentionInterval' => 'transactionsRetentionInterval',
        'transactionDetailsRetentionInterval' => 'transactionDetailsRetentionInterval'
    ],
    'apiResponse' => [
            'LANDING_CRON_IS_NOT_RUNNING' => "Pricemonitor plugin detected that cron jobs are not working as expected. Please check your server configuration in order to allow plugin to work properly.",
            'AUTHORIZATION_INVALID_CREDENTIALS' => 'Invalid credentials. Failed to login to Pricemonitor account.',
            'REQUEST_METHOD_NOT_ALLOWED' => 'Unknown request method.',
            'REQUEST_INVALID_CONTRACT_ID' => 'Invalid pricemonitor contract ID.',
            'ACCOUNT_INVALID_TRANSACTION_HISTORY_RETENTION' => 'Invalid transaction history retention params.',
            'ACCOUNT_SAVED_SUCCESSFULLY' => 'Account configuration is saved successfully.',
            'CONTRACT_INVALID_PARAMS' => 'Mandatory attributes must be set.',
            'CONTRACT_SAVE_FAILED' => 'Failed to save contract.',
            'CONTRACT_SAVED_SUCCESSFULLY' => 'Contract is saved successfully.',
            'ATTRIBUTES_MAPPING_INVALID_MAPPINGS' => 'Unable to save attributes mapping. Invalid mappings.',
            'ATTRIBUTES_MAPPING_UNABLE_TO_SAVE_MAPPINGS' => 'Unable to save attributes mapping.',
            'ATTRIBUTES_MAPPING_SAVED_SUCCESSFULLY' => 'Attribute mappings are saved successfully.',
            'FILTER_PRICEMONITOR_ID_AND_TYPE_MISSING' => 'pricemonitorId and filterType are required fields.',
            'FILTER_TYPE_NOT_ALLOWED' => 'Not allowed filter type.',
            'FILTER_INVALID_PARAMS' => 'Mandatory attributes must be set.',
            'FILTER_SAVED_SUCCESSFULLY' => 'Filters are saved successfully.',
            'FILTER_INVALID_LIMIT_AND_OFFSET'=> 'Limit and offset must be non negative integer.',
            'FILTER_INVALID_OPERATOR_AND_GROUP_OPERATOR' => 'Operator and group operator must be provided.',
            'FILTER_INVALID_EXPRESSIONS' => 'Expressions must be provided and must be type of array.',
            'FILTER_UNSUPPORTED_OPERATOR' => 'Unsupported operator "%s" is provided.',
            'FILTER_UNSUPPORTED_GROUP_OPERATOR' => 'Unsupported group operator "%s" is provided.',
            'FILTER_EXPRESSION_INVALID_PARAMS' => 'Condition, value, type and attribute code must be provided.',
            'FILTER_EXPRESSION_VALUE_IS_NOT_ARRAY' => 'Provided value "%s" is not an array for filter group %s.',
            'FILTER_EXPRESSION_UNSUPPORTED_CONDITION' => 'Unsupported condition "%s" is provided for filter group %s.',
            'FILTER_EXPRESSION_UNKNOWN_ATTRIBUTE_CODE' => 'Unknown attribute code "%s" is provided for filter group %s.',
            'FILTER_EXPRESSION_INVALID_TYPE' => 'Provided type "%s" does not match "%s".',
            'PRICE_IMPORT_STARTED' => 'Product import has been started.',
            'PRICE_IMPORT_SCHEDULE_SAVED_SUCCESSFULLY' => 'Price import schedule is saved successfully.',
            'PRICE_IMPORT_UNABLE_TO_REGISTER_CALLBACKS' => 'Unable to register callbacks.',
            'PRODUCT_EXPORT_STARTED' => 'Product export has been started.',
            'PRODUCT_EXPORT_SCHEDULE_SAVED_SUCCESSFULLY' => 'Product export schedule is saved successfully.'
    ],
    'filterType' => [
        'EXPORT_PRODUCTS' => 'export_products',
        'IMPORT_PRICES' => 'import_prices'
    ]
];